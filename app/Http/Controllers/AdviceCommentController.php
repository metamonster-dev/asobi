<?php

namespace App\Http\Controllers;

use App\AdviceComment;
use App\AdviceNote;
use App\Jobs\BatchPush;
use App\User;
use App\UserMemberDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class AdviceCommentController extends Controller
{
    public function index(Request $request)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereId($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        $advice_note_id = $request->input('id');
        $advice_note = AdviceNote::find($advice_note_id);

        if (empty($advice_note)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '잘못된 요청입니다.');
            return response()->json($result);
        }

        $comments = AdviceComment::where('advice_note_id', $advice_note_id)->withTrashed()->orderByRaw("
            case
                when pid is null
                then id
                when pid is not null
                then pid
            end asc,
            depth asc,
            id asc
        ")->get();

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'count', $comments->count());

        if ($comments->count()) {
            foreach ($comments as $index => $comment) {
                $result = Arr::add($result, "list.{$index}.id", $comment->id);
                $result = Arr::add($result, "list.{$index}.is_delete", ($comment->deleted_at)?true:false);
                $result = Arr::add($result, "list.{$index}.comment", ($comment->deleted_at)?"댓글이 삭제되었습니다.":$comment->comment);
                $result = Arr::add($result, "list.{$index}.date", \App::make('helper')->dateOfKoAmPm($comment->created_at));
//                $result = Arr::add($result, "list.{$index}.date2", $comment->created_at->format(AdviceComment::DATE_FORMAT));
                $result = Arr::add($result, "list.{$index}.depth", $comment->depth);
                $result = Arr::add($result, "list.{$index}.pid", $comment->pid);
                if ($comment->writer_type == 's') {
                    $writer = RaonMember::whereId($comment->sidx)->first();
                    $userMemberDetail = UserMemberDetail::where('user_id', $writer->id)->first();
                    $profile_image = $userMemberDetail->profile_image ?? '';
                    $result = Arr::add($result, "list.{$index}.is_auth", $comment->sidx == $user->id ? "Y":"N");
                    $result = Arr::add($result, "list.{$index}.writer_id", $writer->id);
                    $result = Arr::add($result, "list.{$index}.writer", $writer->name);
                    $result = Arr::add($result, "list.{$index}.writer_picture", $profile_image ? \App::make('helper')->getImage($profile_image):null);
                } else {
                    $writerId = $comment->midx;
                    if ($comment->writer_type == 'a') {
                        $writerId = 1;
                    } else if ($comment->writer_type == 'h') {
                        $writerId = $comment->hidx;
                    }
                    $writer = RaonMember::whereId($writerId)->first();
                    $userMemberDetail = UserMemberDetail::where('user_id', $writer->id)->first();
                    $profile_image = $userMemberDetail->profile_image ?? '';
                    $result = Arr::add($result, "list.{$index}.is_auth", $comment->midx == $user->id ? "Y":"N");
                    $result = Arr::add($result, "list.{$index}.writer_id", $writer->id);
                    $result = Arr::add($result, "list.{$index}.writer", $writer->nickname);
                    $result = Arr::add($result, "list.{$index}.writer_picture", $profile_image ? \App::make('helper')->getImage($profile_image) : null);
                }
            }
        }

        return response()->json($result);
    }

    public function store(Request $request)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereId($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

//        if (!in_array($user->user_type, ['a','h','m','s'])) {
//            $result = Arr::add($result, 'result', 'fail');
//            $result = Arr::add($result, 'error', '권한이 없습니다.');
//            return response()->json($result);
//        }

        $advice_note_id = $request->input('id');
        $comment = $request->input('comment');
        $pid = $request->input('pid');

        $advice_note = AdviceNote::find($advice_note_id);
        if (empty($advice_note)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '잘못된 요청입니다.');
            return response()->json($result);
        }

        $data = [
            'hidx' => $advice_note->hidx,
            'midx' => $advice_note->midx,
            'sidx' => $advice_note->sidx,
            'writer_type' => $user->user_type,
            'comment' => $comment
        ];

        if ($pid) {
            $adviceComment = AdviceComment::find($pid);
            if (empty($adviceComment)) {
                $result = Arr::add($result, 'result', 'fail');
                $result = Arr::add($result, 'error', '원글이 삭제되었습니다.');
                return response()->json($result);
            }
//            if (
//                $user->id != $adviceComment->midx && $user->id != $adviceComment->sidx
//            ) {
//                $result = Arr::add($result, 'result', 'fail');
//                $result = Arr::add($result, 'error', '권한이 없습니다.');
//                return response()->json($result);
//            }
            $data['depth'] = 2;
            $data['pid'] = $pid;
        }

        $advice_note_comment = $advice_note->comments()->create($data);
        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'error', '등록 되었습니다.');
        $result = Arr::add($result, 'id', $advice_note_comment->id);

//        \App::make('helper')->log('adviceComment', ['aaa' => $advice_note_comment->id], 'adviceComment');

//        $push = new PushMessageController('adviceComment', $advice_note_comment->id);
//        $push->push();

        BatchPush::dispatch(['type' => 'adviceComment', 'type_id' => $advice_note_comment->id, 'param' => []]);

        return response()->json($result);
    }

    public function update(Request $request, $comment_id)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereId($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

//        if (!in_array($user->user_type, ['a','h','m','s'])) {
//            $result = Arr::add($result, 'result', 'fail');
//            $result = Arr::add($result, 'error', '권한이 없습니다.');
//            return response()->json($result);
//        }

        $adviceComment = AdviceComment::find($comment_id);
        if (
            ($user->user_type == 'a' && $adviceComment->writer_type == $user->user_type)
            ||
            ($user->user_type == 'h' && $adviceComment->writer_type == $user->user_type &&  $user->id == $adviceComment->hidx)
            ||
            ($user->user_type == 'm' && $adviceComment->writer_type == $user->user_type && $user->id == $adviceComment->midx)
            ||
            ($user->user_type == 's' && $adviceComment->writer_type == $user->user_type &&  $user->id == $adviceComment->sidx)
        ) {} else {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '수정 권한이 없습니다.');
            return response()->json($result);
        }

        $comment = $request->input('comment');
        $adviceComment->comment = $comment;
        $adviceComment->save();

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'error', '수정 되었습니다.');

        return response()->json($result);
    }

    public function destroy(Request $request, $comment_id)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereId($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        $adviceComment = AdviceComment::find($comment_id);

        if (
            ($user->user_type == 'a' && $adviceComment->writer_type == $user->user_type)
            ||
            ($user->user_type == 'h' && $adviceComment->writer_type == $user->user_type &&  $user->id == $adviceComment->hidx)
            ||
            ($user->user_type == 'm' && $adviceComment->writer_type == $user->user_type && $user->id == $adviceComment->midx)
            ||
            ($user->user_type == 's' && $adviceComment->writer_type == $user->user_type &&  $user->id == $adviceComment->sidx)
        ) {} else {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '삭제 권한이 없습니다.');
            return response()->json($result);
        }

        $adviceComment->delete();
        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'error', '삭제 되었습니다.');

        return response()->json($result);
    }

}

<?php

namespace App\Http\Controllers;

use App\EducatonInfo;
use App\Event;
use App\CommonComment;
use App\Notice;
use App\User;
use App\UserMemberDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Jobs\BatchPush;

class CommonCommentController extends Controller
{
    public function store(Request $request)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = User::whereId($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        $type = $request->input('type');
        if (!in_array($type, ['1','2','3'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '올바른 타입값이 아닙니다.');
            return response()->json($result);
        }

        $type_id = $request->input('type_id');
        $comment = $request->input('comment');
        $pid = $request->input('pid');

        if ($type == "1") {
            $row = EducatonInfo::find($type_id);
        } else if ($type == "2") {
            $row = Event::find($type_id);
        } else {
            $row = Notice::find($type_id);
        }
        if (empty($row)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '댓글 등록할 게시물이 삭제되었습니다.');
            return response()->json($result);
        }

        $data = [
            'type' => $type,
            'type_id' => $type_id,
            'writer_id' => $user_id,
            'comment' => $comment,
        ];

        if ($pid) {
            $commonComment = CommonComment::find($pid);
            if (empty($commonComment)) {
                $result = Arr::add($result, 'result', 'fail');
                $result = Arr::add($result, 'error', '원글이 삭제되었습니다.');
                return response()->json($result);
            }

            $data['depth'] = 2;
            $data['pid'] = $pid;
        }
        $newCommonComment = new CommonComment($data);
        $newCommonComment->save();

//        BatchPush::dispatch(['type' => ($type == '1')?'educatonInfoComment':'eventComment', 'type_id' => $newCommonComment->id, 'param' => []]);
//        $push = new PushMessageController('educatonInfoComment', $newCommonComment->id);
//        $push->push();

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'error', '등록 되었습니다.');
        $result = Arr::add($result, 'id', $newCommonComment->id);

        return response()->json($result);
    }

    public function index(Request $request)
    {
        $result = array();

        $user_id = $request->input('user');
        $user = User::whereId($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        $type = $request->input('type');
        if (!in_array($type, ['1','2','3'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '올바른 타입값이 아닙니다.');
            return response()->json($result);
        }

        $type_id = $request->input('type_id');
        if ($type == "1") {
            $row = EducatonInfo::find($type_id);
        } else if ($type == "2") {
            $row = Event::find($type_id);
        } else {
            $row = Notice::find($type_id);
        }
        if (empty($row)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '본문 게시물이 삭제되었습니다.');
            return response()->json($result);
        }

        $comments = CommonComment::where('type', $type)->where('type_id', $type_id)->withTrashed()->orderByRaw("
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
            $index = 0;
            foreach ($comments as $comment) {
                $result = Arr::add($result, "list.{$index}.id", $comment->id);
                $result = Arr::add($result, "list.{$index}.is_delete", ($comment->deleted_at)?true:false);
                $result = Arr::add($result, "list.{$index}.comment", ($comment->deleted_at)?"댓글이 삭제되었습니다.":$comment->comment);
                $result = Arr::add($result, "list.{$index}.date", \App::make('helper')->dateOfKoAmPm($comment->created_at));
                $result = Arr::add($result, "list.{$index}.depth", $comment->depth);
                $result = Arr::add($result, "list.{$index}.pid", $comment->pid);

                $writer = User::whereId($comment->writer_id)->first();
                $userMemberDetail = UserMemberDetail::where('user_id', $writer->id)->first();
                $profile_image = $userMemberDetail->profile_image ?? '';
                $result = Arr::add($result, "list.{$index}.is_auth", $comment->writer_id == $user->id ? "Y":"N");
                $result = Arr::add($result, "list.{$index}.writer_id", $writer->id);
                $result = Arr::add($result, "list.{$index}.writer", $writer->user_type == 's' ? $writer->name : $writer->nickname);
                $result = Arr::add($result, "list.{$index}.writer_picture", $profile_image ? \App::make('helper')->getImage($profile_image):null);

                $index++;
            }
        }

        return response()->json($result);
    }

    public function update(Request $request, $type_id)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = User::whereId($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        $commonComment = CommonComment::find($type_id);
        if (empty($commonComment)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '잘못된 요청입니다.');
            return response()->json($result);
        }

        if ($commonComment->writer_id != $user->id) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        $comment = $request->input('comment');
        $commonComment->comment = $comment;
        $commonComment->save();

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'error', '수정 되었습니다.');
        $result = Arr::add($result, 'id', $commonComment->id);

        return response()->json($result);
    }

    public function destroy(Request $request, $type_id)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = User::whereId($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        $commonComment = CommonComment::find($type_id);
        if (empty($commonComment)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '잘못된 요청입니다.');
            return response()->json($result);
        }

        if ($commonComment->writer_id != $user->id) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        $commonComment->delete();
        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'error', '삭제 되었습니다.');

        return response()->json($result);
    }

}

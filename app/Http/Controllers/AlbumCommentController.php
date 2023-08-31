<?php

namespace App\Http\Controllers;

use App\Album;
use App\AlbumComment;
use App\Jobs\BatchPush;
use App\Models\RaonMember;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class AlbumCommentController extends Controller
{
    public function index(Request $request)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        $album_id = $request->input('id');
        $album = Album::find($album_id);

        if (empty($album)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '잘못된 요청입니다.');
            return response()->json($result);
        }

        $comments = AlbumComment::where('album_id', $album_id)->withTrashed()->orderByRaw("
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

                if ($comment->writer_type == 's') {
                    $writer = RaonMember::whereIdx($comment->sid)->first();
                    $userMemberDetail = RaonMember::where('idx', $writer->id)->first();
                    $profile_image = $userMemberDetail->user_picture ?? '';
                    $result = Arr::add($result, "list.{$index}.is_auth", $comment->sid == $user->idx ? "Y":"N");
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
                    $writer = RaonMember::whereIdx($writerId)->first();
                    $userMemberDetail = RaonMember::where('idx', $writer->id)->first();
                    $profile_image = $userMemberDetail->user_picture ?? '';
                    $result = Arr::add($result, "list.{$index}.is_auth", $comment->midx == $user->idx ? "Y":"N");
                    $result = Arr::add($result, "list.{$index}.writer_id", $writer->id);
                    $result = Arr::add($result, "list.{$index}.writer", $writer->nickname);
                    $result = Arr::add($result, "list.{$index}.writer_picture", $profile_image ? \App::make('helper')->getImage($profile_image):null);
                }
                $index++;
            }
        }

        return response()->json($result);
    }

    public function store(Request $request)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

//        if (!in_array($user->user_type, ['m','s'])) {
//            $result = Arr::add($result, 'result', 'fail');
//            $result = Arr::add($result, 'error', '권한이 없습니다.');
//            return response()->json($result);
//        }

        $album_id = $request->input('id');
        $comment = $request->input('comment');
        $pid = $request->input('pid');

        $album = Album::find($album_id);
        if (empty($album)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '잘못된 요청입니다.');
            return response()->json($result);
        }

        $data = [
            'hidx' => $album->hidx,
            'midx' => $album->midx,
            'sidx' => $album->sidx, //누가 볼수 있는지 권한으로 사용.
            'writer_type' => $user->mtype,
            'comment' => $comment
        ];
        //학부모일경우에 작성자의 아이디를 저장합니다.
        if ($user->mtype == 's') {
            $data['sid'] = $user->idx;
        }

        if ($pid) {
            $albumComment = AlbumComment::find($pid);
            if (empty($albumComment)) {
                $result = Arr::add($result, 'result', 'fail');
                $result = Arr::add($result, 'error', '원글이 삭제되었습니다.');
                return response()->json($result);
            }

//            $sidx = json_decode($albumComment->sidx, true);
//            if ($user->id != $albumComment->midx && !in_array($user->id, $sidx)) {
//                $result = Arr::add($result, 'result', 'fail');
//                $result = Arr::add($result, 'error', '권한이 없습니다.');
//                return response()->json($result);
//            }

            $data['depth'] = 2;
            $data['pid'] = $pid;
        }

        $album_comment = $album->comments()->create($data);

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'error', '등록 되었습니다.');
        $result = Arr::add($result, 'id', $album_comment->id);

//        $push = new PushMessageController('albumComment', $album_comment->id);
//        $push->push();

        BatchPush::dispatch(['type' => 'albumComment', 'type_id' => $album_comment->id, 'param' => []]);

        return response()->json($result);
    }

    public function update(Request $request, $comment_id)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

//        if (!in_array($user->user_type, ['m','s'])) {
//            $result = Arr::add($result, 'result', 'fail');
//            $result = Arr::add($result, 'error', '권한이 없습니다.');
//            return response()->json($result);
//        }

        $albumComment = AlbumComment::find($comment_id);
        if (empty($albumComment)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '잘못된 요청입니다.');
            return response()->json($result);
        }
        if (
            ($user->mtype == 'a' && $albumComment->writer_type == $user->mtype)
            ||
            ($user->mtype == 'h' && $albumComment->writer_type == $user->mtype &&  $user->idx == $albumComment->hidx)
            ||
            ($user->mtype == 'm' && $albumComment->writer_type == $user->mtype && $user->idx == $albumComment->midx)
            ||
            ($user->mtype == 's' && $albumComment->writer_type == $user->mtype &&  $user->idx == $albumComment->sid)
        ) {} else {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '수정 권한이 없습니다.');
//            $result = Arr::add($result, '$user->user_type', $user->user_type);
//            $result = Arr::add($result, '$albumComment->writer_type', $albumComment->writer_type);
//            $result = Arr::add($result, '$user->id', $user->id);
//            $result = Arr::add($result, '$albumComment->sidx', $albumComment->sidx);
            return response()->json($result);
        }

        $comment = $request->input('comment');
        $albumComment->comment = $comment;
        $albumComment->save();

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'error', '수정 되었습니다.');

        return response()->json($result);
    }

    public function destroy(Request $request, $comment_id)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

//        if (!in_array($user->user_type, ['m','s'])) {
//            $result = Arr::add($result, 'result', 'fail');
//            $result = Arr::add($result, 'error', '권한이 없습니다.');
//            return response()->json($result);
//        }

        $albumComment = AlbumComment::find($comment_id);
        if (empty($albumComment)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '잘못된 요청입니다.');
            return response()->json($result);
        }

        if (
            ($user->mtype == 'a' && $albumComment->writer_type == $user->mtype)
            ||
            ($user->mtype == 'h' && $albumComment->writer_type == $user->mtype &&  $user->idx == $albumComment->hidx)
            ||
            ($user->mtype == 'm' && $albumComment->writer_type == $user->mtype && $user->idx == $albumComment->midx)
            ||
            ($user->mtype == 's' && $albumComment->writer_type == $user->mtype &&  $user->idx == $albumComment->sid)
        ) {} else {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '삭제 권한이 없습니다.');
            return response()->json($result);
        }

        $albumComment->delete();
        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'error', '삭제 되었습니다.');

        return response()->json($result);
    }

}

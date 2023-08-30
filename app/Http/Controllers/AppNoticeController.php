<?php

namespace App\Http\Controllers;

use App\AppNotice;
use App\Http\Requests\AppNoticeValidation;
use App\Jobs\BatchPush;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

class AppNoticeController extends Controller
{
    //리스트
    public function index(Request $request)
    {
        $result = [];
        $user_id = $request->input('user');
        $user = User::find($user_id);

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }
        if (!in_array($user->user_type, ['a','h','m'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        $list_limit = $request->input('list_limit') ? $request->input('list_limit'):100;

        $year = $request->input('year') ? sprintf('%04d', $request->input('year')) : null;
        $month = $request->input('month') ? sprintf('%02d', $request->input('month')) : null;
        $type = $request->input('type') ?? '';
        $search_text = $request->input('search_text') ?? '';
        $search_text = trim($search_text);

        if ($type != "" && !in_array($type, ['a','h'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '잘못된 필터 타입입니다.');
            return response()->json($result);
        }

        if ($year != '' && $month != '') {
            if (! checkdate( (int)$month, 1, (int)$year )) {
                $result = Arr::add($result, 'result', 'fail');
                $result = Arr::add($result, 'error', '올바른 날짜 형식이 아닙니다.');
                return response()->json($result);
            }
        }

        if ($user->user_type == 'a') {
            $rso = AppNotice::orderByDesc('created_at')->limit($list_limit);
        } else if ($user->user_type == 'h') {
            $rso = AppNotice::where(function ($q) use ($user){
                $q->where("read_branch", 'Y');
                $q->orWhere('user_id', $user->id);
            })->orderByDesc('created_at')->limit($list_limit);
        } else if ($user->user_type == 'm') {
            $rso = AppNotice::where("read_center", 'Y')->where(function ($q) use ($user){
                $q->where('hidx', $user->branch_id);
                $q->orWhere('hidx', null);
            })->orderByDesc('created_at')->limit($list_limit);
        }
        if ($year != '' && $month != '') {
            $start = date('Y-m-d 00:00:00', strtotime($year.'-'.$month.'-01'));
            $end = date('Y-m-t 23:59:59', strtotime($start));
            $rso->whereBetween('created_at',[$start,$end]);
        }
        if ($type == 'a') {
            $rso->where("read_branch", 'Y');
        } else if ($type == 'h') {
            $rso->where("read_branch", 'N');
        }
        if ($search_text != "") {
            $rso->where(function($q) use ($search_text) {
                $q
                    ->where('title','like','%'.$search_text.'%')
                    ->orWhere('content','like','%'.$search_text.'%');
            });
        }
        $rs = $rso->get();

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'count', $rs->count());

        if ($rs) {
            foreach ($rs as $index => $row) {
                 $result = Arr::add($result, "list.{$index}.id", $row->id);
                $result = Arr::add($result, "list.{$index}.title", $row->title);
                $result = Arr::add($result, "list.{$index}.content", $row->content);
                $result = Arr::add($result, "list.{$index}.date", $row->created_at->format('m-d'));
                $result = Arr::add($result, "list.{$index}.date2", $row->created_at->format('Y.m.d')." ".\App::make('helper')->dayOfKo($row->created_at, 2));
                $result = Arr::add($result, "list.{$index}.date3", $row->created_at->format('Y.m.d'));
                $result = Arr::add($result, "list.{$index}.user_id", $row->user_id);
                $result = Arr::add($result, "list.{$index}.type", ($row->user_id == "1")?"본사":"지사");
            }
        }

        return response()->json($result);
    }

    //상세
    public function show(Request $request, $id)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = User::find($user_id);

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        $appNotice = AppNotice::where('id',$id)->first();

        if (empty($appNotice)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '조회된 내용이 없습니다.');
            return response()->json($result);
        }

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'id', $appNotice->id);
        $result = Arr::add($result, 'title', $appNotice->title);
        $result = Arr::add($result, 'content', $appNotice->content);
        $result = Arr::add($result, "date", $appNotice->created_at->format('Y-m-d H:i'));
        $result = Arr::add($result, "date2", $appNotice->created_at->format('Y.m.d')." ".\App::make('helper')->dayOfKo($appNotice->created_at, 2));
        $result = Arr::add($result, "date3", $appNotice->created_at->format('Y-m-d'));
        $result = Arr::add($result, "user_id", $appNotice->user_id);
        $result = Arr::add($result, "type", ($appNotice->user_id == "1")?"본사":"지사");

        return response()->json($result);
    }

    //등록
    public function store(Request $request)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = User::find($user_id);

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        if (!in_array($user->user_type, ['a', 'h'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        $now = Carbon::now();
        $year = $request->input('year') ? sprintf('%04d', $request->input('year')) : $now->format('Y');
        $month = $request->input('month') ? sprintf('%02d', $request->input('month')) : $now->format('m');
        $day = $request->input('day') ? sprintf('%02d', $request->input('day')) : $now->format('d');

        if (! checkdate( (int)$month, (int)$day, (int)$year )) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '올바른 날짜 형식이 아닙니다.');
            return response()->json($result);
        }

        $ymd = $year."-".$month."-".$day;
        if (strtotime($ymd) > strtotime(date('Y-m-d'))) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '작성일자는 미래일 수 없습니다.');
            return response()->json($result);
        }

        if ($user->user_type == 'a') {
            $payload = array_merge($request->only(['title', 'content']), [
                'read_branch' => 'Y',
                'read_center' => 'Y',
                'user_id' => $user->id,
                'created_at' => $ymd." ".date('H:i:s'),
            ]);
            $appNotice = new AppNotice($payload);
            $appNotice->save();

            $result = Arr::add($result, 'result', 'success');
            $result = Arr::add($result, 'error', '등록 되었습니다.');
            $result = Arr::add($result, 'appNoticeId', $appNotice->id);

//            $push = new PushMessageController('appNotice', $appNotice->id);
//            $push->push();
        } else if ($user->user_type == 'h') {
            $payload = array_merge($request->only(['title', 'content']), [
                'hidx' => $user->id,
                'read_branch' => 'N',
                'read_center' => 'Y',
                'user_id' => $user->id,
                'created_at' => $year."-".$month."-".$day." ".date('H:i:s'),
            ]);
            $appNotice = new AppNotice($payload);
            $appNotice->save();

            $result = Arr::add($result, 'result', 'success');
            $result = Arr::add($result, 'error', '등록 되었습니다.');
            $result = Arr::add($result, 'appNoticeId', $appNotice->id);

//            $push = new PushMessageController('appNotice', $appNotice->id);
//            $push->push();
        }

        BatchPush::dispatch(['type' => 'appNotice', 'type_id' => $appNotice->id, 'param' => []]);

        return response()->json($result);
    }

    //수정
    public function update(Request $request, $notice_id)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = User::find($user_id);

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        if (!in_array($user->user_type, ['a', 'h'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        $now = Carbon::now();
        $year = $request->input('year') ? sprintf('%04d', $request->input('year')) : $now->format('Y');
        $month = $request->input('month') ? sprintf('%02d', $request->input('month')) : $now->format('m');
        $day = $request->input('day') ? sprintf('%02d', $request->input('day')) : $now->format('d');

        if (! checkdate( (int)$month, (int)$day, (int)$year )) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '올바른 날짜 형식이 아닙니다.');
            return response()->json($result);
        }

        $ymd = $year."-".$month."-".$day;
        if (strtotime($ymd) > strtotime(date('Y-m-d'))) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '작성일자는 미래일 수 없습니다.');
            return response()->json($result);
        }

        $appNotice = AppNotice::whereId($notice_id)->first();

        if (empty($appNotice)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '잘못된 요청입니다.');
            return response()->json($result);
        }

        if (!($user->id == $appNotice->user_id || $user->user_type == 'a')) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
        }

        $payload = array_merge($request->only(['title', 'content']), [
            'created_at' => $ymd." ".$appNotice->created_at->format('H:i:s'),
        ]);
        $appNotice->fill($payload);
        $appNotice->save();

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'error', '수정 되었습니다.');
        $result = Arr::add($result, 'appNoticeId', $appNotice->id);

        return response()->json($result);
    }

    public function destroy(Request $request, $notice_id)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = User::find($user_id);

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        if (!in_array($user->user_type, ['a', 'h'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }
        $appNotice = AppNotice::whereId($notice_id)->first();

        if (empty($appNotice)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '잘못된 요청입니다.');
            return response()->json($result);
        }

        if (!($user->id == $appNotice->user_id || $user->user_type == 'a')) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
        }

        $appNotice->forceDelete();
        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'error', '삭제 되었습니다.');

        return response()->json($result);
    }

    public function notice(Request $request)
    {
        $userType = \App::make('helper')->getUsertType();
        if (!in_array($userType, ['a','h','m'])) \App::make('helper')->alert("접근 권한이 없습니다.");

        $ym = $request->input('ym') ?? date('Y-m');
        $type = $request->input('type') ?? '';
        $search_text = $request->input('search_text') ?? '';
        $year = $month = "";
        if ($ym != '') {
            $ymArr = explode('-', $ym);
            $year = $ymArr[0] ?? '';
            $month = $ymArr[1] ?? '';
        }
        $req = Request::create('/api/appNotice/list', 'GET', [
            'user' => \App::make('helper')->getUsertId(),
            'year' => $year,
            'month' => $month,
            'type' => $type,
            'search_text' => $search_text,
        ]);

        $appNoticeController = new AppNoticeController();
        $res = $appNoticeController->index($req);
        $list = $res->original['list'] ?? [];
//        var_dump($ym);
//        var_dump($type);
//        \App::make('helper')->vardump($type);
        return view('asobiNotice/list',[
            'list' => $list,
            'ym' => $ym,
            'type' => $type,
            'search_text' => $search_text,
        ]);
    }

    public function noticeView($id)
    {
        $uesrId = \App::make('helper')->getUsertId();
        $userType = \App::make('helper')->getUsertType();
        $appNoticeReq = Request::create('/appNotice/view/'.$id, 'GET', [
            'user' => $uesrId
        ]);
        $res = $this->show($appNoticeReq, $id);

        if ($res->original['result'] != 'success') {
            $error = \App::make('helper')->getErrorMsg($res->original['error']);
            \App::make('helper')->alert($error);
        }

        return view('asobiNotice/view',[
            'row' => $res->original ?? [],
            'modifyBtn' => \App::make('helper')->getUsertId() == $res->original['user_id'],
            'deleteBtn' => \App::make('helper')->getUsertId() == $res->original['user_id'],
        ]);
    }

    public function noticeWrite($id="")
    {
        $title = "";
        $content = "";
        $ymd = date('Y-m-d');
        $mode = "w";

        $type = "a";
        $userType = \App::make('helper')->getUsertType();
        if ($userType == 'h') {
            $type = 'h';
        }

        if ($id != "") {
            $mode = "u";
            $appNoticeReq = Request::create('/appNotice/view/'.$id, 'GET', [
                'user' => \App::make('helper')->getUsertId()
            ]);
            $res = $this->show($appNoticeReq, $id);
            if ($res->original['result'] != 'success') {
                $error = \App::make('helper')->getErrorMsg($res->original['error']);
                \App::make('helper')->alert($error);
            }
            $title = $res->original['title'] ?? '';
            $content = $res->original['content'] ?? '';
            $ymd = $res->original['date3'] ?? '';
            $type = "a";
            $resType = $res->original['type'] ?? '';
            if ($resType == '지사') {
                $type = "h";
            }
        }

        return view('asobiNotice/write', [
            'noticeTitle' => $title,
            'content' => $content,
            'ymd' => $ymd,
            'mode' => $mode,
            'id' => $id,
            'type' => $type,
        ]);
    }

    public function writeAction(Request $request)
    {
        $mode = $request->input('mode') ?? '';
        $id = $request->input('id') ?? '';
        $title = $request->input('title') ?? '';
        $content = $request->input('content') ?? '';
        $ymd = $request->input('ymd') ?? '';

        if ($title == "") \App::make('helper')->alert('제목을 입력해주세요.');
        if ($content == "") \App::make('helper')->alert('내용을 입력해주세요.');
        if ($ymd == "") \App::make('helper')->alert('작성일자를 입력해주세요.');
        $ymdArr = explode('-', $ymd);
        $year = $ymdArr[0]??-1;
        $month = $ymdArr[1]??-1;
        $day = $ymdArr[2]??-1;
        if (! checkdate((int)$month,(int)$day,(int)$year)) \App::make('helper')->alert('올바른 작성일자가 아닙니다.');

        if ($mode == 'u') {
            $req = Request::create('/appNotice/write/'.$id, 'POST', [
                'user' => \App::make('helper')->getUsertId(),
                'title' => $title,
                'content' => $content,
                'year' => $year,
                'month' => $month,
                'day' => $day,
            ]);
            $res = $this->update($req, $id);
        } else {
            $req = Request::create('/appNotice/write', 'POST', [
                'user' => \App::make('helper')->getUsertId(),
                'title' => $title,
                'content' => $content,
                'year' => $year,
                'month' => $month,
                'day' => $day,
            ]);
            $res = $this->store($req);
        }

        if ($res->original['result'] != 'success') {
            $error = \App::make('helper')->getErrorMsg($res->original['error']);
            \App::make('helper')->alert($error);
        }

        \App::make('helper')->alert( (($mode == 'u')?"수정":"등록")."되었습니다.", '/asobiNotice/view/'.$res->original['appNoticeId']);
//        return redirect('asobiNotice/view/'.$res->original['appNoticeId']);
    }

    public function noticeDelete($id)
    {
        $req = Request::create('/appNotice/delete/'.$id, 'POST', [
            'user' => \App::make('helper')->getUsertId(),
        ]);
        $res = $this->destroy($req, $id);

        if ($res->original['result'] != 'success') {
            $error = \App::make('helper')->getErrorMsg($res->original['error']);
            \App::make('helper')->alert($error);
        }

        \App::make('helper')->alert("삭제되었습니다.", "/asobiNotice");
    }

}

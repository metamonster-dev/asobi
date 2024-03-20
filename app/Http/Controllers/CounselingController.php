<?php

namespace App\Http\Controllers;

use App\Counseling;
use App\Models\RaonMember;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class CounselingController extends Controller
{
    public function student(Request $request)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        if (!in_array($user->mtype, ['m'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        $year = $request->input('year') ? sprintf('%04d', $request->input('year')) : null;
        $month = $request->input('month') ? sprintf('%02d', $request->input('month')) : null;

        $search_user_id = $request->input('search_user_id') ?? "";

        $year_month = "";
        if ($year != "" && $month != "") {
            if (! checkdate((int)$month,1,(int)$year)) {
                $result = Arr::add($result, 'result', 'fail');
                $result = Arr::add($result, 'error', '날짜 형식이 잘못되었습니다.');
                return response()->json($result);
            }
            $year_month = $year."-".$month;
        }

//        \App::make('helper')->log('search_user_id', ['search_user_id' => $search_user_id], 'search_user_id');


        $rs = DB::table('raon_member')
            ->select('raon_member.idx as uid', 'raon_member.name as uname', 'cls.created_at as ccreated_at')
            ->leftJoin(DB::raw('
            (SELECT MAX(created_at) created_at, sidx, YEAR(created_at) AS year, MONTH(created_at) AS month
                    FROM counselings
                    GROUP BY sidx, YEAR(created_at), MONTH(created_at)) AS cls'),function ($join) {
                $join->on('raon_member.idx','=','cls.sidx');
            })
            ->where('midx', $user->idx)
            ->where('raon_member.mtype','s')
            ->where('raon_member.s_status','Y')
            ->when($year_month, function ($q) use ($year_month) {
                $q->whereRaw("date_format(cls.created_at, '%Y-%m') = '{$year_month}'");
            })
            ->when($search_user_id != "", function ($q) use ($search_user_id) {
                $q->where('raon_member.idx', $search_user_id);
            })
            ->orderBy('raon_member.name')
            ->get();

//        $uids = DB::connection('mysql')->table('raon_member')
//            ->select('idx as uid')
//            ->where('midx', $user->idx)
//            ->where('mtype', 's')
//            ->where('s_status', 'Y')
//            ->when($search_user_id != "", function ($q) use ($search_user_id) {
//                $q->where('raon_member.idx', $search_user_id);
//            })
//            ->pluck('uid');
//
//        $maxCreated = DB::table('counselings')
//            ->select(DB::raw('MAX(created_at) as ccreated_at'), 'sidx as uid')
//            ->groupBy('sidx', DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
//            ->whereIn('sidx', $uids)
////            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = '{$year_month}'")
//            ->when($year_month, function ($q) use ($year_month) {
//                $q->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = '{$year_month}'");
//            })
//            ->orderBy('sidx')
//            ->get();
//
//        foreach ($maxCreated as $key => $value) {
//            $nameResult = DB::connection('mysql')->table('raon_member')->select('name')->whereIdx($value->uid)->first();
//
//            $maxCreated[$key]->uname = $nameResult->name;
//        }
//
//        $rs = $maxCreated;

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'count', $rs->count());

        if ($rs) {
            foreach ($rs as $index => $row) {
                $userMemberDetail = RaonMember::where('idx', $row->uid)->first();
                $profile_image = $userMemberDetail->user_picture ?? '';

                $result = Arr::add($result, "list.{$index}.id", $row->uid);
                $result = Arr::add($result, "list.{$index}.name", $row->uname);
                $result = Arr::add($result, "list.{$index}.profile_image", $profile_image ? \App::make('helper')->getImage($profile_image) : null);

                $ccreated_at = $row->ccreated_at ?? '';
                $date = ($ccreated_at != '')? date('Y.m.d', strtotime($ccreated_at)): "-";
                $result = Arr::add($result, "list.{$index}.date", $date);
            }
        }

        return response()->json($result);
    }

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

        $year = $request->input('year') ? sprintf('%04d', $request->input('year')) : null;
        $month = $request->input('month') ? sprintf('%02d', $request->input('month')) : null;

        $year_month = "";
        if ($year != "" && $month != "") {
            if (! checkdate((int)$month,1,(int)$year)) {
                $result = Arr::add($result, 'result', 'fail');
                $result = Arr::add($result, 'error', '날짜 형식이 잘못되었습니다.');
                return response()->json($result);
            }
            $year_month = $year."-".$month;
        }

        $rs = Counseling::where('sidx', $user->idx)->when($year_month, function ($q) use ($year, $month) {
            $q->where('year', $year)->where('month', $month);
        })->orderByDesc('created_at')->get();
        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'count', $rs->count());
        if ($rs) {
            foreach ($rs as $index => $row) {
                $result = Arr::add($result, "list.{$index}.id", $row->id);
                $result = Arr::add($result, "list.{$index}.date", $row->created_at->format(Counseling::DATE_FORMAT));
                $result = Arr::add($result, "list.{$index}.content", $row->content);
            }
        }

        return response()->json($result);
    }

    public function show(Request $request, $counseling_id)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        if (!in_array($user->mtype, ['m'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        $row = Counseling::whereMidx($user->idx)->whereId($counseling_id)->first();
        if ($row) {
            $student = RaonMember::whereIdx($row->sidx)->first();
            $result = Arr::add($result, 'result', 'success');
            $result = Arr::add($result, "id", $row->idx);
            $result = Arr::add($result, "content", $row->content);
            $result = Arr::add($result, "date", $row->created_at->format(Counseling::DATE_FORMAT));
            $result = Arr::add($result, "sidx", $row->sidx);
            $result = Arr::add($result, "name", $student->name ?? "");

        } else {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '잘못된 요청입니다.');
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

        if (!in_array($user->mtype, ['m'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        $student = $request->input('student');
        $content = $request->input('content');
        $now = Carbon::now();
        $year = $request->input('year') ? sprintf('%04d', $request->input('year')) : $now->format('Y');
        $month = $request->input('month') ? sprintf('%02d', $request->input('month')) : $now->format('m');
        $day = $request->input('day') ? sprintf('%02d', $request->input('day')) : $now->format('d');

        if (! checkdate((int)$month,(int)$day,(int)$year)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '날짜 형식이 잘못되었습니다.');
            return response()->json($result);
        }

        $payload = [
            'hidx' => $user->hidx,
            'midx' => $user->idx,
            'sidx' => $student,
            'content' => $content,
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'created_at' => $year."-".$month."-".$day." ".date('H:i:s'),
        ];
        $counseling = new Counseling($payload);
        $counseling->save();
        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'error', '등록 되었습니다.');
        $result = Arr::add($result, 'counseling_id', $counseling->id);

        return response()->json($result);
    }

    public function update(Request $request, $counseling_id)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        if (!in_array($user->mtype, ['m'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        $counseling = Counseling::whereMidx($user->idx)->whereId($counseling_id)->first();
        if (empty($counseling)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '잘못된 요청입니다.');
            return response()->json($result);
        }

        $content = $request->input('content');
        $payload = [
            'content' => $content
        ];
        $counseling->fill($payload);
        $counseling->save();
        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'error', '수정 되었습니다.');

        return response()->json($result);
    }

    public function destroy(Request $request, $counseling_id)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        if (!in_array($user->mtype, ['m'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        $counseling = Counseling::whereMidx($user->idx)->whereId($counseling_id)->first();
        if (empty($counseling)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '잘못된 요청입니다.');
            return response()->json($result);
        }

        $counseling->delete();

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'error', '삭제 되었습니다.');

        return response()->json($result);
    }

    public function counsel(Request $request)
    {
        $ym = $request->input('ym') ?? date('Y-m');
        $search_text = $request->input('search_text') ?? '';
        $search_user_id = $request->input('search_user_id') ?? '';

        $year = $month = "";
        if ($ym != '') {
            $ymArr = explode('-', $ym);
            $year = $ymArr[0] ?? '';
            $month = $ymArr[1] ?? '';
        }

        $user = \App::make('helper')->getUsertId();
        $userType = \App::make('helper')->getUsertType();
        if (in_array($userType, ['a','h'])) {
            $user = session()->get('center');
        }

        // 전체 학생리스트
        $req = Request::create('/api/children', 'GET', [
            'user' => $user,
        ]);
        $userController = new UserController();
        $res = $userController->children($req);
        $student = $res->original['list'] ?? [];

        $studentList = [];
        if (count($student) > 0) {
            $studentList[] = [
                'idx' => "",
                'name' => "전체",
            ];
            foreach ($student as $l) {
                $studentList[] = [
                    'idx' => $l['id'],
                    'name' => $l['name'],
                ];
            }
        }

        if ($search_user_id == "") {
            //학생리스트
            $req = Request::create('/api/counseling/student/list', 'GET', [
                'user' => $user,
                'year' => $year,
                'month' => $month,
                'search_user_id' => $search_user_id,
            ]);

            $res = $this->student($req);
            $list = $res->original['list'] ?? [];
            // \App::make('helper')->vardump($list);
        } else {
            //상담일지 리스트
            $req = Request::create('/api/counseling/list', 'GET', [
                'user' => $search_user_id,
                'year' => $year,
                'month' => $month,
            ]);
            $res = $this->index($req);
            $list = $res->original['list'] ?? [];
        }

        return view('counsel/list', [
            'user' => $user,
            'list' => $list,
            'ym' => $ym,
            'search_text' => $search_text,
            'search_user_id' => $search_user_id,
            'studentList' => json_encode($studentList),
        ]);
    }
    public function counselView(Request $request, $id)
    {
        $ym = $request->input('ym') ?? date('Y-m');
        $year = $month = "";
        if ($ym != '') {
            $ymArr = explode('-', $ym);
            $year = $ymArr[0] ?? '';
            $month = $ymArr[1] ?? '';
        }

        $req = Request::create('/api/counseling/list', 'GET', [
            'user' => $id,
            'year' => $year,
            'month' => $month,
        ]);
        $res = $this->index($req);
        $list = $res->original['list'] ?? [];

        // 학생리스트
        $user = \App::make('helper')->getUsertId();
        $userType = \App::make('helper')->getUsertType();
        if (in_array($userType, ['a','h'])) {
            $user = session()->get('center');
        }
        $studentReq = Request::create('/api/counseling/student/list', 'GET', [
            'user' => $user,
            'search_user_id' => $id,
        ]);
        $studentRes = $this->student($studentReq);
        $studentList = $studentRes->original['list'] ?? [];
        // \App::make('helper')->vardump($studentList);

        return view('counsel/view', [
            'id' => $id,
            'user' => $user,
            'list' => $list,
            'stdList' => $studentList,
            'ym' => $ym,
        ]);
    }
    public function counselWrite(Request $request, $id="")
    {
//        \App::make('helper')->alert($request->input('ym'));
        $ymd = date('Y-m-d');
        $mode = "w";

        $ym = $request->input('ym') ?? '';
        $search_user_id = $request->input('search_user_id') ?? '';

        if ($ym != "" && $ym != date('Y-m')) {
            $ymd = $ym."-01";
        }

        if ($id != "") {
            $mode = "u";
            $appEventReq = Request::create('/counsel/view/'.$id, 'GET', [
                'user' => \App::make('helper')->getUsertId()
            ]);
            $res = $this->show($appEventReq, $id);

            if ($res->original['result'] != 'success') {
                $error = \App::make('helper')->getErrorMsg($res->original['error']);
                \App::make('helper')->alert($error);
            }
            $row = $res->original ?? [];
            if (isset($row['date']) && $row['date'] != "") {
                $ymd = $row['date'];
            }
        }

        return view('counsel/write', [
            'mode' => $mode,
            'id' => $id,
            'row' => $res->original ?? [],
            'ymd' => $ymd,
            'search_user_id' => $search_user_id ? $search_user_id : "undefined",
        ]);
    }

    public function counselWriteAction(Request $request)
    {
        $mode = $request->input('mode') ?? '';
        $id = $request->input('id') ?? '';
//        $date = $request->input('date') ? explode('-', $request->input('date')) : explode('-', date("Y-m-d"));
        $date = $request->input('ymd') ? explode('-', $request->input('ymd')) : explode('-', date("Y-m-d"));;

        $request->merge([
            'user' => \App::make('helper')->getUsertId(),
            'year' => $date[0],
            'month' => $date[1],
            'day' => $date[2],
            'student' => $request->input('search_user_id'),
        ]);

//        \App::make('helper')->vardump($request->all());

        if ($mode == 'u') {
            $res = $this->update($request, $id);
        } else {
            $res = $this->store($request);
        }
        if ($res->original['result'] != 'success') {
            $error = \App::make('helper')->getErrorMsg($res->original['error']);
            \App::make('helper')->alert($error);
        }

        $mode = $request->input('mode') ?? '';

        \App::make('helper')->alert( (($mode == 'u')?"수정":"등록")."되었습니다.", '/counsel?ym='.$date[0].'-'.$date[1].'&search_user_id='.$request->input('student').'&search_text='.$request->input('search_text'));

    }

    public function counselDelete($id)
    {

        $req = Request::create('/counsel/delete/'.$id, 'POST', [
            'user' => \App::make('helper')->getUsertId(),
        ]);
        $res = $this->destroy($req, $id);

        if ($res->original['result'] != 'success') {
            $error = \App::make('helper')->getErrorMsg($res->original['error']);
            \App::make('helper')->alert($error);
        }

        \App::make('helper')->alert("삭제되었습니다.", "/counsel");
    }
}

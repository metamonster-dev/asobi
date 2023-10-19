<?php

namespace App\Http\Controllers;

use App\AdviceNoteAdmin;
use App\Models\RaonMember;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

class AdviceNoteAdminController extends Controller
{
    public function show(Request $request)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        if (!in_array($user->mtype, ['a'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        $now = Carbon::now();
        $year = $request->input('year') ? $request->input('year') : $now->format('Y');
        $month = $request->input('month') ? $request->input('month') : $now->format('m');
        $this_date = Carbon::create($year, $month);
        $this_month = $this_date->format('Y-m');
        $adviceNoteAdmin = AdviceNoteAdmin::where('this_month', $this_month)->first();
        $maxMonth = AdviceNoteAdmin::max('this_month');
        $nextMonth = Carbon::createFromFormat('Y-m', $maxMonth)->addMonth()->format('Y-m');
        $minMonth = AdviceNoteAdmin::min('this_month');

        if (empty($adviceNoteAdmin)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '게시글이 없습니다.');
            return response()->json($result);
        }

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'prefix_content', $adviceNoteAdmin->prefix_content);
        $result = Arr::add($result, 'this_month_education_info', $adviceNoteAdmin->this_month_education_info);
        $result = Arr::add($result, 'date', $adviceNoteAdmin->created_at->format('Y-m-d'));
        $result = Arr::add($result, 'nextMonth', $nextMonth);
        $result = Arr::add($result, 'minMonth', $minMonth);

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

        if (!in_array($user->mtype, ['a'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        $now = Carbon::now();
        $year = $request->input('year') ? sprintf('%04d', $request->input('year')) : $now->format('Y');
        $month = $request->input('month') ? sprintf('%02d', $request->input('month')) : $now->format('m');
        $this_date = Carbon::create($year, $month);
        $this_month = $this_date->format('Y-m');
        $adviceNoteAdmin = AdviceNoteAdmin::where('this_month', $this_month)->first();
        $payload = array_merge($request->only(['prefix_content', 'this_month_education_info']), []);

        $result = Arr::add($result, 'result', 'success');
        if ($adviceNoteAdmin){
            $adviceNoteAdmin->fill($payload);
            $adviceNoteAdmin->save();
            $result = Arr::add($result, 'error', '수정 되었습니다.');
        } else {
            $adviceNoteAdmin = new AdviceNoteAdmin([
                'this_month' => $this_month
            ]);
            $adviceNoteAdmin->fill($payload);
            $adviceNoteAdmin->save();
            $result = Arr::add($result, 'error', '등록 되었습니다.');
        }

        return response()->json($result);
    }

}

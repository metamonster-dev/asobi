<?php

namespace App\Http\Controllers;

use App\AdviceNote;
use App\AdviceNoteHistory;
use App\Album;
use App\AlbumHistory;
use App\EducatonInfo;
use App\Event;
use App\CommonHistory;
use App\Notice;
use App\NoticeHistory;
use App\ScheduleAcademyStudy;
use App\ScheduleStudy;
use App\Models\RaonMember;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AppMainController extends Controller
{
    public function terms()
    {
        return view('main.terms');
    }

    public function privacy()
    {
        return view('main.privacy');
    }

    public function index(Request $request)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();
        $check_date = Carbon::now()->subDay(3)->format('Y-m-d');

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

//        $result = Arr::add($result, 'user_type', $user->user_type);
//        $result = Arr::add($result, 'check_date', $check_date);

        if ($user->mtype == 's') {
            $advice_rs = AdviceNote::where('status', 'Y')->where('sidx', $user->idx)->where('created_at', '>', $check_date)->get();
            $adviceNoteHistoryCount = AdviceNoteHistory::whereIn('advice_note_id', $advice_rs->pluck('id')->toArray())->where('sidx', $user->idx)->count();

            $album_rs = Album::where('status', 'Y')->where('sidx', 'like', "%" . json_encode($user->idx) . "%")->where('created_at', '>', $check_date)->get();
            $albumHistoryCount = AlbumHistory::whereIn('album_id', $album_rs->pluck('id')->toArray())->where('sidx', $user->idx)->count();

            $notice_rs = Notice::where('status', 'Y')->whereIn('midx', [$user->midx, 0])->where('view_type', 'like', "%" . json_encode($user->mtype) . "%")->where('created_at', '>', $check_date)->orderByDesc('created_at')->get();
            $noticeHistoryCount = NoticeHistory::whereIn('notice_id', $notice_rs->pluck('id')->toArray())->where('sidx', $user->idx)->count();

            $educatonInfo_rs = EducatonInfo::where('created_at', '>', $check_date)->get();
            $educatonInfoHistoryCount = CommonHistory::where('type', '=', '1')->whereIn('type_id', $educatonInfo_rs->pluck('id')->toArray())->where('sidx', $user->idx)->count();

            $event_rs = Event::where('created_at', '>', $check_date)->get();
            $eventHistoryCount = CommonHistory::where('type', '=', '2')->whereIn('type_id', $event_rs->pluck('id')->toArray())->where('sidx', $user->idx)->count();

            $userMemberDetail = RaonMember::where('idx', $user->idx)->first();
            $profile_image = $userMemberDetail->user_picture ?? '';

            $result = Arr::add($result, 'adviceNote', $advice_rs->count() > $adviceNoteHistoryCount ? "Y" : "N");
            $result = Arr::add($result, 'album', $album_rs->count() > $albumHistoryCount ? "Y" : "N");
            $result = Arr::add($result, 'notice', $notice_rs->count() > $noticeHistoryCount ? "Y" : "N");
            $result = Arr::add($result, 'attendance', 'N');
            $result = Arr::add($result, 'educatonInfo', $educatonInfo_rs->count() > $educatonInfoHistoryCount ? "Y" : "N");
            $result = Arr::add($result, 'event', $event_rs->count() > $eventHistoryCount ? "Y" : "N");
            $result = Arr::add($result, "picture", $profile_image ? \App::make('helper')->getImage($profile_image) : '');
        } else {
            $result = Arr::add($result, 'adviceNote', 'N');
            $result = Arr::add($result, 'album', 'N');

            $notice_rso = Notice::where('status', 'Y')->where('view_type', 'like', "%" . json_encode($user->mtype) . "%")->where('created_at', '>', $check_date)->orderByDesc('created_at');
            if ($user->mtype == 'm') {
                $notice_rs = $notice_rso->where('hidx', $user->hidx)->whereIn('midx', [0, $user->idx])->get();
                $noticeHistoryCount = NoticeHistory::whereIn('notice_id', $notice_rs->pluck('id')->toArray())->where('midx', $user->idx)->count();
                $result = Arr::add($result, 'notice', $notice_rs->count() > $noticeHistoryCount ? "Y" : "N");
            } else if ($user->mtype == 'h') {
                $notice_rs = $notice_rso->whereIn('hidx', [0, $user->idx])->get();
                $noticeHistoryCount = NoticeHistory::whereIn('notice_id', $notice_rs->pluck('id')->toArray())->where('hidx', $user->idx)->count();
                $result = Arr::add($result, 'notice', $notice_rs->count() > $noticeHistoryCount ? "Y" : "N");
            } else {
                $result = Arr::add($result, 'notice', 'N');
            }

            $result = Arr::add($result, 'attendance', 'N');
            $result = Arr::add($result, 'educatonInfo', 'N');
            $result = Arr::add($result, 'event', 'N');
            $result = Arr::add($result, 'picture', '');
        }

        $result = Arr::add($result, 'user_name', $user->name);
        $result = Arr::add($result, 'result', 'success');
        return response()->json($result);
    }

    public function isSchedule(Request $request)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();
        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        $now = Carbon::now();
        $year = $request->input('year')  ? sprintf('%04d', $request->input('year')) : $now->format('Y');
        $month = $request->input('month') ? sprintf('%02d',$request->input('month')) : $now->format('m');
        $day = $request->input('day') ? sprintf('%02d',$request->input('day')) : $now->format('d');

        $year_month_day = "";
        if ($year != "" && $month != "" && $day != "") {
            $year_month_day = $year."-".$month."-".$day;
        }

        $midx = 0;
        if ($user->mtype == 'm') {
            $userCenterDetail = RaonMember::where('idx', $user->idx)->first();
            $franchisetype = $userCenterDetail->franchisetype ?? '';
            if ($franchisetype == 'B' || $franchisetype == 'C') {
                $midx = $user->idx;
            }
        }

        $calendar_years_array = array();
        $calendar_years = DB::table('schedule_studies')
            ->select(DB::raw("DISTINCT(DATE_FORMAT(`date`, '%Y')) AS year"))
            ->orderBy('date', 'asc')
            ->get();

        if ($calendar_years->count()) {
            $calendar_years->map(function($calendar_year) use(&$calendar_years_array) {
                $calendar_years_array[] = $calendar_year->year;
            }); // $calendar_years->map End
        }

        if ($midx) {
            $center_calendar_years = DB::table('schedule_academy_studies')
                ->select(DB::raw("DISTINCT(DATE_FORMAT(`date`, '%Y')) AS year"))
                ->where('midx', $midx)
                ->orderBy('date', 'asc')
                ->get();

            $center_calendar_years_array = array();
            if ($center_calendar_years->count()) {
                $center_calendar_years->map(function($center_calendar_year) use(&$center_calendar_years_array) {
                    $center_calendar_years_array[] = $center_calendar_year->year;
                }); // $calendar_years->map End
            }

            $rs = ScheduleAcademyStudy::select('type', 'date')
                ->where('midx', $midx)
                ->whereIn(DB::raw("DATE_FORMAT(`date`, '%Y')"), $center_calendar_years_array)
                ->whereIn('type', ['blue', 'red'])
                ->union(
                    ScheduleStudy::select('type', 'date')
                        ->whereNotIn(DB::raw("DATE_FORMAT(`date`, '%Y')"), $center_calendar_years_array)
                        ->whereIn('type', ['blue', 'red'])
                        ->when($year_month_day, function ($query, $year_month_day) {
                            $query->whereRaw("date = ?", [$year_month_day]);
                        })
                )
                ->orderBy('date', 'asc')
                ->get();
        } else {
            if ($user->mtype == 'm') {
                $rs = ScheduleStudy::whereIn('type', ['blue', 'red'])->when($year_month_day, function ($query, $year_month_day) {
                    $query->whereRaw("date = ?", [$year_month_day]);
                })->orderBy('date', 'asc')->get();
            } else {
                if ($user->mtype == 's') {
                    $center = RaonMember::select('idx')->whereId($user->midx)->first();
                    $centerCenterDetail = RaonMember::where('idx', $center->id)->first();
                    $center->franchisetype = $centerCenterDetail->franchisetype ?? '';

                    if ($center && $center->franchisetype == 'C') {
                        $center_calendar_years = DB::table('schedule_academy_studies')
                            ->select(DB::raw("DISTINCT(DATE_FORMAT(`date`, '%Y')) AS year"))
                            ->where('midx', $center->id)
                            ->orderBy('date', 'asc')
                            ->get();

                        $center_calendar_years_array = array();
                        if ($center_calendar_years->count()) {
                            $center_calendar_years->map(function($center_calendar_year) use(&$center_calendar_years_array) {
                                $center_calendar_years_array[] = $center_calendar_year->year;
                            }); // $calendar_years->map End
                        }

                        $rs = ScheduleAcademyStudy::select('type', 'date')
                            ->where('midx', $center->id)
                            ->whereIn(DB::raw("DATE_FORMAT(`date`, '%Y')"), $center_calendar_years_array)
                            ->whereIn('type', ['blue', 'red'])
                            ->union(
                                ScheduleStudy::select('type', 'date')
                                    ->whereNotIn(DB::raw("DATE_FORMAT(`date`, '%Y')"), $center_calendar_years_array)
                                    ->whereIn('type', ['blue', 'red'])
                                    ->when($year_month_day, function ($query, $year_month_day) {
                                        $query->whereRaw("date = ?", [$year_month_day]);
                                    })
                            )
                            ->orderBy('date', 'asc')
                            ->get();

                    } else {
                        $rs = ScheduleStudy::whereIn('type', ['blue', 'red'])->when($year_month_day, function ($query, $year_month_day) {
                            $query->whereRaw("date = ?", [$year_month_day]);
                        })->orderBy('date', 'asc')->get();
                    }
                }
            }
        }

        unset($midx);

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'is', ($rs->count() > 0));
        return response()->json($result);
    }

    public function calendar(Request $request)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

//        $now = Carbon::now();
        $year = $request->input('year') ? sprintf('%04d', $request->input('year')) : "";
        $month = $request->input('month') ? sprintf('%02d', $request->input('month')) : "";

        $year_month = "";
        if ($year != "" && $month != "") {
            $year_month = $year."-".$month;
        }

        $midx = 0;
        if ($user->mtype == 'm') {
            $userCenterDetail = RaonMember::where('idx', $user->idx)->first();
            $franchisetype = $userCenterDetail->franchisetype ?? '';
            if ($franchisetype == 'B' || $franchisetype == 'C') {
                $midx = $user->idx;
            }
        }

        $calendar_years_array = array();
        $calendar_years = DB::table('schedule_studies')
            ->select(DB::raw("DISTINCT(DATE_FORMAT(`date`, '%Y')) AS year"))
            ->orderBy('date', 'asc')
            ->get();

        if ($calendar_years->count()) {
            $calendar_years->map(function($calendar_year) use(&$calendar_years_array) {
                $calendar_years_array[] = $calendar_year->year;
            }); // $calendar_years->map End
        }

        if ($midx) {
            $center_calendar_years = DB::table('schedule_academy_studies')
                ->select(DB::raw("DISTINCT(DATE_FORMAT(`date`, '%Y')) AS year"))
                ->where('midx', $midx)
                ->orderBy('date', 'asc')
                ->get();

            $center_calendar_years_array = array();
            if ($center_calendar_years->count()) {
                $center_calendar_years->map(function($center_calendar_year) use(&$center_calendar_years_array) {
                    $center_calendar_years_array[] = $center_calendar_year->year;
                }); // $calendar_years->map End
            }

            $rs = ScheduleAcademyStudy::select('type', 'date')
                ->where('midx', $midx)
                ->whereIn(DB::raw("DATE_FORMAT(`date`, '%Y')"), $center_calendar_years_array)
                ->whereIn('type', ['blue', 'red'])
                ->union(
                    ScheduleStudy::select('type', 'date')
                        ->whereNotIn(DB::raw("DATE_FORMAT(`date`, '%Y')"), $center_calendar_years_array)
                        ->whereIn('type', ['blue', 'red'])
                        ->when($year_month, function ($query, $year_month) {
                            $query->whereRaw("date_format(date, '%Y-%m') = ?", [$year_month]);
                        })
                )
                ->orderBy('date', 'asc')
                ->get();
        } else {
            if ($user->mtype == 'm') {
                $rs = ScheduleStudy::whereIn('type', ['blue', 'red'])->when($year_month, function ($query, $year_month) {
                    $query->whereRaw("date_format(date, '%Y-%m') = ?", [$year_month]);
                })->orderBy('date', 'asc')->get();
            } else {
                if ($user->mtype == 's') {
                    $center = RaonMember::select('idx')->whereIdx($user->midx)->first();
                    $centerCenterDetail = RaonMember::where('idx', $center->idx)->first();
                    $center->franchisetype = $centerCenterDetail->franchisetype ?? '';

                    if ($center && $center->franchisetype == 'C') {
                        $center_calendar_years = DB::table('schedule_academy_studies')
                            ->select(DB::raw("DISTINCT(DATE_FORMAT(`date`, '%Y')) AS year"))
                            ->where('midx', $center->id)
                            ->orderBy('date', 'asc')
                            ->get();

                        $center_calendar_years_array = array();
                        if ($center_calendar_years->count()) {
                            $center_calendar_years->map(function($center_calendar_year) use(&$center_calendar_years_array) {
                                $center_calendar_years_array[] = $center_calendar_year->year;
                            }); // $calendar_years->map End
                        }

                        $rs = ScheduleAcademyStudy::select('type', 'date')
                            ->where('midx', $center->id)
                            ->whereIn(DB::raw("DATE_FORMAT(`date`, '%Y')"), $center_calendar_years_array)
                            ->whereIn('type', ['blue', 'red'])
                            ->union(
                                ScheduleStudy::select('type', 'date')
                                    ->whereNotIn(DB::raw("DATE_FORMAT(`date`, '%Y')"), $center_calendar_years_array)
                                    ->whereIn('type', ['blue', 'red'])
                                    ->when($year_month, function ($query, $year_month) {
                                        $query->whereRaw("date_format(date, '%Y-%m') = ?", [$year_month]);
                                    })
                            )
                            ->orderBy('date', 'asc')
                            ->get();

                    } else {
                        $rs = ScheduleStudy::whereIn('type', ['blue', 'red'])->when($year_month, function ($query, $year_month) {
                            $query->whereRaw("date_format(date, '%Y-%m') = ?", [$year_month]);
                        })->orderBy('date', 'asc')->get();
                    }
                }
            }
        }

        unset($midx);

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'count', $rs->count());

        if ($rs) {
            $blue_index = 0;
            $red_index = 0;

            foreach ($rs as $index => $row) {
                if ($row->type == 'blue') {
                    $result = Arr::add($result, "list.{$row->type}.{$blue_index}", $row->date);
                    $blue_index++;
                }

                if ($row->type == 'red') {
                    $result = Arr::add($result, "list.{$row->type}.{$red_index}", $row->date);
                    $red_index++;
                }
            } // foreach End
        }

        return response()->json($result);
    }

}

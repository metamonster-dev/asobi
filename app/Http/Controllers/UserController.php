<?php

namespace App\Http\Controllers;

//use App\Exports\UsersExport;
use App\Models\RaonMember;
use App\UserDetail;
use App\Models\ShopCategory;
use App\UserAppInfo;
//use App\Models\RaonMember;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
//use Maatwebsite\Excel\Facades\Excel;
use Validator;
use App\Rules\YN;
use App\Rules\Sex;
use App\Rules\Phone;

class UserController extends Controller
{
    public function userAdd(Request $request)
    {
        $result = [];

        $validator = Validator::make($request->all(), [
            'center_id' => 'required',
            'name' => 'required',
            'birth' => 'required|date',
            'sex' => ['required', new Sex],
            'parent_name' => 'required',
            'parent_contact' => ['required', new Phone],
            'adress' => 'required',
            'adress_desc' => 'required',
            'cognitive_pathway' => 'required',
            'marketing' => ['required', new YN],
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => 'fail',
                'error' => json_decode($validator->errors()->__toString(), true)
            ]);
        }

        $center_id = $request->input('center_id');
        $name = $request->input('name');
        $birth = $request->input('birth');
        $sex = $request->input('sex');
        $parent_name = $request->input('parent_name');
        $parent_contact = $request->input('parent_contact');
        $adress = $request->input('adress');
        $adress_desc = $request->input('adress_desc');
        $cognitive_pathway = $request->input('cognitive_pathway');
        $marketing = $request->input('marketing');

        //교육원 있는지 확인.
        $center = RaonMember::where('mtype', 'm')->where('m_status', 'Y')->whereIdx($center_id)->first();
        if (empty($center)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '교육원이 올바르지 않습니다.');
            return response()->json($result);
        }

        $phone = \App::make('helper')->hypenPhone($parent_contact);

        $user = new RaonMember();
        $user->name = $name;
        $user->mobilephone = $phone;
        $user->mtype = 's';
        $user->hidx = $center->hidx;
        $user->midx = $center->midx;
        // todo: 입회신청 api가 완료되면 N으로 변경해야할듯.
        $user->s_status = 'Y';
//        $user->login_time = date('Y-m-d H:i:s');
        $user->id = "st_".time();
//        $user->save();

//        $user->id = 'st_'.$user->id;
//        $user->save();

//        $userMem = new UserMemberDetail();
//        $userMem->user_id = $user->id;
        $user->parent_name = $parent_name;
        $user->parent_contact = $parent_contact;
        $user->cognitive_path = $cognitive_pathway;
//        $user->save();

//        $userDetail = new RaonMember();
//        $userDetail->idx = $user->id;
        $user->sex = $sex;
        $user->birthday = $birth;
        $user->address1 = $adress;
        $user->address2 = $adress_desc;
        $user->mailling = $marketing;
        if ($marketing == 'Y') {
            $user->mailling_date = date('Y-m-d H:i:s');
        }
        $user->save();

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'error', '신청 완료 되었습니다.');
        $result = Arr::add($result, 'id', $user->id);

        return response()->json($result);
    }

    public function centerAll()
    {
        $result = array();

        // Todo: status
        $rs = RaonMember::where('mtype', 'm')->where('m_status', 'Y')->orderBy('nickname')->get();
        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'count', $rs->count());

        if ($rs) {
            foreach ($rs as $index => $row) {
                $result = Arr::add($result, "list.{$index}.id", $row->idx);
                $result = Arr::add($result, "list.{$index}.name", $row->nickname);
            }
        }

        return response()->json($result);
    }

    public function center(Request $request)
    {
        $result = array();

        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        if ($user->mtype != 'h') {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        $rs = RaonMember::where('mtype', 'm')->where('m_status', 'Y')->where('hidx', $user->idx)->orderBy('nickname')->get();
        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'count', $rs->count());

        if ($rs) {
            foreach ($rs as $index => $row) {
                $result = Arr::add($result, "list.{$index}.id", $row->idx);
                $result = Arr::add($result, "list.{$index}.name", $row->nickname);
            }
        }

        return response()->json($result);
    }

    public function branch(Request $request)
    {
        $result = array();

        $user_id = $request->input('user');

        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        if ($user->id != 'admin') {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        $rs = RaonMember::where('mtype', 'h')->where('h_status', 'Y')->orderBy('nickname')->get();
        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'count', $rs->count());

        if ($rs) {
            foreach ($rs as $index => $row) {
                $result = Arr::add($result, "list.{$index}.id", $row->idx);
                $result = Arr::add($result, "list.{$index}.name", $row->nickname);
            }
        }

        return response()->json($result);
    }

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

        if ($user->mtype != 'm') {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        $rs = RaonMember::where('midx', $user->idx)
            ->where('mtype', 's')
            ->where('s_status', 'Y')
            ->orderBy('name', 'asc')
            ->get();
        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'count', $rs->count());

        if ($rs) {
            foreach ($rs as $index => $row) {
                $userMemberDetail = RaonMember::where('idx', $row->idx)->first();
                $profile_image = $userMemberDetail->user_picture ?? '';

                $result = Arr::add($result, "list.{$index}.id", $row->idx);
                $result = Arr::add($result, "list.{$index}.name", $row->name);
                $result = Arr::add($result, "list.{$index}.profile_image", $profile_image ? \App::make('helper')->getImage($profile_image) : null);
            }
        }

        return response()->json($result);
    }

    public function children(Request $request)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        if (!in_array($user->mtype, ['s', 'm'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        if ($user->mtype == 's') {
            $phone = str_replace('-', '', $user->mobilephone);

            $rs = RaonMember::where(DB::raw("REPLACE(`mobilephone`, '-', '')"), $phone)
                ->where('mtype', 's')
                ->whereIn('s_status', array('Y'))
                ->orderBy('s_status', 'desc')
                ->get();

            $result = Arr::add($result, 'result', 'success');
            $result = Arr::add($result, 'count', $rs->count());
            if ($rs) {
                foreach ($rs as $index => $row) {
                    $userMemberDetail = RaonMember::where('idx', $row->idx)->first();
                    $profile_image = $userMemberDetail->user_picture ?? '';
                    $userDetail = RaonMember::where('idx', $row->idx)->first();

                    $birth_day = null;
                    if ($userDetail->birthday) {
                        $birth_str = str_replace("NaN","", $userDetail->birthday);
                        $birth_str = str_replace("-","", $birth_str);
                        if ($birth_str != "") {
                            $birth = Carbon::createFromFormat('Ymd', $birth_str);
                            $now = Carbon::now();
                            $diff = $birth->diff($now);
                            $birth_day = $birth->format('Y.m.d')."(".$diff->format('%y년 %m개월').")";
                        }
                    }

                    $result = Arr::add($result, "list.{$index}.id", $row->idx);
                    $result = Arr::add($result, "list.{$index}.name", $row->name);
                    $result = Arr::add($result, "list.{$index}.profile_image", $profile_image ? \App::make('helper')->getImage($profile_image) : null);
                    $result = Arr::add($result, "list.{$index}.birthday", $birth_day);

                    $center = RaonMember::whereIdx($row->midx)->first();
                    $result = Arr::add($result, "list.{$index}.branch_name", "아소비 공부방");
                    $result = Arr::add($result, "list.{$index}.center_name", $center ? $center->nickname : null);
                }
            }
        } else if ($user->mtype == 'm') {
            $rs = RaonMember::where('midx', $user->idx)
                ->where('mtype', 's')
                ->where('s_status', 'Y')
                ->orderBy('name', 'asc')
                ->get();

            $result = Arr::add($result, 'result', 'success');
            $result = Arr::add($result, 'count', $rs->count());

            if ($rs) {
                foreach ($rs as $index => $row) {
                    $userMemberDetail = RaonMember::where('idx', $row->idx)->first();
                    $profile_image = $userMemberDetail->user_picture ?? '';
                    $userDetail = RaonMember::where('idx', $row->idx)->first();

                    $shopCategory = ShopCategory::where('cd_lev', 1)->where('cd_year', $userDetail->course_year)->first();

                    $birth_day = null;
                    if ($userDetail->birthday) {
                        $birth_str = str_replace("NaN","", $userDetail->birthday);
                        $birth_str = str_replace("-","", $birth_str);
                        if ($birth_str != "") {
                            $birth = Carbon::createFromFormat('Ymd', $birth_str);
                            $now = Carbon::now();
                            $diff = $birth->diff($now);
                            $birth_day = $birth->format('Y.m.d')."(".$diff->format('%y년 %m개월').")";
                        }
                    }

                    $result = Arr::add($result, "list.{$index}.id", $row->idx);
                    $result = Arr::add($result, "list.{$index}.name", $row->name);
                    $result = Arr::add($result, "list.{$index}.profile_image", $profile_image ? \App::make('helper')->getImage($profile_image) : null);
                    $result = Arr::add($result, "list.{$index}.birthday", $birth_day);
                    $result = Arr::add($result, "list.{$index}.branch_name", $shopCategory ? $shopCategory->cd_text : '');
                    $result = Arr::add($result, "list.{$index}.center_name", '');
                }
            }
        }

        return response()->json($result);
    }

    public function selectChild(Request $request)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        $result = Arr::add($result, 'result', 'success');
//        $result = Arr::add($result, 'user_id', $user->idx);
//        $result = Arr::add($result, 'user_name', $user->mtype == 's' ? $user->name : $user->nickname);
//        if ($user->idx == 1) {
//            $result = Arr::add($result, 'user_type', 'admin');
//        } else {
//            $userMemberDetail = RaonMember::where('idx', $user->idx)->first();
//            $profile_image = $userMemberDetail->user_picture ?? '';
//            $result = Arr::add($result, 'user_type', $user->mtype);
//            $result = Arr::add($result, "user_picture", $profile_image ? \App::make('helper')->getImage($profile_image) : null);
//            if ($user->mtype == 's') {
//                $center = RaonMember::whereIdx($user->midx)->first();
//                $result = Arr::add($result, 'center_name', $center ? $center->nickname : null);
//            }
//        }
//        $result = Arr::add($result, 'login_id', $user->idx);

        $profile_image = $user->user_picture ?? '';
        $result = Arr::add($result, "list.0.id", $user->idx);
        $result = Arr::add($result, "list.0.name", $user->name);
        $result = Arr::add($result, "list.0.profile_image", $profile_image ? \App::make('helper')->getImage($profile_image) : null);
//        $result = Arr::add($result, "list.0.birthday", $birth_day);
//        $result = Arr::add($result, "list.0.branch_name", $shopCategory ? $shopCategory->cd_text : '');
//        $result = Arr::add($result, "list.0.center_name", '');

        return response()->json($result);
    }

    public function myInfo(Request $request)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'login_id', $user->id);
        $result = Arr::add($result, 'user_name', $user->mtype == 's' ? $user->name : $user->nickname);
        $result = Arr::add($result, 'email', $user->email);
        $result = Arr::add($result, 'phone', $user->mobilephone);

        $userMemberDetail = RaonMember::where('idx', $user->idx)->first();
        $profile_image = $userMemberDetail->user_picture ?? '';
        $result = Arr::add($result, 'user_type', $user->mtype);
        $result = Arr::add($result, "user_picture", $profile_image ? \App::make('helper')->getImage($profile_image) : null);
        if ($user->mtype == 's') {
            $center = RaonMember::whereIdx($user->midx)->first();
            $result = Arr::add($result, 'center_name', $center ? $center->nickname : null);
        }

        $userDetail = RaonMember::where('idx', $user->idx)->first();
        $result = Arr::add($result, 'gender', $userDetail->sex);
        $result = Arr::add($result, 'birthday', $userDetail->birthday);
        $result = Arr::add($result, 'address', $userDetail->address1);
        $result = Arr::add($result, 'address_detail', $userDetail->address2);
        $result = Arr::add($result, 'marketing_consent', $userDetail->mailling);
        $result = Arr::add($result, 'marketing_consented_at', $userDetail->mailling_date);
        $result = Arr::add($result, 'parent_name', $userMemberDetail->parent_name??null);
        $result = Arr::add($result, 'cognitive_pathway', $userMemberDetail->cognitive_path??null);

        return response()->json($result);
    }

    public function alramInfo(Request $request)
    {
        $result = array();
        $user_id = $request->input('user');

        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        $device_id = $request->input('device_id')?? '';
        $userAppInfo = UserAppInfo::where('user_id','=',$user_id)->where('device_id',$device_id)->first();
        if (empty($userAppInfo)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '로그인 정보가 없습니다.');
            return response()->json($result);
        }

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'advice_alarm', $userAppInfo->advice_alarm ?? 'N');
        $result = Arr::add($result, 'album_alarm', $userAppInfo->album_alarm ?? 'N');
        $result = Arr::add($result, 'attendance_alarm', $userAppInfo->attendance_alarm ?? 'N');
        $result = Arr::add($result, 'notice_alarm', $userAppInfo->notice_alarm ?? 'N');
        $result = Arr::add($result, 'adu_info_alarm', $userAppInfo->adu_info_alarm ?? 'N');
        $result = Arr::add($result, 'event_alarm', $userAppInfo->event_alarm ?? 'N');
        $result = Arr::add($result, 'wifi', $userAppInfo->wifi ?? 'N');

        return response()->json($result);
    }

}

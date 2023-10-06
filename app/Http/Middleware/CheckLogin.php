<?php

namespace App\Http\Middleware;

use App\Models\RaonMember;
use App\UserAppInfo;
use Closure;
use Illuminate\Http\Request;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $fcmToken = ($request->input('fcmToken')) ? $request->input('fcmToken') : "";
        $userId = ($request->input('userId')) ? $request->input('userId') : "";
        $deviceId = ($request->input('deviceId')) ? $request->input('deviceId') : "";
        $deviceKind = ($request->input('os')) ? $request->input('os') : "";
        if ($deviceKind) {
            if ($deviceKind == 'ios') $deviceKind = "iOS";
            else $deviceKind = "android";
        }
        $deviceType = ($request->input('deviceType')) ? $request->input('deviceType') : "";

        $auth = session()->get('auth');
//         \App::make('helper')->vardump($auth);
        if (empty($auth)) {
            $cookieAutoLogin = $request->cookie('auto_login') ?? "";
//            \App::make('helper')->vardump($cookieAutoLogin);
//            exit;

            // 웹 자동로그인 일 경우만 쿠키 처리를 한다. 때문에 웹일경우만 아래 라인을 탄다.
            if ($cookieAutoLogin != "") {
                //디비에 로그인한 정보가 있는지 확인..
                $rs = UserAppInfo::where('user_id', $cookieAutoLogin)
                    ->where('device_kind', "web")
                    ->where('device_type', "web")
                    ->where('device_id', "web")->first();

                $user = RaonMember::whereIdx($cookieAutoLogin)->first();

                //로그인 한 정보가 없을 경우..
                if (empty($rs) || empty($user)) return redirect('/auth/login');

                $deviceKind = $deviceType = $deviceId = "web";

            // 앱 자동로그인이면..
            } else {
                if ($fcmToken == "") return redirect('/auth/login');

                //디비에 로그인한 정보가 있는지 확인..
                $rs = UserAppInfo::where('user_id', $userId)
                    ->where('device_kind', $deviceKind)
                    ->where('device_type', $deviceType)
                    ->where('device_id', $deviceId)->first();

                $user = RaonMember::whereIdx($userId)->first();

                //로그인 한 정보가 없을 경우..
                if (empty($rs) || empty($user)) return redirect('/auth/login?fcmToken='.$fcmToken.'&deviceId='.$deviceId.'&os='.$deviceKind.'&deviceType='.$deviceType);

                // 하위 정보를 찾아 fcm 정보를 갱신해준다.
                $child = UserAppInfo::where('device_kind', $deviceKind)
                    ->where('device_type', $deviceType)
                    ->where('device_id', $deviceId)->get();
                if ($child) {
                    foreach ($child as $k => $l) {
                        UserAppInfo::where('id', "=", $l->id)
                            ->update(
                                [
                                    'push_key' => $fcmToken
                                ]
                            );
                    }
                }
            } // end else

            //세션정보를 만들어 준다.
            $arr = array_merge([
                'user_id' => $rs->user_id,
                'user_name' => $user->name,
                'account_id' => $user->id,
                'user_type' => $user->mtype,
                'login_id' => ($user->mtype == 's') ? str_replace('-', '', $rs->mobilephone ?? '') : $rs->user_id,
//                'login_id' => \App::make('helper')->hypenPhone($rs->phone ?? ''),
                'push_alarm' => $rs->push_alarm,
                'notice_alarm' => $rs->notice_alarm,
                'album_alarm' => $rs->album_alarm,
                'advice_alarm' => $rs->advice_alarm,
                'attendance_alarm' => $rs->attendance_alarm,
                'adu_info_alarm' => $rs->adu_info_alarm,
                'event_alarm' => $rs->event_alarm,
                'auto_login' => 1
            ], [
                'user_type_ko' => \App::make('helper')->getUserType($user->mtype),
                'device_kind' => $deviceKind,
                'device_type' => $deviceType,
                'device_id' => $deviceId,
                'push_key' => $request->input('push_key'),
                'ip' => \App::make('helper')->getClientIp(),
            ]);
//            \App::make('helper')->log('arr', $arr, 'arr');
//            \App::make('helper')->vardump($arr);
//            exit;

            session(['auth' => $arr]);
        }

        return $next($request);
    }
}

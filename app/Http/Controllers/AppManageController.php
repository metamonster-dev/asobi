<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AppManageController extends Controller
{
    public function appMng()
    {
        return view('app/mng');
    }
    public function appAlarm()
    {
        $req = Request::create('/api/alramInfo', 'GET', [
            'user' => \App::make('helper')->getUsertId(),
            'device_id' => session()->get('auth')['device_id'] ?? '',
        ]);
        $userController = new UserController();
        $res = $userController->alramInfo($req);

//        echo "<br>";
//        echo "<br>";
//        echo "<br>";
//        echo "<br>";
//        echo "<br>";
//        echo "<br>";
//        echo "<br>";
//        echo "<br>";
//        echo "<br>";
//        echo "<br>";
//        echo "<br>";
//
//        \App::make('helper')->vardump(\App::make('helper')->getUsertId());
//        \App::make('helper')->vardump(session()->get('auth')['device_id'] ?? []);
//        \App::make('helper')->vardump($res->original ?? []);

        return view('app/alarm',[
            'advice_alarm' => $res->original['advice_alarm'] ?? 'N',
            'album_alarm' => $res->original['album_alarm'] ?? 'N',
            'attendance_alarm' => $res->original['attendance_alarm'] ?? 'N',
            'notice_alarm' => $res->original['notice_alarm'] ?? 'N',
            'adu_info_alarm' => $res->original['adu_info_alarm'] ?? 'N',
            'event_alarm' => $res->original['event_alarm'] ?? 'N',
        ]);
    }
    public function appVersion()
    {
        return view('app/version');
    }
    public function appStorage()
    {
        return view('app/storage');
    }
    public function appPhoto()
    {
        $req = Request::create('/api/alramInfo', 'GET', [
            'user' => \App::make('helper')->getUsertId(),
            'device_id' => session()->get('auth')['device_id'] ?? '',
        ]);
        $userController = new UserController();
        $res = $userController->alramInfo($req);
        return view('app/photo',[
            'wifi' => $res->original['wifi'] ?? 'N',
        ]);
    }

    public function wifiUpdateAction(Request $request)
    {
        $result = [];
        $auth = session()->get('auth');
        $wifi = $request->input('wifi') ?? "N";
        foreach ($auth as $k => &$l) {
            if ($k == 'wifi') {
                $l = $wifi;
            }
        }
        session(['auth' => $auth]);

        $req = Request::create('/api/user/update/wifi', 'POST', [
            'user' => \App::make('helper')->getUsertId(),
            'device_id' => session()->get('auth')['device_id'] ?? '',
            'set' => $wifi,
        ]);
        $userAppInfoController = new UserAppInfoController();
        $res = $userAppInfoController->update($req, 'wifi');
        $result = Arr::add($result, 'result', $res->original['result'] ?? 'fail');
        return response()->json($result);
    }

}

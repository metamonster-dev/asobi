<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function testSession(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
    public function main(Request $request)
    {

        $userId = \App::make('helper')->getUsertId();
        $userType = \App::make('helper')->getUsertType();
        $branch = $center = "";
        if (in_array($userType, ['a','h','m'])) {
            $data = [
                'user' => \App::make('helper')->getUsertId(),
                'list_limit' => '9',
            ];
//            \App::make('helper')->vardump($data);
            $appNoticeReq = Request::create('/api/appNotice/list', 'GET', $data);
            $appNoticeController = new AppNoticeController();
            $appNoticeRes = $appNoticeController->index($appNoticeReq);
//            \App::make('helper')->vardump($appNoticeRes->original);
//            exit;
        }

        $autoLogin = session()->get('auth')['auto_login'] ?? '';
        $deviceKind = session()->get('auth')['device_kind'] ?? '';
        //웹사이트 자동로그인된
        if ($autoLogin =='1' && $deviceKind == 'web') {
            //365 일간 자동로그인
            Cookie::queue('auto_login', \App::make('helper')->getUsertId(), '525600');
        }

        $mainReq = Request::create('/api/main', 'GET', [
            'user' => \App::make('helper')->getUsertId(),
        ]);
        $appMainController = new AppMainController();
        $mainRes = $appMainController->index($mainReq);

//        var_dump(session()->get('branch'));
//        dd(session()->get('center'));

        // 본사면..
        if ($userType == 'a') {
//            $branch = session()->get('branch') ?? '';
//            $center = session()->get('center') ?? '';

            if (session()->get('branch')) {
                $branch = session()->get('branch');
            } else {
                session(['branch' => '70']);
                $branch = '70';
            }

            if (session()->get('center')) {
                $center = session()->get('center');
            }

            if (session()->get('branch') === '70') {
                session(['center' => '86293']);
                $center = '86293';
            }
        }

        // 지사면..
        if ($userType == 'h') {
            $branch = \App::make('helper')->getUsertId();
            $center = session()->get('center') ?? '';
        }

        // 배너
        $bannerReq = Request::create('/api/event/mainBanner', 'GET', []);
        $eventController = new EventController();
        $bannerRes = $eventController->mainBanner($bannerReq);
        // \App::make('helper')->vardump($bannerRes->original['list']);
        // exit;

        return view('main',[
            'appNotice' => $appNoticeRes->original['list'] ?? [],
            'main' => $mainRes->original ?? [],
            'branch' => $branch,
            'center' => $center,
            'mainBanner' => ($bannerRes->original['result'] == 'success') ? $bannerRes->original['list'] ?? [] : [],
            'userId' => $userId,
        ]);
    }

    public function selectAction(Request $request)
    {
        $type = ($request->input('type')) ? $request->input('type') : "";
        $value = ($request->input('value')) ? $request->input('value') : "";

        if (!in_array($type, ['branch', 'center']) || !is_numeric($value)) return redirect('/');

        if ($type == 'branch') {
            session(['branch' => $value]);
            session(['center' => '']);
        } else {
            session(['center' => $value]);
        }
        return redirect('/');
    }

    public function testDatabaseConnections()
    {
        try {
            DB::connection('mysql')->getPdo();
            echo "Connection 1 is established.";
        } catch (\Exception $e) {
            die("Could not connect to the database. Please check your configuration.");
        }

        try {
            DB::connection('mysql')->getPdo();
            echo "Connection 2 is established.";
        } catch (\Exception $e) {
            die("Could not connect to the database. Please check your configuration.");
        }
    }

}

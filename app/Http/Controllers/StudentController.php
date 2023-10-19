<?php

namespace App\Http\Controllers;


use App\Models\RaonMember;
use App\UserAppInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function student()
    {
        $user = \App::make('helper')->getUsertId();
        $userType = \App::make('helper')->getUsertType();
        if (in_array($userType, ['a','h'])) {
            $user = session()->get('center');
        }
        $req = Request::create('/api/children', 'GET', [
            'user' => $user,
        ]);
        $userController = new UserController();
        $res = $userController->children($req);
        return view('student/list',[
            'list' => $res->original['list'] ?? [],
        ]);
    }

    public function changeAction(Request $request)
    {
        $userId = $request->input('user') ?? "";
        if (!is_numeric($userId)) \App::make('helper')->alert("잘못된 접근입니다.1");

        $user = RaonMember::whereIdx($userId)->first();

        //로그인 한 정보가 없을 경우..
        if (empty($user)) \App::make('helper')->alert("잘못된 접근입니다.2");

        $auth = session()->get('auth');

//        echo "<pre>";
//        var_dump($auth);
//        echo "</pre>";

        $sessionUserId = $auth['account_id'] ?? '';

        $sessionUser = RaonMember::where('id','=',$sessionUserId)->first();
        if (empty($sessionUser)) \App::make('helper')->alert("잘못된 접근입니다.3");

        //학부모 자녀의 계정인지 체크
//        $children_rs = RaonMember::where(DB::raw("REPLACE(`mobilephone`, '-', '')"), str_replace('-','',$sessionUser->mobilephone))
        $children_rs = RaonMember::where('idx', '=', $userId)
            ->where('mtype', 's')
//            ->where('idx','=',$userId)
            ->whereIn('s_status', array('W', 'Y'))
//            ->orderBy('s_status', 'desc')
            ->get();

        if ($children_rs->count() == 0) \App::make('helper')->alert("잘못된 접근입니다.4");

        $req = Request::create('/api/logout', 'GET', [
            'user' => $auth['user_id'],
            'device_kind' => $auth['device_kind'],
            'device_type' => $auth['device_type'],
            'device_id' => $auth['device_id'],
            'push_key' => $auth['push_key'],
        ]);

        $userAppInfoController = new UserAppInfoController();
        $req = $userAppInfoController->logout($req);
        if ($req->original['result'] != 'success') \App::make('helper')->alert("잘못된 접근입니다.5");

        $request->session()->flush();

        $ip = \App::make('helper')->getClientIp();
        $req = Request::create('/api/login', 'GET', [
            'login_id' => $user->id,
            'password' => '1',
            'device_kind' => $auth['device_kind'],
            'device_type' => $auth['device_type'],
            'device_id' => $auth['device_id'],
            'push_key' => $auth['push_key'],
            'ip' => $ip,
        ]);
        $response = $userAppInfoController->login($req, true);
        if ($response->original['result'] != 'success') \App::make('helper')->alert("잘못된 접근입니다.6");

        $arr = array_merge($response->original, [
            'user_type_ko' => \App::make('helper')->getUserType($response->original['user_type']),
            'device_kind' => $auth['device_kind'],
            'device_type' => $auth['device_type'],
            'device_id' => $auth['device_id'],
            'push_key' => $auth['push_key'],
            'ip' => $ip,
            'auto_login' => $auth['auto_login'] ?? '',
        ]);
        session(['auth' => $arr]);

        return redirect('/');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $fcmToken = ($request->input('fcmToken')) ? $request->input('fcmToken') : "web";
        $deviceId = ($request->input('deviceId')) ? $request->input('deviceId') : "web";
        $os = ($request->input('os')) ? $request->input('os') : "web";
        $deviceType = ($request->input('deviceType')) ? $request->input('deviceType') : "web";

        return view('auth/login',[
            'device_kind' => $os,
            'device_type' => $deviceType,
            'device_id' => $deviceId,
            'push_key' => $fcmToken,
        ]);
    }

    public function join()
    {
        $req = Request::create('/api/centerAll', 'GET', []);
        $userController = new UserController();
        $res = $userController->centerAll($req);
        $resList = $res->original['list'] ?? [];
        $centerList = [];
        if (count($resList) > 0) {
            foreach ($resList as $l) {
                $centerList[] = [
                    'idx' => $l['id'],
                    'name' => $l['name'],
                ];
            }
        }
        return view('auth/join', [
            'centerList' => json_encode($centerList)
        ]);
    }

    public function joinAction(Request $request)
    {
//        \App::make('helper')->vardump($request->all());

        $marketing = ($request->input('marketing')) ? $request->input('marketing') : "N";
        $request->merge([
            'marketing' => $marketing,
        ]);

        $userController = new UserController();
        $res = $userController->userAdd($request);

        if ($res->original['result'] != 'success') {
            $error = \App::make('helper')->getErrorMsg($res->original['error']);
            \App::make('helper')->alert($error);
        } else {
            \App::make('helper')->alert($res->original['error'] ?? "", '/auth/login');
        }
    }

    public function findId()
    {
        return view('auth/findId');
    }

    public function findPw()
    {
        return view('auth/findPw');
    }

    public function findPwAction(Request $request)
    {
        $req = Request::create('/api/resetPassword', 'POST', [
            'login_id' => $request->input('login_id') ?? '',
            'phone' => $request->input('phone') ?? '',
        ]);
        $userAppInfoController = new UserAppInfoController();
        $res = $userAppInfoController->resetPassword($req);
        $msg = $res->original['error'] ?? '';
        if ($msg == "") $msg = "잘못된 접근입니다.";
        \App::make('helper')->alert($msg);
    }

    public function mypage(Request $request)
    {
        $user = \App::make('helper')->getUsertId();

        $req = Request::create('/api/myInfo', 'GET', [
            'user' => $user,
        ]);
        $userController = new UserController();
        $res = $userController->myInfo($req);

        $login_id = $request->input('login_id');

        if ($login_id) {
            $auth = session()->get('auth') ?? [];
            $newAuth = [];
            foreach ($auth as $k => $item) {
                if ($k == 'login_id') {
                    $item = $login_id;
                }
                $newAuth[$k] = $item;
            }
            $request->session()->forget('auth');
            session(['auth' => $newAuth]);
        }

//        $auth = session()->get('auth') ?? [];
//        \App::make('helper')->vardump("");
//        \App::make('helper')->vardump("");
//        \App::make('helper')->vardump("");
//        \App::make('helper')->vardump("");
//        \App::make('helper')->vardump("");
//        \App::make('helper')->vardump($login_id);
//        \App::make('helper')->vardump($auth);

        // \App::make('helper')->vardump($res->original);
        // exit;
        return view('mypage/mypage',[
            'account' => $res->original ?? []
        ]);
    }

    public function resetPw()
    {
        return view('mypage/resetPw');
    }

    public function resetPwAction(Request $request)
    {
        $password = $request->input('password') ?? '';

        $user = \App::make('helper')->getUsertId();

        $req = Request::create('/api/user/update/password', 'POST', [
            'user' => $user,
            'password' => $password,
        ]);
        $userAppInfoController = new UserAppInfoController();
        $res = $userAppInfoController->update($req, 'password');

        $msg = $res->original['error'] ?? '';
        if ($msg == "") $msg = "잘못된 접근입니다.";
        \App::make('helper')->alert("비밀번호가 변경되었습니다.", '/mypage');
    }

    public function profileAction(Request $request)
    {
        $picture = $request->file('picture') ?? '';

        if ($picture == "") {
            \App::make('helper')->alert("프로필 이미지를 선택해주세요.");
        }

        $user = \App::make('helper')->getUsertId();

        $request->merge([
            'user' => $user,
        ]);
        $userAppInfoController = new UserAppInfoController();
        $res = $userAppInfoController->update($request, 'picture');
//        \App::make('helper')->vardump($user);
//        \App::make('helper')->vardump($picture);
//        \App::make('helper')->vardump($res->original);

        $result = $res->original['result'] ?? '';
        $msg = $res->original['error'] ?? '';
        if ($msg == "") $msg = "잘못된 접근입니다.";
        if ($result != "success") \App::make('helper')->alert($msg);

        \App::make('helper')->alert("프로필 이미지가 변경되었습니다.", "/mypage");
    }

    public function editInfo()
    {
        $user = \App::make('helper')->getUsertId();

        $req = Request::create('/api/myInfo', 'GET', [
            'user' => $user,
        ]);
        $userController = new UserController();
        $res = $userController->myInfo($req);

//        \App::make('helper')->vardump($res->original);

        return view('mypage/editInfo', [
            'row' => $res->original ?? [],
        ]);

    }

    public function editInfoAction(Request $request)
    {
        $marketing = ($request->input('marketing')) ? $request->input('marketing') : "N";
        $request->merge([
            'marketing' => $marketing,
        ]);

        $req = Request::create('/api/user/update/myInfo', 'POST', [
            'user' => \App::make('helper')->getUsertId(),
            'name' => $request->input('name') ?? '',
            'birth' => $request->input('birth') ?? '',
            'sex' => $request->input('sex') ?? '',
            'parent_name' => $request->input('parent_name') ?? '',
            'parent_contact' => $request->input('parent_contact') ?? '',
            'adress' => $request->input('adress') ?? '',
            'adress_desc' => $request->input('adress_desc') ?? '',
            'cognitive_pathway' => $request->input('cognitive_pathway') ?? '',
            'marketing' => $request->input('marketing') ?? '',
        ]);
        // $req = Request::create('/api/user/update/myInfo', 'POST', $request);
        $userAppInfoController = new UserAppInfoController();
        $res = $userAppInfoController->update($req, 'myInfo');
        // \App::make('helper')->vardump($res);

        $result = $res->original['result'] ?? '';
        $login_id = $res->original['login_id'] ?? '';
        \App::make('helper')->alert($res->original['error'] ?? "", '/mypage?login_id='.$login_id);
        return;
    }
}

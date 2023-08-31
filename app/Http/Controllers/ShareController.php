<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use App\AdviceNote;
use App\AdviceNoteHistory;
use App\AdviceNoteShareHistory;
use App\Models\RaonMember;

class ShareController extends Controller
{

    private $encrypt_method = 'AES-256-CBC';
    private $secret_key = 'BwBQ&KlcO#vmW6!N$m6e';
    private $secret_iv = '5fgf5HJ5g27';

    public function index(Request $request)
    {
        $result = array();
        $type = $request->input('type', '');
        $id = $request->input('id', '');

        if (!$type || !$id) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '잘못된 접근입니다.');
            return response()->json($result);
        }

        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        if (!in_array($user->mtype, ['m','s'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        $advice_note = null;

        if ($user->mtype == 'm') {
            $advice_note = AdviceNote::where('id', $id)
                ->where('type', $type)
                ->where('midx', $user_id)
                ->where('status', 'Y')
                ->first();
        } else if ($user->mtype == 's') {
            $advice_note = AdviceNote::where('id', $id)
                ->where('type', $type)
                ->where('sidx', $user_id)
                ->where('status', 'Y')
                ->first();
        }
        if ($advice_note) {
            $hashId = $this->adviceIdConvertHash($id, 'encrypt');

            $share_url = env('APP_URL') . '/share/' . $type . '/' . $hashId;

            $result = Arr::add($result, 'result', 'success');
            $result = Arr::add($result, 'share_url', $share_url);
            $result = Arr::add($result, 'error', '');

            if ($user->mtype == 'm') {
                $nowDate = date('Y-m-d H:i:s', time());

                $advice_note_share_history = AdviceNoteShareHistory::where('advice_note_id', $id)->first();

                if ($advice_note_share_history) {
                    $advice_note_share_history->shared_at = $nowDate;
                    $advice_note_share_history->updated_at = $nowDate;
                } else {
                    $advice_note_share_history = new AdviceNoteShareHistory;

                    $advice_note_share_history->advice_note_id = $id;
                    $advice_note_share_history->shared_at = $nowDate;
                    $advice_note_share_history->created_at = $nowDate;
                }

                $advice_note_share_history->save();
            }

        } else {
            $result = Arr::add($result, 'result', 'fail');
            $message = '데이터가 없습니다.';
            if ($type === 'advice') {
                $message = '알림장이 존재하지 않습니다.';
            } else if ($type === 'letter') {
                $message = '가정통신문이 존재하지 않습니다.';
            }
            $result = Arr::add($result, 'error', $message);
        }

        return response()->json($result);
    }

    public function adviceIdConvertHash($hash, $type)
    {
        $output = false;

        $key = hash('sha256', $this->secret_key);
        $iv = substr(hash('sha256', $this->secret_iv), 0, 16);

        if ($type === 'encrypt') {
            $output = openssl_encrypt($hash, $this->encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if ($type === 'decrypt')
        {
            $output = openssl_decrypt(base64_decode($hash), $this->encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    public function webDeepLink2(Request $request, $type, $id)
    {

        $hashId = $this->adviceIdConvertHash($id, 'decrypt');

        $adviceNoteShareHistory = AdviceNoteShareHistory::where('advice_note_id', $hashId)->first();

        if ($adviceNoteShareHistory) {
            $adviceNoteShareHistory->confirmed_at = date('Y-m-d H:i:s', time());

            $adviceNoteShareHistory->save();
        }

        $app_schema = 'asobi';

        if (env('APP_URL') === 'https://dev.api.asobi.luvill.com') {
            $app_schema = 'asobiappDev';
        }

        return view('share.index', [
            'type' => $type,
            'hashId' => $hashId,
            'app_schema' => $app_schema
        ]);
    }

    public function webDeepLink(Request $request)
    {

        $link = $request->input('link');
//        $link = 'https://asobi.tenbilsoft.com/advice/138435/note/view/774509';
        $result = array();
        $arr = array();
        $arr['dynamicLinkInfo'] = array(
            'domainUriPrefix' => 'https://asobiapp.page.link',
            'link'            => $link,
            'androidInfo'     => array(
                'androidPackageName'  => 'com.asobiapp',
//                'androidFallbackLink' => APP_DOMAIN
            ),
            'iosInfo'         => array(
                'iosBundleId'     => 'com.asobiapp',
                'iosFallbackLink' => '6449076561',
                'iosAppStoreId' => '6449076561',
                'iosCustomScheme' => 'CUSTOM_URL_SCHEME'
            ),
        );
        $res = $this->curlCall(
            "https://firebasedynamiclinks.googleapis.com/v1/shortLinks?key=AIzaSyBYsMF8gK7M3pwaYh_91YNAbEikD6mO8h4",
            $arr,
            "POST",
            array("Content-Type: application/json"),
            $response = "json"
        );

//        \App::make('helper')->log('webDeepLink', ['res' => $res], 'webDeepLink');

        if (isset($res['shortLink'])) {
            $result = Arr::add($result, 'result', 'success');
            $result = Arr::add($result, 'shortLink', $res['shortLink']);
            return response()->json($result);
        }

        $result = Arr::add($result, 'result', 'fail');
        $result = Arr::add($result, 'error', $res);
        return response()->json($result);
    }

    function curlCall($url , $arr, $type, $headers=array(), $response = "json") {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if (count($headers) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if ($response == "header_n_body") {
            curl_setopt($ch, CURLOPT_HEADER, 1);
        }

        if ($type == "POST") {
            curl_setopt($ch, CURLOPT_POST, 1);
        } else if ($type) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
        }

        if (is_array($arr)) {
            if (count($arr) > 0) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arr));
            }
        } else if (is_string($arr)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
        }

        $output = curl_exec($ch);

        if ($response == "header_n_body") {
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        }

        curl_close($ch);

        if ($response == "header_n_body") {
            $header = substr($output, 0, $header_size);
            $body = substr($output, $header_size);
            return array(
                "header_code" => $header_code,
                "header" => $header,
                "body" => json_decode($body, true)
            );
        } else {
            return json_decode($output, true);
        }
    }

}

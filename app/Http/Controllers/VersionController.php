<?php

namespace App\Http\Controllers;

class VersionController extends Controller
{
    public function ios()
    {
        $result = [
            "resultCode" => "1",
            "message" => "성공",
            "data" => [
                "list" => [
                    "knd" => "ios",
                    "updateAt" => "N",
                    "useAt" => "Y",
                    "version" => "1.0.0",
                    "sn" => "1",
                    "message" => [
                        "title" => "기타 버그 수정",
                        "content" => "버그 수정 및 기능 향상",
                    ]
                ]
            ]
        ];
        return response()->json($result);
    }

    public function android()
    {
        $result = [
            "resultCode" => "1",
            "message" => "성공",
            "data" => [
                "list" => [
                    "knd" => "android",
                    "updateAt" => "N",
                    "useAt" => "Y",
                    "version" => "1.0.3",
                    "sn" => "1",
                    "message" => [
                        "title" => "기타 버그 수정",
                        "content" => "버그 수정 및 기능 향상",
                    ]
                ]
            ]
        ];
        return response()->json($result);
    }
}

<?php

namespace App\Http\Controllers;

use App\Jobs\BatchPush;
use App\Services\FcmService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $fcmService;

    public function __construct(FcmService $fcmService)
    {
        $this->fcmService = $fcmService;
    }

    public function sendNotification(Request $request)
    {
        BatchPush::dispatch(['type' => 'test', 'type_id' => null, 'param' => []]);
//        $tokenList = '';
//        $title = 'title';
//        $body = 'body';
//        $data = [];
//
//        try {
//            $this->fcmService->sendNotification($tokenList, $title, $body, $data);
//            return response()->json(['success' => true]);
//        } catch (\Exception $e) {
//            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
//        }
    }
}

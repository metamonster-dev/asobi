<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Psr\Log\LoggerInterface;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class FcmHandler
{
    const MAX_TOKEN_PER_REQUEST = 500;
//    const API_ENDPOINT = 'fcm/send';
  const API_ENDPOINT = 'https://fcm.googleapis.com/v1/projects/new-asobi/messages:send';


    private $httpClient;
    private $deviceRepo;
    private $logger;

    private $receivers;
    private $message;
    private $message_data;
    private $retryIntervalInUs = 100000; // 100ms
    private $maxRetryCount = 3;
    private $retriedCount = 0;

    public function __construct(
        GuzzleClient        $httpClient,
        FcmDeviceRepository $deviceRepo,
        LoggerInterface     $logger
    )
    {
        $this->httpClient = $httpClient;
        $this->deviceRepo = $deviceRepo;
        $this->logger = $logger;
    }

    public function sendMessage($mode = 'production', $accessToken = null)
    {
        if (count(array_filter($this->receivers)) === 0) {
            $this->logProgress('푸쉬 알림을 전송을 건너 뜁니다: 수신자가 없습니다.');
            return;
        }

        if ($this->isInitialRequest()) {
//      $this->logProgress('푸쉬 알림을 전송합니다.', [
//        'receivers' => $this->receivers,
//        'message' => $this->message,

//      ], 'debug');
        }

//        try {
            if (count($this->receivers) > self::MAX_TOKEN_PER_REQUEST) {
                $response = null;
                foreach (array_chunk($this->receivers, self::MAX_TOKEN_PER_REQUEST) as $chunk) {
//          $responsePartial = $this->_sendMessage($chunk, $mode, $accessToken);
                    $this->sendMessagesToMultipleTokens($chunk, $mode, $accessToken);
//          if (!$response) {
//            $response = $responsePartial;
//          } else {
//            $response->merge($responsePartial);
//          }

                    sleep(1);
                }
            } else {
//        $response = $this->_sendMessage($this->receivers, $mode, $accessToken);

                $this->sendMessagesToMultipleTokens($this->receivers, $mode, $accessToken);
            }

//      $this->updatePushServiceIdsIfAny($response);
//      $this->handleDeliveryFailureIfAny($response);

//       return $this->responseInJson['results'];
//      $this->logProgress("푸쉬 알림을 전송했습니다.", [
//        'receiver' => $this->receivers,
//      ]);
//        } catch (Exception $e) {
//      $this->logProgress("푸쉬 알림을 전송하지 못헸습니다: {$e->getMessage()}", [
//        'receiver' => $this->receivers,
//      ], 'error');
//            throw $e;
//        }
    }

    public function setReceivers(array $receivers)
    {
        $this->receivers = $receivers;
    }

    public function setMessage(array $message)
    {
        $this->message = $message;
    }

    public function setMessageData(array $message)
    {
        $this->message_data = $message;
    }

//    private function _sendMessage(array $tokens, $mode = 'production', $accessToken = null)
//    {
//        $request = $this->getRequest($tokens, $mode, $accessToken);
//
//        $guzzleResponse = $this->httpClient->send($request);
//
//        $body = $guzzleResponse->getBody();  // 스트림에서 본문을 가져옴
//        $content = $body->getContents();     // 본문 내용을 문자열로 변환
//
//
//
////        if ($mode === 'test') {
//            $responseBody = (string)$guzzleResponse->getBody();
//
//            return $responseBody;
////        }
//
////    $this->logger->log('debug', "[FcmHandler] guzzleResponse : ", ['guzzleResponse' => $guzzleResponse->getBody()]);
//        // $this->responseInJson = \GuzzleHttp\json_decode($guzzleResponse->getBody(), true);
////        return new DownstreamResponse($guzzleResponse, $tokens);
//    }

    private function sendMessagesToMultipleTokens(array $tokens, $mode = 'production', $accessToken = null)
    {
//        $this->logProgress('푸쉬 알림을 전송합니다.', [
//            'receivers' => $tokens,
//            'message' => $this->message,
//        ], 'debug');

        $responseBody = '';
        foreach ($tokens as $token) {
            try {
                $request = $this->getRequest([$token], $mode, $accessToken);  // 단일 토큰만 배열로 넘김
                $guzzleResponse = $this->httpClient->send($request);

                $body = $guzzleResponse->getBody();  // 스트림에서 본문을 가져옴
                $content = $body->getContents();     // 본문 내용을 문자열로 변환

                $responseBody = (string)$guzzleResponse->getBody();

                \App::make('helper')->log('arr_push', ['this~result@' => $responseBody]);

//            $this->updatePushServiceIdsIfAny(new DownstreamResponse($guzzleResponse, [$token]));
//            $this->handleDeliveryFailureIfAny2(new DownstreamResponse($guzzleResponse, [$token]));
            } catch (Exception $e) {
                $this->logProgress("푸쉬 알림을 전송하지 못했습니다: {$e->getMessage()}", [
                    'receiver' => $token,
                ], 'error');
            }
        }

//        return $responseBody;
    }

//    private function _sendMessageAsync(array $tokens, $mode = 'production', $accessToken = null): PromiseInterface
//    {
//        $promises = [];
//
//        foreach ($tokens as $token) {
//            $request = $this->getRequest([$token], $mode, $accessToken);  // 단일 토큰 처리
//
//            // 비동기 요청
//            $promises[] = $this->httpClient->sendAsync($request)->then(
//                function ($response) use ($token) {
//                    $body = $response->getBody();
//                    $content = $body->getContents();
//                    echo "응답 성공 (" . $token . "): " . $content . "\n";
//                },
//                function ($error) use ($token) {
//                    echo "응답 실패 (" . $token . "): " . $error->getMessage() . "\n";
//                }
//            );
//        }
//    }

    private function getRequest(array $tokens, $mode = 'production', $accessToken = null)
    {
        $projectId = env('FIREBASE_PROJECT_ID', 'new-asobi');
        $hasV1     = !empty($accessToken);

        $title     = $this->message['title'] ?? null;
        $body      = $this->message['body']  ?? null;
        $data      = (isset($this->message_data) && is_array($this->message_data)) ? $this->message_data : [];
        $channelId = $data['channel_id'] ?? 'default_high';

        $buildV1Message = function (string $token) use ($title, $body, $data, $channelId) {
            $msg = [
                'token'   => $token,
                'android' => [
                    'priority'     => 'HIGH',
                    'notification' => [
                        'channel_id' => $channelId,
                        'sound'      => 'default',
                    ],
                ],
                'apns' => [
                    'headers' => [
                        'apns-push-type' => 'alert',
                        'apns-priority'  => '10',
                    ],
                    'payload' => [
                        'aps' => ['sound' => 'default'],
                    ],
                ],
                'data' => array_map('strval', $data),
            ];

            if (!empty($title) || !empty($body)) {
                $msg['notification'] = [
                    'title' => (string)($title ?? ''),
                    'body'  => (string)($body  ?? ''),
                ];
            } else {
                $msg['apns']['headers']['apns-push-type'] = 'background';
                $msg['apns']['headers']['apns-priority']  = '5';
                unset($msg['notification']);
            }
            return $msg;
        };

        try {
            if ($hasV1) {
                $headers = [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type'  => 'application/json',
                ];

                if (count($tokens) > 1) {
                    $url      = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:batchSend";
                    $messages = [];
                    foreach ($tokens as $t) {
                        $messages[] = $buildV1Message($t);
                    }
                    $httpBody = json_encode(['messages' => $messages], JSON_UNESCAPED_UNICODE);
                } else {
                    $url      = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";
                    $httpBody = json_encode(['message' => $buildV1Message($tokens[0])], JSON_UNESCAPED_UNICODE);
                }
            } else {
                $serverKey = env('FCM_SERVER_KEY');
                $headers   = [
                    'Authorization' => 'key=' . $serverKey,
                    'Content-Type'  => 'application/json',
                ];

                $payload = [
                    'priority' => 'high',
                    'data'     => array_map('strval', $data),
                ];
                if (!empty($title) || !empty($body)) {
                    $payload['notification'] = [
                        'title' => (string)($title ?? ''),
                        'body'  => (string)($body  ?? ''),
                        'sound' => 'default',
                    ];
                }
                if (count($tokens) > 1) {
                    $payload['registration_ids'] = $tokens;
                } else {
                    $payload['to'] = $tokens[0];
                }

                $httpBody = json_encode($payload, JSON_UNESCAPED_UNICODE);
                $url      = self::API_ENDPOINT ?? 'https://fcm.googleapis.com/fcm/send';
            }

            $response = $this->httpClient->post($url, [
                'headers' => $headers,
                'body'    => $httpBody,
            ]);

            $status = $response->getStatusCode();
            $body   = json_decode((string)$response->getBody(), true);

            if ($status >= 400 || isset($body['error'])) {
                foreach ($tokens as $token) {
                    \DB::table('user_app_infos')
                        ->where('push_key', $token)
                        ->update(['push_key' => null]);
                }
                $this->logger->warning("[FcmHandler] FCM error, tokens invalidated", [
                    'tokens' => $tokens,
                    'resp'   => $body,
                ]);
            }

            return $body;

        } catch (\Throwable $e) {
            foreach ($tokens as $token) {
                \DB::table('user_app_infos')
                    ->where('push_key', $token)
                    ->update(['push_key' => null]);
            }
            $this->logger->error("[FcmHandler] Failed to send request.", [
                'exception' => $e->getMessage(),
                'tokens'    => $tokens,
            ]);
            return false;
        }
    }

//    private function updatePushServiceIdsIfAny(DownstreamResponse $response)
//    {
//        if ($response->numberModification() <= 0) {
//            return;
//        }
//
//        /**
//         * @var array $pushServiceIdsToModify {
//         * @var string $oldPushServiceId => string $newPushServiceId
//         * }
//         */
//        $pushServiceIdsToModify = $response->tokensToModify();
//
//        // 메시지는 성공적으로 전달되었습니다.
//        // 단말기 공장 초기화 등의 이유로 구글 FCM Server에 등록된 registration_id가 바뀌었습니다.
//        $this->logProgress('구글 서버와 push_service_id 를 동기화합니다.', [
//            'push_service_id_to_modify' => $pushServiceIdsToModify
//        ]);
//
//        foreach ($pushServiceIdsToModify as $oldPushServiceId => $newPushServiceId) {
//            $this->deviceRepo->updateFcmDevice($oldPushServiceId, $newPushServiceId);
//        }
//    }

//    private function handleDeliveryFailureIfAny(DownstreamResponse $response)
//    {
//        if ($response->numberFailure() <= 0) {
//            return;
//        }
//
//        $pushServiceIdsToDelete = $response->tokensToDelete();
//        if (!empty($pushServiceIdsToDelete)) {
//            // 해당 registration_id를 가진 단말기가 구글 FCM 서비스에 등록되어 있지 않습니다.
//            $this->logProgress('사용불가한 push_service_id 를 삭제합니다.', [
//                'push_service_ids_to_delete' => $pushServiceIdsToDelete
//            ]);
//
//            foreach ($pushServiceIdsToDelete as $pushServiceIdToDelete) {
//                $this->deviceRepo->deleteFcmDevice($pushServiceIdToDelete);
//            }
//        }
//
//        $pushServiceIdsToRetry = $response->tokensToRetry();
//        if (!empty($pushServiceIdsToRetry)) {
//            if ($this->isFinalRetry()) {
//                // 재시도 했지만 메시지 전송에 실패했습니다.
//                throw new Exception();
//            }
//
//            // 최대 3회, 1회는 기본값, 다음 루프는 2회, 3회까지 실행됨.
//            $this->retriedCount = $this->retriedCount + 1;
//            // (최초 1회 200밀리초 뒤 실행, 2회 400밀리초 뒤, 3회 800밀리초 뒤) -> 프로세스가 총 1.4초동안 실행됨.
//            // @see https://firebase.google.com/docs/cloud-messaging/http-server-ref?hl=ko#error-codes
//            $this->retryIntervalInUs = $this->retryIntervalInUs * 2;
//
//            usleep($this->retryIntervalInUs);
//
//            $this->logProgress("{$this->getOrdinalRetryCount()} 재전송 시도합니다.", [
//                'retried_count' => $this->retriedCount,
//                'push_service_ids_to_retry' => $pushServiceIdsToRetry,
//            ]);
//
//            $this->receivers = $pushServiceIdsToRetry;
//            $this->sendMessage();
//        }
//    }

    private function isInitialRequest()
    {
        return $this->retriedCount === 0;
    }

    private function isFinalRetry()
    {
        return $this->retriedCount === $this->maxRetryCount;
    }

    private function getOrdinalRetryCount()
    {
        switch ($this->retriedCount) {
            case 1:
                return '첫번째';
            case 2:
                return '두번째';
            case 3:
                return '세번째';
            default:
                return '';
        }
    }

    private function logProgress(string $message, $context = [], string $level = 'debug')
    {
        $this->logger->log($level, "[FcmHandler] {$message}", $context);
    }

    private function handleDeliveryFailureIfAny2(DownstreamResponse $responses)
    {
        $pushServiceIdsToDelete = [];
        $pushServiceIdsToRetry = [];

        foreach ($responses as $response) {
            // HTTP v1에서는 각 요청에 대한 상태 코드와 에러 메시지가 응답으로 온다.
            if (isset($response['error'])) {
                $error = $response['error']['message'];
                $token = $response['token'];

                if ($error === 'UNREGISTERED' || $error === 'INVALID_ARGUMENT') {
                    // 유효하지 않은 토큰이므로 삭제 리스트에 추가
                    $pushServiceIdsToDelete[] = $token;
                } elseif ($error === 'UNAVAILABLE' || $error === 'INTERNAL') {
                    // 일시적인 서버 오류로 인한 재시도 필요
                    $pushServiceIdsToRetry[] = $token;
                }
            }
        }

        if (!empty($pushServiceIdsToDelete)) {
            $this->logger->info('사용 불가한 push_service_id를 삭제합니다.', [
                'push_service_ids_to_delete' => $pushServiceIdsToDelete,
            ]);

            foreach ($pushServiceIdsToDelete as $pushServiceIdToDelete) {
                $this->deviceRepo->deleteFcmDevice($pushServiceIdToDelete);
            }
        }

        if (!empty($pushServiceIdsToRetry)) {
            if ($this->isFinalRetry()) {
                // 최대 재시도 횟수를 초과했을 때 예외 처리
                throw new \Exception('메시지 전송에 실패했습니다.');
            }

            // 재시도 로직
            $this->retriedCount++;
            $this->retryIntervalInUs *= 2; // 재시도 간격을 증가
            usleep($this->retryIntervalInUs);

            $this->logger->info("{$this->getOrdinalRetryCount()} 재전송 시도합니다.", [
                'retried_count' => $this->retriedCount,
                'push_service_ids_to_retry' => $pushServiceIdsToRetry,
            ]);

//            $this->fcmHandler->setReceivers($pushServiceIdsToRetry);
//            $this->fcmHandler->sendMessage('test', $this->getAccessToken());
        }
    }

}

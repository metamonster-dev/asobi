<?php

namespace App\Services;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Psr\Log\LoggerInterface;

class FcmService
{
    protected $httpClient;
    protected $config;
    protected $logger;
    protected $fcmHandler;

    public function __construct(
        GuzzleClient $httpClient,
        ConfigRepository $config,
        LoggerInterface $logger,
        FcmHandler $fcmHandler
    ) {
        $this->httpClient = $httpClient;
        $this->config = $config;
        $this->logger = $logger;
        $this->fcmHandler = $fcmHandler;
    }

    public function getAccessToken()
    {
        $serviceAccountPath = base_path('new-asobi-firebase-adminsdk-b3f3k-f6e0eaac9a.json');

        $jsonKey = json_decode(file_get_contents($serviceAccountPath), true);

        $header = [
            'alg' => 'RS256',
            'typ' => 'JWT',
        ];

        $now = time();
        $claimSet = [
            'iss' => $jsonKey['client_email'],
            'scope' => 'https://www.googleapis.com/auth/cloud-platform',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now,
        ];

        $jwtHeader = $this->base64UrlEncode(json_encode($header));
        $jwtClaimSet = $this->base64UrlEncode(json_encode($claimSet));
        $unsignedToken = $jwtHeader . '.' . $jwtClaimSet;

        $signature = '';
        $privateKey = $jsonKey['private_key'];
        openssl_sign($unsignedToken, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        $signedToken = $unsignedToken . '.' . $this->base64UrlEncode($signature);

        $response = $this->httpClient->post('https://oauth2.googleapis.com/token', [
            'form_params' => [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $signedToken,
            ]
        ]);

        $jsonResponse = json_decode($response->getBody(), true);

        return $jsonResponse['access_token'];
    }

    public function sendNotification($receivers, $data)
    {
        $accessToken = $this->getAccessToken();

        $stringData = $this->convertDataToString($data);

//        \App::make('helper')->log('arr_push', ['thisreceivers' => $receivers]);
//        \App::make('helper')->log('arr_push', ['thisvalue' => $stringData]);

        $this->fcmHandler->setReceivers($receivers);
        $this->fcmHandler->setMessage($stringData);
        $this->fcmHandler->setMessageData($stringData);

        $this->fcmHandler->sendMessage('test', $accessToken);
    }

    private function convertDataToString(array $data): array
    {
        // 배열의 모든 값을 문자열로 변환
        return array_map(function ($value) {
            return (string) $value;
        }, $data);
    }

    private function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}

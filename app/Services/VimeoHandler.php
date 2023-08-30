<?php

namespace App\Services;

use Exception;
use Psr\Log\LoggerInterface;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

use Vimeo\Vimeo;
use Vimeo\Exceptions\VimeoUploadException;  

class VimeoHandler
{

    private $vimeoClient;
    private $contentRepo;
    private $logger;

    public function __construct(
        Vimeo $vimeoClient,
        VimeoContentRepository $contentRepo,
        LoggerInterface $logger
    ) {
        $this->vimeoClient = $vimeoClient;
        $this->contentRepo = $contentRepo;
        $this->logger = $logger;
    }

    //sample
    public function uploadVimeoContent(string $contentId, string $contentFilePath)
    {

        if (! empty($contentPath)) {

            $this->logProgress('Vimeo 서버에 동영상을 업로드합니다.', [
                'contentId' => $contentId
            ]);

            $this->contentRepo->uploadVimeoContent($contentId, $vimeoContentId);
        }
    }

    //contentId : transactioin id
    public function upload(string $transactionId, string $filePath, $filename, string $name, string $description)
    {
        //$client = new Vimeo(env('VIMEO_CLIENT_ID', ''), env('VIMEO_CLIENT_SECRET', ''), env('VIMEO_ACCESS_TOKEN', ''));
        
        if (! empty($filename)) {

            $this->logProgress('vimeo 동영상 upload 처리합니다.', [
                'filename' => $filename
            ]);

            // vimeo 동영상 upload 처리
            $uri = $this->vimeoClient->upload($filePath. $filename, array(
                "name" => $name,
                "description" => $description
            ));

            $strArray = explode('/',$uri);
            $videoId = end($strArray);

            $this->logProgress('vimeo 동영상 upload 완료되었습니다.', [
                'filename' => $filename,
                'videoId' => $videoId
            ]);

            $this->contentRepo->uploadVimeoContentResult($transactionId, $videoId);
            
            return $videoId;

            // // 아래 로직은 video 트랜스코딩 상태를 알려줍니다. 업로드 완료후 상태를 체크 할 필요가 있습니다.
            // // 별도의 api를 만들어서 사용하시면 될 것 같습니다.
            // $response = $this->vimeoClient->request($uri . '?fields=transcode.status');
            // if ($response['body']['transcode']['status'] === 'complete') {
            //     // print 'Your video finished transcoding.';
            //     return response()->json([ 'data' => $response['body']['transcode']['status']." uri:".$uri ], 200);
            // } elseif ($response['body']['transcode']['status'] === 'in_progress') {
            //     // print 'Your video is still transcoding.';
            //     return response()->json([ 'data' => $response['body']['transcode']['status']." uri:".$uri ], 200);
            // } else {
            //     // print 'Your video encountered an error during transcoding.';
            //     return response()->json([ 'data' => 'Your video encountered an error during transcoding.'." uri:".$uri ], 200);
            // }
        }

    }

    // vimeo 해당 동영상 삭제하기
    public function delete(String $videoId)
    {
        $uri = "/videos/" . $videoId;
        $response = $this->vimeoClient->request($uri, array(), 'DELETE');
        $this->contentRepo->deleteVimeoContentResult($videoId);
        if ($response['status'] == 204) {
            return $response['status'];
        } else {
            return $response['body']['error'];
        }
    }

    // vimeo 동영상 트랜스코딩 상태 가져오기
    public function checkTranscodeStatus(String $videoId)
    {
        $uri = "/videos/" . $videoId;
        $response = $this->vimeoClient->request($uri . '?fields=transcode.status');
        //'complete'	Transcoding is complete
        //'error'	    Something went wrong. Try the upload again.
        //'in_progress'	Transcoding is still underway.
        if ($response['status'] == 200) {
            return $response['body']['transcode']['status'];
        } else {
            return $response['body']['error'];
        }
    }

    // vimeo 동영상 링크 가져오기
    public function getLinkVideo(String $videoId)
    {
        $uri = "/videos/" . $videoId;
        $response = $this->vimeoClient->request($uri . '?fields=link');
        if ($response['status'] == 200) {
            return $response['body']['link'];
        } else {
            return $response['body']['error'];
        }
    }

    // vimeo 동영상 전체 정보들 가져오기
    public function videos()
    {
        $response = $this->vimeoClient->request('/me/videos', array(), 'GET');
        return response()->json([ 'data' => $response ], 200);
    }

    // vimeo 해당 동영상 정보 가져오기
    public function show(String $videoId)
    {
        $response = $this->vimeoClient->request('/me/videos/' . $videoId, array(), 'GET');
        return response()->json([ 'data' => $response ], 200);
    }

    // vimeo 해당 동영상 정보 수정하기
    public function update(String $videoId, $name, $description)
    {   
        $uri = "/videos/" . $videoId;
        $response = $this->vimeoClient->request($uri, array(
            'name' => $name,
            'description' => $description
          ), 'PATCH');
        // echo 'The title and description for ' . $uri . ' has been edited.';
        return response()->json([ 'data' => $response ], 200);
    }

    private function logProgress(string $message, $context = [], string $level = 'debug')
    {
        $this->logger->log($level, "[VimeoHandler] {$message}", $context);
    }
}

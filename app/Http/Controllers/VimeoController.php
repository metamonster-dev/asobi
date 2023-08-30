<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Vimeo\Vimeo;


class VimeoController extends Controller
{
    public function __construct()
    {

    }

    public function upload_simple($file)
    {
        $client = new Vimeo(config('vimeo.client_id'), config('vimeo.client_secret'), config('vimeo.access_token'));
        $uri = $client->upload($file->getPathName());
        $result = Str::replaceFirst('/videos/', '', $uri);

//    $response = $client->request($uri . '?fields=transcode.status');
//    dump($response);
//    dump($result);

        return $result;
    }

    public function upload(Request $request)
    {
        $client = new Vimeo(env('VIMEO_CLIENT_ID', ''), env('VIMEO_CLIENT_SECRET', ''), env('VIMEO_ACCESS_TOKEN', ''));

        if ($request->hasFile('upload_files')) {
            $upload_files = $request->file('upload_files');
            foreach ($upload_files as $file) {
                if (Str::startsWith($file->getMimeType(), 'video')) {
//        $file = Request::file('file');
                    $name = $file->getClientOriginalName();
//          $description = Request::input('description');
                    $filename = $file->getClientOriginalName();
                    $path = public_path() . '/uploads/'; // 동영상을 임시로 저장할 경로 지정
                    $file->move($path, $filename);
                    // vimeo 동영상 upload 처리
                    $uri = $client->upload($path . $filename, array(
                        "name" => $name
                    ));
                    dump($uri);
                    // 아래 로직은 video 트랜스코딩 상태를 알려줍니다. 업로드 완료후 상태를 체크 할 필요가 있습니다.
                    // 별도의 api를 만들어서 사용하시면 될 것 같습니다.
                    $response = $client->request($uri . '?fields=transcode.status');
                    dump($response);
                    if ($response['body']['transcode']['status'] === 'complete') {
                        // print 'Your video finished transcoding.';
                        return response()->json(['data' => $response['body']['transcode']['status'] . " uri:" . $uri], 200);
                    } elseif ($response['body']['transcode']['status'] === 'in_progress') {
                        // print 'Your video is still transcoding.';
                        return response()->json(['data' => $response['body']['transcode']['status'] . " uri:" . $uri], 200);
                    } else {
                        // print 'Your video encountered an error during transcoding.';
                        return response()->json(['data' => 'Your video encountered an error during transcoding.' . " uri:" . $uri], 200);
                    }
                }
            }
        }
    }

    public function upload2(Request $request)
    {
        $client = new Vimeo(env('VIMEO_CLIENT_ID', ''), env('VIMEO_CLIENT_SECRET', ''), env('VIMEO_ACCESS_TOKEN', ''));

        $results = [];
        if ($request->hasFile('upload_files')) {
            $upload_files = $request->file('upload_files');

            foreach ($upload_files as $file) {
                if (Str::startsWith($file->getMimeType(), 'video')) {
                    $uri = $client->upload($file->getPathName());
                    $results[] = Str::replaceFirst('/videos/', '', $uri);
                }
            }
        }
        return response()->json($results);
    }

    public function videos(Request $request)
    {
        $client = new Vimeo(env('VIMEO_CLIENT_ID', ''), env('VIMEO_CLIENT_SECRET', ''), env('VIMEO_ACCESS_TOKEN', ''));
        // vimeo 동영상 전체 정보들 가져오기
        $response = $client->request('/me/videos', array(), 'GET');
        return response()->json(['data' => $response], 200);
    }

    public function show(Request $request, $video)
    {
        $client = new Vimeo(env('VIMEO_CLIENT_ID', ''), env('VIMEO_CLIENT_SECRET', ''), env('VIMEO_ACCESS_TOKEN', ''));
        // vimeo 해당 동영상 정보 가져오기
        $response = $client->request('/me/videos/' . $video, array(), 'GET');
        return response()->json(['data' => $response], 200);
    }

    public function thumbnail(Request $request, $vimeo_id)
    {
        $thumbnail_large = array('link'=>null);

        $vimeo = new Vimeo(env('VIMEO_CLIENT_ID'), env('VIMEO_CLIENT_SECRET'), env('VIMEO_ACCESS_TOKEN'));
        $video = $vimeo->request('/videos/' . $vimeo_id);

        if ($video['status'] == '200') {
            $pictures = $video['body']['pictures'];

            if( !empty($pictures['sizes']) ) {
                $thumbnail_large = $pictures['sizes'][3];
            }
        }

        return response()->json(['data' => $thumbnail_large['link']], 200);
    }

    public function update(Request $request, $video)
    {
        $client = new Vimeo(env('VIMEO_CLIENT_ID', ''), env('VIMEO_CLIENT_SECRET', ''), env('VIMEO_ACCESS_TOKEN', ''));

        $uri = "/videos/" . $video;
        $name = $request->input('name');
        $description = $request->input('description');
        // vimeo 해당 동영상 정보 수정하기
        $response = $client->request($uri, array(
            'name' => $name,
            'description' => $description
        ), 'PATCH');
        // $response = $client->request($uri, $request->all(), 'PATCH');
        return response()->json([$response,$uri]);
    }

    public function delete(Request $request, $video)
    {
        $client = new Vimeo(env('VIMEO_CLIENT_ID', ''), env('VIMEO_CLIENT_SECRET', ''), env('VIMEO_ACCESS_TOKEN', ''));

        $uri = "/videos/" . $video;
        // vimeo 해당 동영상 삭제하기
        $response = $client->request($uri, array(), 'DELETE');
        return response()->json(['data' => $response], 200);
    }

    public function delete2($videoId)
    {
        $client = new Vimeo(env('VIMEO_CLIENT_ID', ''), env('VIMEO_CLIENT_SECRET', ''), env('VIMEO_ACCESS_TOKEN', ''));

        $uri = "/videos/" . $videoId;
        // vimeo 해당 동영상 삭제하기
        return $client->request($uri, array(), 'DELETE');
    }

}

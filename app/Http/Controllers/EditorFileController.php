<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\AppendFile;
use App\EditorFile;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Validator;
use App\Rules\UploadFile;

class EditorFileController extends Controller
{
    public function store(Request $request)
    {
        $result = array();
        $type = $request->input('type');

        if ($type == "" || !in_array($type, ['1','2'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '잘못된 타입입니다.');
            return response()->json($result);
        }

        $validator = Validator::make($request->all(), [
            'upload' => ['image', new UploadFile],
        ]);

        if($validator->fails()){
            return response()->json([
                'uploaded' => 0,
                'error' => [
                    "message" => "업로드 하려는 파일은 이미지만 가능하고 이미지는 10Mb이하만 가능합니다.",
                ]
            ]);
        }

        //등록 시 하루전 타입 아이디가 저장되지 않은 파일은 삭제 처리한다.
        $now = Carbon::now();
        $rs = EditorFile::whereNull('type_id')->where('created_at', '<', $now->subDays(1))->get();
        if ($rs) {
            foreach ($rs as $file) {
                if ($file->vimeo_id) {
                    $vimeo = new VimeoController();
                    $rs = $vimeo->delete2($file->vimeo_id);
                } else {
                    $rs = \App::make('helper')->deleteImage($file->file_path);
                }
                $file->delete();
            }
        }

        $file = $request->file('upload');
        $editorIds = [];
        if ($file) {
            $vimeo = new VimeoController();
            $file_name = $file->getClientOriginalName();
            $vimeo_id = null;

            if (Str::startsWith($file->getMimeType(), 'video')) {
                $vimeo_id = $vimeo->upload_simple($file);
            }

            if ($vimeo_id) {
                $file_path = AppendFile::getVimeoThumbnailUrl($vimeo_id);
            } else {
                $file = \App::make('helper')->rotateImage($file);
                $file_path = \App::make('helper')->putResizeS3(EditorFile::FILE_DIR, $file);
//                $file_path = \App::make('helper')->putS3(EditorFile::FILE_DIR, $file);
            }

            $payload = [
                'type' => $type,
                'file_name' => $file_name,
                'file_path' => $file_path,
                'file_size' => $file->getSize(),
                'file_mimetype' => $file->getMimeType(),
                'vimeo_id' => $vimeo_id,
            ];
            $file = new EditorFile($payload);
            $file->save();

            $editorIds[] = $file->id;

            $result = Arr::add($result, "url", $file->vimeo_id ? AppendFile::getVimeoThumbnailUrl($file->vimeo_id) : \App::make('helper')->getImage($file->file_path));
            $result = Arr::add($result, "url", $file_name);
        }

        if (count($editorIds) > 0) {
            $result = Arr::add($result, 'uploaded', 1);

            return response()->json($result);
        } else {
            return response()->json([
                'uploaded' => 0,
                'error' => [
                    "message" => "저장 처리에 실패하였습니다.",
                ]
            ]);
        }
    }
}

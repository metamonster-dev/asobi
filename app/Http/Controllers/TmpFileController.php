<?php

namespace App\Http\Controllers;

use App\AppendFile;
use App\File;
use App\AdviceFile;
use App\AlbumFile;
use App\NoticeFile;
use App\Rules\UploadFile;
use App\Models\RaonMember;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Validator;

class TmpFileController extends Controller
{
    public function index(Request $request)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        $type = $request->input('type') ?? "";
        if (!in_array($type, ['3','4','5'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '타입은 3,4,5만 허용됩니다.');
            return response()->json($result);
        }

        $rs = File::where('type', $type)
            ->where('type_id', '=', $user_id)
            ->orderBy('created_at')
            ->get();

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'count', $rs->count());

        if ($rs) {
            foreach ($rs as $index => $file) {
                $result = Arr::add($result, "list.{$index}.file_id", $file->id);
                $result = Arr::add($result, "list.{$index}.file_name", $file->file_name);
//                $result = Arr::add($result, "list.{$index}.file_path", $file->vimeo_id ? AppendFile::getVimeoThumbnailUrl($file->vimeo_id) : \App::make('helper')->getImage($file->file_path));
                $result = Arr::add($result, "list.{$index}.file_path", \App::make('helper')->getImage($file->file_path));
                $result = Arr::add($result, "list.{$index}.vimeo_id", $file->vimeo_id ? $file->vimeo_id : null);
            }
        }

        return response()->json($result);
    }

    public function fileSize(Request $request)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        $rs = File::select(DB::raw("sum(file_size) as sum_size"))
            ->whereIn('type',['3','4','5'])
            ->where('type_id', '=', $user_id)
            ->first();

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'sum', $rs->sum_size ?? "0");

        return response()->json($result);
    }

    public function store(Request $request)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        $type = $request->input('type') ?? "";
        if (!in_array($type, ['3','4','5'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '타입은 3,4,5만 허용됩니다.');
            return response()->json($result);
        }

        $validator = Validator::make($request->all(), [
            'upload_files' => [new UploadFile],
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => 'fail',
                'error' => "업로드 하려는 파일은 동영상, 이미지만 가능하고 이미지는 10Mb이하, 동영상은 100Mb 이하로만 가능합니다."
            ]);
        }

        $delete_files = $request->input('delete_files') ?? "";

        if ($delete_files) {
            $deleteFileArr = explode(",", $delete_files);

            //기존 파일 확인
            $files = File::where('type', $type)
                ->where('type_id', '=', $user_id)
                ->whereIn('id', $deleteFileArr)
                ->orderByDesc('created_at')
                ->get();

            //기존 임시등록된 파일 삭제
            if ($files) {
                foreach ($files as $file) {
                    if ($file->vimeo_id) {
//                        $vimeo = new VimeoController();
//                        $rs = $vimeo->delete2($file->vimeo_id);
                        $rs = \App::make('helper')->deleteImage($file->file_path);
                    } else {

                        $rs = \App::make('helper')->deleteImage($file->file_path);
                    }
                    $file->delete();
                }
            }
        } elseif ($type == '4') {
            //기존 파일 확인
            $files = File::where('type', $type)
                ->where('type_id', '=', $user_id)
                ->get();

            //기존 임시등록된 파일 삭제
            if ($files) {
                foreach ($files as $file) {
                    $rs = \App::make('helper')->deleteImage($file->file_path);
                    $file->delete();
                }
            }
        }

        //등록
        $upload_files = $request->file('upload_files');
        if ($upload_files) {
//            $file_dir = AdviceFile::FILE_DIR;
//            if ($type == "4") {
//                $file_dir = AlbumFile::FILE_DIR;
//            } else if ($type == "5") {
//                $file_dir = NoticeFile::FILE_DIR;
//            }
            $file_dir = "app/tmp";
            $vimeo = new VimeoController();

            foreach ($upload_files as $file) {
                $file_name = $file->getClientOriginalName();
                $vimeo_id = null;

                if (Str::startsWith($file->getMimeType(), 'video')) {
//                    $vimeo_id = $vimeo->upload_simple($file);
                    $vimeo_id = "video";
                }

                if ($vimeo_id) {
//                    $file_path = AppendFile::getVimeoThumbnailUrl($vimeo_id);
                    $file_path = \App::make('helper')->putVideoS3($file_dir, $file);
                } else {
                    $file = \App::make('helper')->rotateImage($file);
                    $file_path = \App::make('helper')->putResizeS3($file_dir, $file, 1160,180);
                }

                $payload = [
                    'type' => $type,
                    'type_id' => $user_id,
                    'file_name' => $file_name,
                    'file_path' => $file_path,
                    'file_size' => $file->getSize(),
                    'file_mimetype' => $file->getMimeType(),
                    'vimeo_id' => $vimeo_id,
                ];
                $file = new File($payload);
                $file->save();
            }
        }

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'error', '등록되었습니다.');
        return response()->json($result);
    }

    public function destroy(Request $request)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        $type = $request->input('type') ?? "";
        if (!in_array($type, ['3','4','5','all'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '타입은 3,4,5,all만 허용됩니다.');
            return response()->json($result);
        }

        $files = File::where('type_id', '=', $user_id)
            ->when($type, function ($q) use ($type) {
                if ($type == "all") {
                    $q->whereIn('type', ['3','4','5']);
                } else {
                    $q->where('type', $type);
                }
            })
            ->orderByDesc('created_at')
            ->get();

        if ($files) {
            foreach ($files as $file) {
                if ($file->vimeo_id) {
                    $vimeo = new VimeoController();
                    $rs = $vimeo->delete2($file->vimeo_id);
                } else {
                    $rs = \App::make('helper')->deleteImage($file->file_path);
                }
                $file->delete();
            }
        }

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'error', '삭제되었습니다.');
        return response()->json($result);
    }
}

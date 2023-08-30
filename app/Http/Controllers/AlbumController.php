<?php

namespace App\Http\Controllers;

use App\Album;
use App\AlbumFile;
use App\AlbumHistory;
use App\AppendFile;
use App\AlbumComment;
use App\Jobs\BatchPush;
use App\Models\RaonMember;
use App\RequestLog;
use App\UserMemberDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use App\Rules\UploadFile;
use Validator;
use App\File;
use \Illuminate\Http\UploadedFile;

class AlbumController extends Controller
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

        if (!in_array($user->user_type, ['m', 's'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        $now = Carbon::now();
        $year = $request->input('year') ? sprintf('%04d', $request->input('year')) : $now->format('Y');
        $month = $request->input('month') ? sprintf('%02d', $request->input('month')) : $now->format('m');
        $search_text = $request->input('search_text') ?? '';
        $search_text = trim($search_text);

        if ($user->user_type == 'm') {
            $rs = Album::with('files')
                ->where('status', 'Y')
                ->where('midx', $user->id)
                ->where('year', $year)
                ->where('month', $month)
                ->when($search_text != "", function ($q) use ($search_text) {
                    $q->where('title','like','%'.$search_text.'%');
                })
                ->orderByDesc('created_at')
                ->get();
        } else {
            $rs = Album::with('files')
                ->where('status', 'Y')
                ->where('sidx', 'like', "%" . json_encode($user->id) . "%")
                ->where('year', $year)
                ->where('month', $month)
                ->orderByDesc('created_at')
                ->get();
        }

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'count', $rs->count());

        if ($rs) {
            $index = 0;
            foreach ($rs as $row) {
                $result = Arr::add($result, "list.{$index}.id", $row->id);
                $result = Arr::add($result, "list.{$index}.title", $row->title);
                $this_date = Carbon::create($row->year, $row->month, $row->day);
                $result = Arr::add($result, "list.{$index}.date", $this_date->format('Y.m.d')." ".\App::make('helper')->dayOfKo($this_date, 2));
                $result = Arr::add($result, "list.{$index}.reg_date", $row->created_at->format(Album::REG_DATE_FORMAT));

                if ($user->user_type == 'm') {
                    $students = $row->sidx != 'null' && $row->sidx ? RaonMember::whereIn('idx', json_decode($row->sidx))->get() : null;

                    if ($students) {
                        foreach ($students as $student_index => $student) {
                            $userMemberDetail = RaonMember::where('idx', $student->id)->first();
                            $profile_image = $userMemberDetail->user_picture ?? '';

                            $result = Arr::add($result, "list.{$index}.student.{$student_index}.id", $student->id);
                            $result = Arr::add($result, "list.{$index}.student.{$student_index}.name", $student->name);
                            $result = Arr::add($result, "list.{$index}.student.{$student_index}.user_picture", $profile_image ? \App::make('helper')->getImage($profile_image) : null);
                        }
                    }
                }

                if ($row->files->count()) {
                    foreach ($row->files as $file_index => $file) {
                        $result = Arr::add($result, "list.{$index}.file.{$file_index}.file_id", $file->id);
                        $result = Arr::add($result, "list.{$index}.file.{$file_index}.file_name", $file->file_name);
//                        $result = Arr::add($result, "list.{$index}.file.{$file_index}.file_path", $file->vimeo_id ? AppendFile::getVimeoThumbnailUrl($file->vimeo_id) : \App::make('helper')->getImage($file->file_path));
                        $result = Arr::add($result, "list.{$index}.file.{$file_index}.file_path", $file->vimeo_id ? null : \App::make('helper')->getImage($file->file_path));
                        $result = Arr::add($result, "list.{$index}.file.{$file_index}.vimeo_id", $file->vimeo_id ? $file->vimeo_id : null);
                    }
                }

                $index++;
            }
        }

        return response()->json($result);
    }

    public function show(Request $request, $album_id)
    {
        $result = array();
        $modify = $request->input('modify') ?? '';
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        if (!in_array($user->user_type, ['m', 's'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        if ($user->user_type == 's') {
            $children_rs = RaonMember::where('mobilephone', $user->phone)
                ->where('pw', $user->password)
                ->where('mtype', 's')
                ->where('status', 'Y')
                ->get();

            if (sizeof($children_rs) > 1) {
                $check_row = Album::find($album_id);

                if ($check_row) {
                    foreach ($children_rs as $children_row) {
                        if ($check_row->sidx == $children_row->id) {
                            $user = $children_row;
                        }
                    }
                }
            }
        }

        if ($user->user_type == 'm') {
            $row = Album::with('files')
                ->where('status', 'Y')
                ->where('midx', $user->id)
                ->whereId($album_id)
                ->first();
        } else {
            $row = Album::with('files')
                ->where('status', 'Y')
                ->where('sidx', 'like', "%" . json_encode($user->id) . "%")
                ->whereId($album_id)
                ->first();
        }

        if (empty($row)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '잘못된 요청입니다.');
            return response()->json($result);
        }

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, "id", $row->id);
        $result = Arr::add($result, "title", $row->title);
        $this_date = Carbon::create($row->year, $row->month, $row->day);
        $result = Arr::add($result, "date", $this_date->format('Y.m.d')." ".\App::make('helper')->dayOfKo($this_date, 2));
        $result = Arr::add($result, "reg_date", $row->created_at->format(Album::REG_DATE_FORMAT));

        if ($user->user_type == 'm') {
            $students = RaonMember::whereIn('idx', json_decode($row->sidx))->get();
            if ($students) {
                foreach ($students as $student_index => $student) {
                    $userMemberDetail = RaonMember::where('user_id', $student->id)->first();
                    $profile_image = $userMemberDetail->user_picture ?? '';

                    $result = Arr::add($result, "student.{$student_index}.id", $student->id);
                    $result = Arr::add($result, "student.{$student_index}.name", $student->name);
                    $result = Arr::add($result, "student.{$student_index}.user_picture", $profile_image ? \App::make('helper')->getImage($profile_image) : null);

                    $albumHistory = AlbumHistory::where('album_id', $album_id)
                        ->where('hidx', $user->branch_id)
                        ->where('midx', $user->id)
                        ->where('sidx', 'like', '%' . $student->id . '%')
                        ->count();

                    $readed = $albumHistory ? 'Y' : 'N';

                    $result = Arr::add($result, "student.{$student_index}.readed", $readed);
                }
            }
        }

        if ($row->files->count()) {
            foreach ($row->files as $file_index => $file) {
                $result = Arr::add($result, "file.{$file_index}.file_id", $file->id);
                $result = Arr::add($result, "file.{$file_index}.file_name", $file->file_name);
//                $result = Arr::add($result, "file.{$file_index}.file_path", $file->vimeo_id ? AppendFile::getVimeoThumbnailUrl($file->vimeo_id) : \App::make('helper')->getImage($file->file_path));
//                $result = Arr::add($result, "file.{$file_index}.video_path", $file->vimeo_id ? AppendFile::getVimeoUrl($file->vimeo_id) : null);
                $vimeo_file = null;
                if ($modify == "1" && $file->vimeo_id) $vimeo_file = AppendFile::getVimeoThumbnailUrl($file->vimeo_id);
                $result = Arr::add($result, "file.{$file_index}.file_path", $file->vimeo_id ? $vimeo_file : \App::make('helper')->getImage($file->file_path));
                $result = Arr::add($result, "file.{$file_index}.video_id", $file->vimeo_id ? $file->vimeo_id : null);
            }
        }

        if ($user->user_type == 's') {
            if ($row->histories->where('sidx', $user->id)->count() === 0) {
                $row->histories()->create(
                    [
                        'hidx' => $user->branch_id,
                        'midx' => $user->center_id,
                        'sidx' => $user->id
                    ]
                );
            }
        } else {
            if ($user->user_type == 'm') {
                if ($row->histories->where('midx', $user->id)->count() === 0) {
                    $row->histories()->create(
                        [
                            'hidx' => $user->branch_id,
                            'midx' => $user->center_id
                        ]
                    );
                }
            } else {
                if ($user->user_type == 'h') {
                    if ($row->histories->where('hidx', $user->id)->count() === 0) {
                        $row->histories()->create(
                            [
                                'hidx' => $user->branch_id
                            ]
                        );
                    }
                }
            }
        }

        return response()->json($result);
    }

    public function store(Request $request)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        $validator = Validator::make($request->all(), [
            'upload_files' => [new UploadFile],
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => 'fail',
                'error' => "업로드 하려는 파일은 동영상, 이미지만 가능하고 이미지는 10Mb이하, 동영상은 500Mb 이하로만 가능합니다."
            ]);
        }

        $arr_request_file = array();
        if ($request->allFiles()) {
            $file_index = 0;
            foreach ($request->allFiles() as $files) {
                foreach ($files as $file) {
                    $arr_request_file = Arr::add($arr_request_file, "upload.{$file_index}.name", $file->getClientOriginalName());
                    $arr_request_file = Arr::add($arr_request_file, "upload.{$file_index}.size", $file->getSize());
                    $arr_request_file = Arr::add($arr_request_file, "upload.{$file_index}.mime", $file->getMimeType());
                }
            }
        }

        RequestLog::create(
            [
                'user' => $user_id,
                'request_url' => URL::current(),
                'request_data' => json_encode($request->all()),
                'request_file' => json_encode($arr_request_file)
            ]
        );

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        if (!in_array($user->user_type, ['m'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        $title = $request->input('title');
        $student = $request->input('student', null);

        if ($student) {
            if (!is_array($student)) {
                $student = array($student);
            }

            $student = json_encode($student);
        }

        $now = Carbon::now();
        $year = $request->input('year') ? sprintf('%04d', $request->input('year')) : $now->format('Y');
        $month = $request->input('month') ? sprintf('%02d', $request->input('month')) : $now->format('m');
        $day = $request->input('day') ? sprintf('%02d', $request->input('day')) : $now->format('d');

        $payload = [
            'hidx' => $user->branch_id,
            'midx' => $user->id,
            'sidx' => $student,
            'title' => $title,
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'status' => 'Y'
        ];
        $album = new Album($payload);
        $album->save();

        $tmp_upload = $request->input('upload_files');
        $upload_files = $request->file('upload_files');
        if ($tmp_upload) {
            if ($upload_files && is_array($upload_files)) {
                $upload_files = array_merge($tmp_upload, $upload_files);
            } else {
                $upload_files = $tmp_upload;
            }
        }

        if ($upload_files) {
            $vimeo = new VimeoController();
            foreach ($upload_files as $file) {
                $file_name = $file->getClientOriginalName();
                $vimeo_id = null;

                if (Str::startsWith($file->getMimeType(), 'video')) {
                    $vimeo_id = $vimeo->upload_simple($file);
                }

                if ($vimeo_id) {
                    $file_path = AppendFile::getVimeoThumbnailUrl($vimeo_id);
                } else {
                    $file_path = \App::make('helper')->putResizeS3(AlbumFile::FILE_DIR, $file);
                }

                $album->files()->create(
                    [
                        'file_name' => $file_name,
                        'file_path' => $file_path,
                        'file_size' => $file->getSize(),
                        'file_mimetype' => $file->getMimeType(),
                        'vimeo_id' => $vimeo_id
                    ]
                );
            }
        }
        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'error', '등록 되었습니다.');
        $result = Arr::add($result, 'id', $album->id);

//        $push = new PushMessageController('album', $album->id);
//        $push->push();

        BatchPush::dispatch(['type' => 'album', 'type_id' => $album->id, 'param' => []]);

        return response()->json($result);
    }

    public function update(Request $request, $album_id)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        $validator = Validator::make($request->all(), [
            'upload_files' => [new UploadFile],
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => 'fail',
                'error' => "업로드 하려는 파일은 동영상, 이미지만 가능하고 이미지는 10Mb이하, 동영상은 500Mb 이하로만 가능합니다."
            ]);
        }

        $arr_request_file = array();
        if ($request->allFiles()) {
            $file_index = 0;
            foreach ($request->allFiles() as $files) {
                foreach ($files as $file) {
                    $arr_request_file = Arr::add($arr_request_file, "upload.{$file_index}.name", $file->getClientOriginalName());
                    $arr_request_file = Arr::add($arr_request_file, "upload.{$file_index}.size", $file->getSize());
                    $arr_request_file = Arr::add($arr_request_file, "upload.{$file_index}.mime", $file->getMimeType());
                }
            }
        }

        RequestLog::create(
            [
                'user' => $user_id,
                'request_url' => URL::current(),
                'request_data' => json_encode($request->all()),
                'request_file' => json_encode($arr_request_file)
            ]
        );

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        if (!in_array($user->user_type, ['m'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        $title = $request->input('title');
        $student = $request->input('student', null);

        if ($student) {
            if (!is_array($student)) {
                $student = array($student);
            }

            $student = json_encode($student);
        }

        $album = Album::whereId($album_id)->where('midx', $user->id)->first();
        if (empty($album)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '잘못된 요청입니다.');
            return response()->json($result);
        }

        $payload = [
            'title' => $title,
            'sidx' => $student
        ];

        $album->fill($payload);
        $album->save();

        $upload_files = $request->file('upload_files');

        if ($upload_files) {
            $vimeo = new VimeoController();
            foreach ($upload_files as $file) {
                $file_name = $file->getClientOriginalName();
                $vimeo_id = null;

                if (Str::startsWith($file->getMimeType(), 'video')) {
                    $vimeo_id = $vimeo->upload_simple($file);
                }

                if ($vimeo_id) {
                    $file_path = AppendFile::getVimeoThumbnailUrl($vimeo_id);
                } else {
                    $file_path = \App::make('helper')->putResizeS3(AlbumFile::FILE_DIR, $file);
                }

                $album->files()->create(
                    [
                        'file_name' => $file_name,
                        'file_path' => $file_path,
                        'file_size' => $file->getSize(),
                        'file_mimetype' => $file->getMimeType(),
                        'vimeo_id' => $vimeo_id
                    ]
                );
            }
        }
        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'error', '수정 되었습니다.');

        return response()->json($result);
    }

    public function destroy($album_id, Request $request)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        RequestLog::create(
            [
                'user' => $user_id,
                'request_url' => URL::current(),
                'request_data' => json_encode($request->all()),
                'request_file' => json_encode([])
            ]
        );

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        if (!in_array($user->user_type, ['a','m'])) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        if ($user->user_type === 'a') {
            $album = Album::whereId($album_id)->first();
        } else {
            $album = Album::whereId($album_id)->where('midx', $user->id)->first();
        }

        if (empty($album)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '잘못된 요청입니다.');
            return response()->json($result);
        }

        //파일삭제
        if ($album->files->count()) {
            $vimeo = new VimeoController();
            foreach ($album->files as $file_index => $file) {
                if ($file->vimeo_id) {
                    $rs = $vimeo->delete2($file->vimeo_id);
                } else {
                    $rs = \App::make('helper')->deleteImage($file->file_path);
                }
                $file->forceDelete();
            }
        }

        $albumComments = AlbumComment::where('album_id','=',$album_id)->get();
        if ($albumComments->count() > 0) {
            foreach ($albumComments as $albumComment) {
                $albumComment->forceDelete();
            }
        }

        $albumHistories = AlbumHistory::where('album_id','=',$album_id)->get();
        if ($albumHistories->count() > 0) {
            foreach ($albumHistories as $albumHistory) {
                $albumHistory->forceDelete();
            }
        }

        $album->forceDelete();

        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'error', '삭제 되었습니다.');

        return response()->json($result);
    }

    public function fileDelete(Request $request, $file_id)
    {
        $result = array();
        $user_id = $request->input('user');
        $user = RaonMember::whereIdx($user_id)->first();

        if (empty($user)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '사용자 정보가 없습니다.');
            return response()->json($result);
        }

        $file = AlbumFile::find($file_id);
        if (empty($file)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '조회된 파일이 없습니다.');
            return response()->json($result);
        }

        $album = Album::whereMidx($user->id)->whereId($file->album_id)->first();
        if (empty($album)) {
            $result = Arr::add($result, 'result', 'fail');
            $result = Arr::add($result, 'error', '권한이 없습니다.');
            return response()->json($result);
        }

        if ($file->vimeo_id) {
            $vimeo = new VimeoController();
            $rs = $vimeo->delete2($file->vimeo_id);
        } else {
            $rs = \App::make('helper')->deleteImage($file->file_path);
        }
        $file->delete();
        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'error', '삭제 되었습니다.');

        return response()->json($result);
    }

    public function album(Request $request)
    {
        $ym = $request->input('ym') ?? date('Y-m');
        $search_text = $request->input('search_text') ?? '';
        $year = $month = "";
        if ($ym != '') {
            $ymArr = explode('-', $ym);
            $year = $ymArr[0] ?? '';
            $month = $ymArr[1] ?? '';
        }

        $user = \App::make('helper')->getUsertId();
        $userType = \App::make('helper')->getUsertType();
        if (in_array($userType, ['a','h'])) {
            $user = session()->get('center');
        }

        $req = Request::create('/api/album/list', 'GET', [
            'user' => $user,
            'year' => $year,
            'month' => $month,
            'search_text' => $search_text,
        ]);

        $res = $this->index($req);
        $list = $res->original['list'] ?? [];
        // \App::make('helper')->vardump($list);

        return view('album/list', [
            'list' => $list,
            'ym' => $ym,
            'search_text' => $search_text,
        ]);
    }

    public function albumView($id)
    {
        $uesrId = \App::make('helper')->getUsertId();
        $userType = \App::make('helper')->getUsertType();
        if (in_array($userType, ['a','h'])) {
            $uesrId = session()->get('center');
        }
        $albumReq = Request::create('/api/album/view/'.$id, 'GET', [
            'user' => $uesrId
        ]);
        $res = $this->show($albumReq, $id);
        $student = $res->original['student'] ?? [];
        $studentReadY = $studentReadN = [];
        foreach ($student as $stu) {
            if($stu['readed'] == "N") {
                array_push($studentReadN, $stu);
            } else {
                array_push($studentReadY, $stu);
            }
        }

        if ($res->original['result'] != 'success') {
            $error = \App::make('helper')->getErrorMsg($res->original['error']);
            \App::make('helper')->alert($error);
        }

        return view('album/view',[
            'row' => $res->original ?? [],
            'studentReadN' => $studentReadN ?? [],
            'studentReadY' => $studentReadY ?? [],
            'id' => $id,
        ]);
    }

    public function albumWrite(Request $request, $id="")
    {
        $ymd = date('Y-m-d');
        $mode = "w";

        $ym = $request->input('ym') ?? '';

        if ($ym != "" && $ym != date('Y-m')) {
            $ymd = $ym."-01";
        }

        $user = \App::make('helper')->getUsertId();
        $userType = \App::make('helper')->getUsertType();
        if (in_array($userType, ['a','h'])) {
            $user = session()->get('center');
        }

        $row = [];
//        \App::make('helper')->vardump($id);
//        exit;
        if ($id != "") {
            $mode = "u";

            $req = Request::create('/api/album/view/'.$id, 'GET', [
                'user' => $user,
                'modify' => 1,
            ]);
            $res = $this->show($req, $id);

            if ($res->original['result'] != 'success') {
                $error = \App::make('helper')->getErrorMsg($res->original['error']);
                \App::make('helper')->alert($error);
            }

            $row = $res->original ?? [];

            if (isset($row['date']) && $row['date'] != "") {
                $date = explode(' ',$row['date']);
                $date = str_replace('.','-',$date[0]);
                $ymd = $date;
            }
        }

        $req = Request::create('/api/children', 'GET', [
            'user' => $user,
        ]);
        $userController = new UserController();
        $res = $userController->children($req);
        $student = $res->original['list'] ?? [];


        return view('album/write',[
            'ymd' => $ymd,
            'student' => $student ?? "",
            'mode' => $mode,
            'id' => $id,
            'row' => $row,
        ]);
    }

    public function writeAction(Request $request)
    {
        $mode = $request->input('mode') ?? '';
        $id = $request->input('id') ?? '';
        $type = $request->input('type') ?? '';
        $ymd = $request->input('ymd') ?? '';
        $title = $request->input('title') ?? '';
        $student = $request->input('student') ?? '';
        $upload_files = $request->file('upload_files');

//        \App::make('helper')->vardump($upload_files);
//        exit;

        if ($ymd == "") \App::make('helper')->alert('작성일자를 입력해주세요.');
        $ymdArr = explode('-', $ymd);
        $year = $ymdArr[0]??-1;
        $month = $ymdArr[1]??-1;
        $day = $ymdArr[2]??-1;
        if (! checkdate((int)$month,(int)$day,(int)$year)) \App::make('helper')->alert('올바른 작성일자가 아닙니다.');
        if ($title == "") \App::make('helper')->alert('제목을 입력해주세요.');
//        if (!$upload_files) \App::make('helper')->alert('사진·동영상을 등록해주세요.');
        if ($student == "") \App::make('helper')->alert('학생을 선택해 주세요.');

        $user = \App::make('helper')->getUsertId();
        $userType = \App::make('helper')->getUsertType();
        if (in_array($userType, ['a','h'])) {
            $user = session()->get('center');
        }

        if ($mode == 'u') {
            //파일 삭제
            $delete_ids = $request->input('delete_ids') ?? '';
            if ($delete_ids != "") {
                $deleteIdsArr = explode(',', $delete_ids);
                if (is_array($deleteIdsArr) && count($deleteIdsArr) > 0) {
                    $req = Request::create('/api/album/fileDelete/'.$id, 'GET', [
                        'user' => $user,
                    ]);
                    foreach ($deleteIdsArr as $l) {
                        $res = $this->fileDelete($req, $l);
                    }
                }
            }

            $request->merge([
                'user' => $user,
                'student' => $student,
                'type' => $type,
            ]);
            $res = $this->update($request, $id);
        } else {
            $requestMergeData = [
                'user' => $user,
                'year' => $year,
                'month' => $month,
                'day' => $day,
                'type' => $type,
            ];

            $tmpFileIds = $request->input('tmp_file_ids');
            // 임시저장 폴더 request당 폴더를 만들고 api 리퀘스트가 끝나면 폴더를 삭제하여 임시파일을 삭제한다.
            $tmpSaveFilePath = 'tmp/'.Str::uuid()."/";

            // 임시파일 저장이라면 s3에서 데이터를 꺼내와 uploaded 파일 객체로 만들어 준 후
            // request에 업로드 파일을 merge하도록 한다.
            if ($tmpFileIds != "") {
                $tmpFileIdArr = explode(",",$tmpFileIds);
                $fileDatas = File::whereIn('id',$tmpFileIdArr)->get();
                if ($fileDatas) {
                    foreach ($fileDatas as $fileData) {
                        $content = \App::make('helper')->getDownloadImage($fileData->file_path);
                        $tmpPath = $tmpSaveFilePath . $fileData->file_name;
                        Storage::disk('local')->put($tmpPath, $content);
                        $storagePath  = Storage::disk('local')->path($tmpPath);
                        $upFile = new UploadedFile($storagePath, $fileData->file_name);
                        // $request->files->set('file', $upFile);
                        $requestMergeData['upload_files'][] = $upFile;
                    }
                }
            }

            $request->merge($requestMergeData);
            $res = $this->store($request);

            //임시파일 삭제
            $storagePath  = Storage::disk('local')->path($tmpSaveFilePath);
            @array_map('unlink', glob("$storagePath/*.*"));
            @rmdir($storagePath);
        }

//        \App::make('helper')->vardump($request->all());
//        \App::make('helper')->vardump($res->original);

        if ($res->original['result'] != 'success') {
            $error = \App::make('helper')->getErrorMsg($res->original['error']);
            \App::make('helper')->alert($error);
        }

        $link = "/album?ym=".$year.'-'.$month;
        if ($mode == 'u') $link = "/album/view/".$id;
        \App::make('helper')->alert( (($mode == 'u')?"수정":"등록")."되었습니다.", $link);
    }

    public function albumDelete($id)
    {
        $user = \App::make('helper')->getUsertId();
        $req = Request::create('/album/delete/'.$id, 'POST', [
            'user' => $user,
        ]);
        $res = $this->destroy($id, $req);

        if ($res->original['result'] != 'success') {
            $error = \App::make('helper')->getErrorMsg($res->original['error']);
            \App::make('helper')->alert($error);
        }

        \App::make('helper')->alert("삭제되었습니다.", "/album");
    }

    public function downloadFile(Request $request, $id)
    {
        $file = AlbumFile::whereId($id)->first();
        if (empty($file)) {
            echo "잘못된 접근입니다.";
            exit;
        }

        if ($file->vimeo_id) {
            echo "잘못된 접근입니다.";
            exit;
        } else {
            $file_name = $file->file_name;
            $headers = [
                'Content-Type'        => 'application/png',
                'Content-Disposition' => 'attachment; filename="'. $file_name .'"',
            ];

//            \App::make('helper')->vardump($file->file_path);
//            exit;
            return \Response::make(\App::make('helper')->getDownloadImage($file->file_path), 200, $headers);
        }
    }

}

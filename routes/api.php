<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserAppInfoController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppMainController;
use App\Http\Controllers\AppNoticeController;
use App\Http\Controllers\AdviceNoteController;
use App\Http\Controllers\VimeoController;
use App\Http\Controllers\AdviceCommentController;
use App\Http\Controllers\AdviceNoteAdminController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AlbumCommentController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CounselingController;
use App\Http\Controllers\VersionController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\EducatonInfoController;
use App\Http\Controllers\EditorFileController;
use App\Http\Controllers\CommonCommentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TmpFileController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::resource('test', TestController::class);
//Route::resource('test', TestController::class)->except([
//    'create', 'store', 'update', 'destroy'
//]);
Route::get('/test/testUpload', [TestController::class, 'testUpload']);
Route::get('/test/getS3file', [TestController::class, 'getS3file']);
Route::get('/test/getS3', [TestController::class, 'getS3']);
Route::post('/test/putS3', [TestController::class, 'putS3']);
Route::post('/test/putResizeS3', [TestController::class, 'putResizeS3']);
Route::get('/test/deleteS3', [TestController::class, 'deleteS3']);
Route::resource('test', TestController::class)->only([
    'index', 'show'
]);

Route::get('/login', [UserAppInfoController::class, 'login']);
Route::get('/logout', [UserAppInfoController::class, 'logout']);
Route::post('/tokenUpdate', [UserAppInfoController::class, 'tokenUpdate']);

Route::get('/faq', [BoardController::class, 'faq']);

Route::get('/centerAll', [UserController::class, 'centerAll']);
Route::get('/center', [UserController::class, 'center']);
Route::get('/branch', [UserController::class, 'branch']);
Route::get('/student', [UserController::class, 'student']);
Route::get('/children', [UserController::class, 'children']);
Route::get('/selectChild', [UserController::class, 'selectChild']);
Route::get('/myInfo', [UserController::class, 'myInfo']);
Route::get('/alramInfo', [UserController::class, 'alramInfo']);

Route::post('/userAdd', [UserController::class, 'userAdd']);

Route::get('/terms', [AppMainController::class, 'terms']);
Route::get('/privacy', [AppMainController::class, 'privacy']);

// 메인
Route::get('/main', [AppMainController::class, 'index']);

// 문자 발송(비밀번호 초기화)
Route::post('/resetPassword', [UserAppInfoController::class, 'resetPassword']);

// 아소비 공지사항
Route::get('/appNotice/list', [AppNoticeController::class, 'index']);
Route::get('/appNotice/view/{id}', [AppNoticeController::class, 'show']);
Route::post('/appNotice/write', [AppNoticeController::class, 'store']);
Route::post('/appNotice/write/{id}', [AppNoticeController::class, 'update']);
Route::post('/appNotice/delete/{id}', [AppNoticeController::class, 'destroy']);

// 알림장 / 가정통신문
Route::get('/adviceNote/student/list', [AdviceNoteController::class, 'student']);
Route::get('/adviceNote/list', [AdviceNoteController::class, 'index']);
Route::get('/adviceNote/view/{id}', [AdviceNoteController::class, 'show']);
Route::get('/adviceNote/write', [AdviceNoteController::class, 'create']);
Route::get('/adviceNote/checkLetter', [AdviceNoteController::class, 'checkLetter']);
Route::post('/adviceNote/write', [AdviceNoteController::class, 'store']);
Route::post('/adviceNote/write/{id}', [AdviceNoteController::class, 'update']);
Route::post('/adviceNote/writeAll', [AdviceNoteController::class, 'storeAll']);
Route::post('/adviceNote/writeAllCheck', [AdviceNoteController::class, 'storeAllCheck']);
Route::post('/adviceNote/delete/{id}', [AdviceNoteController::class, 'destroy']);
Route::post('/adviceNote/fileDelete/{file_id}', [AdviceNoteController::class, 'fileDelete']);
Route::get('/adviceNote/comment/list', [AdviceCommentController::class, 'index']);
Route::post('/adviceNote/comment/write', [AdviceCommentController::class, 'store']);
Route::post('/adviceNote/comment/write/{id}', [AdviceCommentController::class, 'update']);
Route::post('/adviceNote/comment/delete/{id}', [AdviceCommentController::class, 'destroy']);

// 테스트 가정통신문 연월에 해당하는 내용 전체 삭제
Route::post('/adviceNote/testLetterDeleteAll', [AdviceNoteController::class, 'testLetterDeleteAll']);

// 가정통신문
Route::get('/adviceNoteAdmin/write', [AdviceNoteAdminController::class, 'show']);
Route::post('/adviceNoteAdmin/write', [AdviceNoteAdminController::class, 'store']);

// 사용자 알림 설정
Route::post('/user/update/{type}/{kind?}', [UserAppInfoController::class, 'update']);

// 앨범
Route::get('/album/list', [AlbumController::class, 'index']);
Route::get('/album/view/{id}', [AlbumController::class, 'show']);
Route::post('/album/write', [AlbumController::class, 'store']);
Route::post('/album/write/{id}', [AlbumController::class, 'update']);
Route::post('/album/delete/{id}', [AlbumController::class, 'destroy']);
Route::post('/album/fileDelete/{file_id}', [AlbumController::class, 'fileDelete']);
Route::get('/album/comment/list', [AlbumCommentController::class, 'index']);
Route::post('/album/comment/write', [AlbumCommentController::class, 'store']);
Route::post('/album/comment/write/{id}', [AlbumCommentController::class, 'update']);
Route::post('/album/comment/delete/{id}', [AlbumCommentController::class, 'destroy']);

// 공지사항
Route::get('/notice/list', [NoticeController::class, 'index']);
Route::get('/notice/view/{id}', [NoticeController::class, 'show']);
Route::post('/notice/write', [NoticeController::class, 'store']);
Route::post('/notice/write/{id}', [NoticeController::class, 'update']);
Route::post('/notice/delete/{id}', [NoticeController::class, 'destroy']);
Route::post('/notice/fileDelete/{id}', [NoticeController::class, 'fileDelete']);

// 학사 일정
Route::get('/calendar', [AppMainController::class, 'calendar']);
Route::get('/isSchedule', [AppMainController::class, 'isSchedule']);

// 출석부
Route::get('/attendance/student/list', [AttendanceController::class, 'student']);
Route::get('/attendance/list', [AttendanceController::class, 'index']);
Route::post('/attendance/write', [AttendanceController::class, 'store']);
//Route::post('/attendance/delete', [AttendanceController::class, 'destroyMany']);
//Route::post('/attendance/delete/{id}', [AttendanceController::class, 'destroy']);

// 상담일지
Route::get('/counseling/student/list', [CounselingController::class, 'student']);
Route::get('/counseling/list', [CounselingController::class, 'index']);
Route::get('/counseling/view/{id}', [CounselingController::class, 'show']);
Route::post('/counseling/write', [CounselingController::class, 'store']);
Route::post('/counseling/delete/{id}', [CounselingController::class, 'destroy']);
Route::post('/counseling/write/{id}', [CounselingController::class, 'update']);

// 교육정보
Route::get('/educatonInfo/list', [EducatonInfoController::class, 'index']);
Route::post('/educatonInfo/write', [EducatonInfoController::class, 'store']);
Route::post('/educatonInfo/write/{id}', [EducatonInfoController::class, 'update']);
Route::post('/educatonInfo/delete/{id}', [EducatonInfoController::class, 'destroy']);
Route::get('/educatonInfo/view/{id}', [EducatonInfoController::class, 'show']);

// 에디터 파일등록
Route::post('/editor/fileWrite', [EditorFileController::class, 'store']);

// 교육정보, 이벤트, 공지사항 통합 댓글
Route::get('/commonComment/list', [CommonCommentController::class, 'index']);
Route::post('/commonComment/write', [CommonCommentController::class, 'store']);
Route::post('/commonComment/write/{id}', [CommonCommentController::class, 'update']);
Route::post('/commonComment/delete/{id}', [CommonCommentController::class, 'destroy']);

// 이벤트
Route::get('/event/mainBanner', [EventController::class, 'mainBanner']);
Route::get('/event/list', [EventController::class, 'index']);
Route::post('/event/write', [EventController::class, 'store']);
Route::post('/event/write/{id}', [EventController::class, 'update']);
Route::post('/event/delete/{id}', [EventController::class, 'destroy']);
Route::get('/event/view/{id}', [EventController::class, 'show']);

// *** get video info
Route::get('videos', [VimeoController::class, 'videos']);
Route::get('videos/{video}', [VimeoController::class, 'show']);
Route::get('videos/thumbnail/{video}', [VimeoController::class, 'thumbnail']);

// *** update video info
Route::post('videos', [VimeoController::class, 'upload2']);
Route::put('videos/{video}', [VimeoController::class, 'update']);
Route::delete('videos/{video}', [VimeoController::class, 'delete']);

Route::get('/version/ios', [VersionController::class, 'ios']);
Route::get('/version/android', [VersionController::class, 'android']);


Route::get('/share', [ShareController::class, 'webDeepLink']);

//임시파일
Route::get('/tmpFiles', [TmpFileController::class, 'index']);
Route::get('/tmpFileSize', [TmpFileController::class, 'fileSize']);
Route::post('/tmpFileSave', [TmpFileController::class, 'store']);
Route::post('/tmpFileDelete', [TmpFileController::class, 'destroy']);


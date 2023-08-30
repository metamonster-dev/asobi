<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\UserAppInfoController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AppManageController;
use App\Http\Controllers\AdviceNoteController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CounselingController;
use App\Http\Controllers\EducatonInfoController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AppNoticeController;
use App\Http\Controllers\EditorFileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/fcm', function () {
//    return view('fcm');
//});
//Route::get('/testSession', [MainController::class, 'testSession'])->middleware('checkLogin');
//Route::get('/share/{type}/{id}', [ShareController::class, 'webDeepLink']);

Route::get('/', [MainController::class, 'main'])->middleware('checkLogin');
Route::post('/main/selectAction', [MainController::class, 'selectAction'])->middleware('checkLogin')->middleware('enterUserType:a|h');

// 로그인등
Route::group(['prefix' => 'auth'], function () {
    Route::get('login', [AuthController::class, 'login'])->middleware('checkNotLogin');
    Route::post('loginAction', [UserAppInfoController::class, 'loginAction'])->middleware('checkNotLogin');
    Route::get('logout', [UserAppInfoController::class, 'logoutAction'])->middleware('checkLogin');
    Route::get('join', [AuthController::class, 'join']);
    Route::post('joinAction', [AuthController::class, 'joinAction']);
    Route::get('findId', [AuthController::class, 'findId'])->middleware('checkNotLogin');
    Route::get('findPw', [AuthController::class, 'findPw'])->middleware('checkNotLogin');
    Route::post('findPwAction', [AuthController::class, 'findPwAction'])->middleware('checkNotLogin');
});

// 내정보
Route::group(['prefix' => 'mypage', 'middleware' => 'checkLogin'], function () {
    Route::get('/', [AuthController::class, 'mypage']);
    Route::get('resetPw', [AuthController::class, 'resetPw']);
    Route::post('resetPwAction', [AuthController::class, 'resetPwAction']);
    Route::post('profileAction', [AuthController::class, 'profileAction']);
    Route::get('editInfo', [AuthController::class, 'editInfo'])->middleware('enterUserType:s');
    Route::post('editInfoAction', [AuthController::class, 'editInfoAction']);
});

// 회원목록, FAQ
Route::group(['prefix' => 'student', 'middleware' => 'checkLogin'], function () {
    Route::get('/', [StudentController::class, 'student'])->middleware('checkCenter');
    Route::post('/changeAction', [StudentController::class, 'changeAction'])->middleware('enterUserType:s');
});
Route::get('/faq', [FaqController::class, 'faq'])->middleware('checkLogin');

// 앱관리
Route::group(['prefix' => 'app', 'middleware' => 'checkLogin'], function () {
    Route::get('/', [AppManageController::class, 'appMng']);
    Route::get('alarm', [AppManageController::class, 'appAlarm']);
    Route::get('version', [AppManageController::class, 'appVersion']);
    Route::get('storage', [AppManageController::class, 'appStorage']);
    Route::get('photo', [AppManageController::class, 'appPhoto']);
    Route::post('wifiUpdateAction', [AppManageController::class, 'wifiUpdateAction']);
});

// 알림장
Route::group(['prefix' => 'advice', 'middleware' => 'checkLogin'], function () {
    Route::get('/', [AdviceNoteController::class, 'advice'])->middleware('enterUserType:a|h|m')->middleware('checkCenter'); //알림장 관리
    Route::get('list', [AdviceNoteController::class, 'adviceList'])->middleware('enterUserType:s')->middleware('checkCenter');
    Route::get('{user_id}/note/view/{id}', [AdviceNoteController::class, 'noteView']);
    Route::get('note/write', [AdviceNoteController::class, 'noteWrite'])->middleware('enterUserType:m')->middleware('checkCenter');
    Route::get('note/write/{id}', [AdviceNoteController::class, 'noteWrite'])->middleware('enterUserType:a|m')->middleware('checkCenter');
    Route::get('{user_id}/letter/view/{id}', [AdviceNoteController::class, 'letterView']);
    Route::get('letter/write', [AdviceNoteController::class, 'letterWrite'])->middleware('enterUserType:a|m')->middleware('checkCenter');
    Route::get('letter/write/{id}', [AdviceNoteController::class, 'letterWrite'])->middleware('enterUserType:a|m')->middleware('checkCenter');
    Route::post('writeAction', [AdviceNoteController::class, 'writeAction'])->middleware('enterUserType:a|m')->middleware('checkCenter');
    Route::get('delete/{id}', [AdviceNoteController::class, 'adviceDelete'])->middleware('enterUserType:a|m')->middleware('checkCenter');
    Route::get('downloadFile/{id}', [AdviceNoteController::class, 'downloadFile']);
});

// 앨범
Route::group(['prefix' => 'album', 'middleware' => ['checkLogin','checkCenter']], function () {
    Route::get('/', [AlbumController::class, 'album']);
    Route::get('view/{id}', [AlbumController::class, 'albumView']);
    Route::get('write', [AlbumController::class, 'albumWrite']);
    Route::get('write/{id}', [AlbumController::class, 'albumWrite']);
    Route::post('writeAction', [AlbumController::class, 'writeAction']);
    Route::get('delete/{id}', [AlbumController::class, 'albumDelete']);
    Route::get('downloadFile/{id}', [AlbumController::class, 'downloadFile']);

});

// 공지사항 (학부모)
Route::group(['prefix' => 'notice', 'middleware' => ['checkLogin','checkCenter']], function () {
    Route::get('/', [NoticeController::class, 'notice']);
    Route::get('view/{id}', [NoticeController::class, 'noticeView']);
    Route::get('write', [NoticeController::class, 'noticeWrite']);
    Route::get('write/{id}', [NoticeController::class, 'noticeWrite']);
    Route::post('writeAction', [NoticeController::class, 'writeAction']);
    Route::get('delete/{id}', [NoticeController::class, 'noticeDelete']);
    Route::get('downloadFile/{id}', [NoticeController::class, 'downloadFile']);
});

// 공지사항 (아소비)
Route::group(['prefix' => 'asobiNotice', 'middleware' => 'checkLogin'], function () {
    Route::get('/', [AppNoticeController::class, 'notice'])->middleware('enterUserType:a|h|m');
    Route::get('view/{id}', [AppNoticeController::class, 'noticeView'])->middleware('enterUserType:a|h|m');
    Route::get('write', [AppNoticeController::class, 'noticeWrite'])->middleware('enterUserType:a|h');
    Route::get('write/{id}', [AppNoticeController::class, 'noticeWrite'])->middleware('enterUserType:a|h');
    Route::post('writeAction', [AppNoticeController::class, 'writeAction'])->middleware('enterUserType:a|h');
    Route::get('delete/{id}', [AppNoticeController::class, 'noticeDelete'])->middleware('enterUserType:a|h');
});

// 출석부
Route::group(['prefix' => 'attend', 'middleware' => ['checkLogin','checkCenter']], function () {
    Route::get('/', [AttendanceController::class, 'attend'])->middleware('enterUserType:a|h|m');
    Route::get('view/{id}', [AttendanceController::class, 'attendView']);
    Route::post('view/calendar', [AttendanceController::class, 'attendCalendar']);
    Route::post('attendAction', [AttendanceController::class, 'attendAction'])->middleware('enterUserType:m');
});

// 상담일지
Route::group(['prefix' => 'counsel', 'middleware' => ['checkLogin','checkCenter']], function () {
    Route::get('/', [CounselingController::class, 'counsel'])->middleware('enterUserType:a|h|m');
    Route::get('write', [CounselingController::class, 'counselWrite'])->middleware('enterUserType:m');
    Route::get('write/{id}', [CounselingController::class, 'counselWrite'])->middleware('enterUserType:m');
    Route::post('writeAction', [CounselingController::class, 'counselWriteAction'])->middleware('enterUserType:m');
    Route::get('delete/{id}', [CounselingController::class, 'counselDelete'])->middleware('enterUserType:m');
});

// 교육정보
Route::group(['prefix' => 'education', 'middleware' => 'checkLogin'], function () {
    Route::get('/', [EducatonInfoController::class, 'education']);
    Route::get('view/{id}', [EducatonInfoController::class, 'educationView']);
    Route::get('write', [EducatonInfoController::class, 'educationWrite'])->middleware('enterUserType:a');
    Route::get('write/{id}', [EducatonInfoController::class, 'educationWrite'])->middleware('enterUserType:a');
    Route::post('writeAction', [EducatonInfoController::class, 'educationWriteAction'])->middleware('enterUserType:a');
    Route::get('delete/{id}', [EducatonInfoController::class, 'educationDelete'])->middleware('enterUserType:a');
});

// 이벤트
Route::group(['prefix' => 'event', 'middleware' => 'checkLogin'], function () {
    Route::get('/', [EventController::class, 'event']);
    Route::get('view/{id}', [EventController::class, 'eventView']);
    Route::get('write', [EventController::class, 'eventWrite'])->middleware('enterUserType:a');
    Route::get('write/{id}', [EventController::class, 'eventWrite'])->middleware('enterUserType:a');
    Route::post('writeAction', [EventController::class, 'eventWriteAction'])->middleware('enterUserType:a');
    Route::get('delete/{id}', [EventController::class, 'eventDelete'])->middleware('enterUserType:a');
});


//Route::get('/phpinfo', function () {
//    phpinfo();
//});

// 라우터 정의되지 않으면 404 페이지
// resources/views/errors/404.blade.php
Route::fallback(function () {
    abort(404);
});

<?php

namespace App\Http\Controllers;

use App\AdviceComment;
use App\AdviceNote;
use App\Album;
use App\AlbumComment;
use App\CommonComment;
use App\AppNotice;
use App\Attendance;
use App\Event;
use App\Notice;
use App\PushLog;
use App\Models\RaonMember;
use App\Services\FcmHandler;
use App\UserAppInfo;
use App\EducatonInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class PushMessageController extends Controller
{
    private $type;
    private $type_id;
    private $param;

    public function __construct($type, $type_id, $param=[])
    {
        $this->type = $type;
        $this->type_id = $type_id;
        $this->param = $param;
    }

    public function push()
    {
        $title = "아소비";
        $body = "알림";
        $arr_push = array();

        // @2022-01-26 2022-01-28일 까지만 적용
        $nowTime = time();
        $diffTime = strtotime('2022-01-28 23:59:59');

        if ($this->type == AdviceNote::ADVICE_TYPE || $this->type == AdviceNote::LETTER_TYPE)
        {
            $row = AdviceNote::find($this->type_id);

            if ($row) {
                $student = RaonMember::where('idx', $row->sidx)->first();

                if ($student) {
                    $arr_push = UserAppInfo::where('user_id', $student->idx)
                        ->where('advice_alarm', 'Y')
                        ->where('updated_at', '>=', now()->subMonths(6))
                        ->whereNotNull('push_key')
                        ->orderByDesc('updated_at')
                        ->distinct('push_key')
                        ->pluck('push_key')
                        ->toArray();

                    if ($row->type == AdviceNote::ADVICE_TYPE) {
                        $body = "{$student->name}의 알림장이 작성되었습니다.";
                    } else if ($row->type == AdviceNote::LETTER_TYPE) {
                        $body = "{$student->name}의 {$row->month}월 가정통신문이 작성되었습니다.";
                    }

                    if ($arr_push) {
                        $arr_push = array_unique($arr_push);
                        $arr_push = array_values($arr_push);

                        $pushLog = new PushLog([
                            'type' => $this->type,
                            'type_id' => $this->type_id,
                            'receivers' => json_encode($arr_push)
                        ]);

                        $pushLog->save();

                        // 앱코드 깃허브 주소 받기
                        //
                        if (env('APP_ENV') != 'dev') {
                            $handler = App::make(FcmHandler::class);
                            $handler->setReceivers($arr_push);
                            $handler->setMessage(['title' => $title, 'body' => $body, 'type'=>$this->type, 'id'=>$row->id, 'userId'=>$row->sidx]);
                            $handler->setMessageData(['title' => $title, 'message' => $body, 'type'=>$this->type, 'id'=>$row->id,'userId'=>$row->sidx]);
                            $handler->sendMessage();
                        }
                    }
                }
            }
        }
        else if ($this->type == "adviceComment")
        {
            $row = AdviceComment::find($this->type_id);

            if ($row) {
                if ($row->writer_type == 'a') {
                    $arr_push = UserAppInfo::where('user_id', $row->sidx)
                        ->where('advice_alarm', 'Y')
                        ->whereNotNull('push_key')
                        ->pluck('push_key')
                        ->toArray();
                    $body = "본사 댓글이 작성되었습니다.";
                } else if ($row->writer_type == 'h') {
                    $arr_push = UserAppInfo::where('user_id', $row->sidx)
                        ->where('advice_alarm', 'Y')
                        ->whereNotNull('push_key')
                        ->pluck('push_key')
                        ->toArray();
                    $body = "지사 댓글이 작성되었습니다.";
                } else if ($row->writer_type == 'm') {
                    $arr_push = UserAppInfo::where('user_id', $row->sidx)
                        ->where('advice_alarm', 'Y')
                        ->whereNotNull('push_key')
                        ->pluck('push_key')
                        ->toArray();
                    $body = "교육원 댓글이 작성되었습니다.";
                } else if ($row->writer_type == 's') {
                    $student = RaonMember::where('idx', $row->sidx)->first();

                    if($student){
                        $arr_push = UserAppInfo::where('user_id', $row->midx)->where('advice_alarm', 'Y')->whereNotNull('push_key')->pluck('push_key')->toArray();
                        $body = "{$student->name} 학부모 댓글이 작성되었습니다.";
                    }
                }

                if ($arr_push) {
                    $arr_push = array_unique($arr_push);
                    $arr_push = array_values($arr_push);

                    $pushLog = new PushLog([
                        'type' => $this->type,
                        'type_id' => $this->type_id,
                        'receivers' => json_encode($arr_push)
                    ]);

                    $pushLog->save();

                    if (env('APP_ENV') != 'dev') {
                        $handler = App::make(FcmHandler::class);
                        $handler->setReceivers($arr_push);
                        $handler->setMessage(['title' => $title, 'body' => $body, 'type'=>'advice', 'id'=>$row->advice_note_id,'userId'=>$row->sidx]);
                        $handler->setMessageData(['title' => $title, 'message' => $body, 'type'=>'advice', 'id'=>$row->advice_note_id,'userId'=>$row->sidx]);
                        $handler->sendMessage();
                    }
                }
            }
        }
        else if ($this->type == "notice")
        {
            $row = Notice::find($this->type_id);

            if ($row) {
                if ($row->writer_type == 'm') {
                    if ($nowTime < $diffTime) {
                        $rs = RaonMember::where('midx', $row->midx)
                            ->where('mtype', 's')
                            ->where(function($query) use($row) {
                                $query->where('s_status', 'Y')
                                    ->orWhereRaw("id IN (SELECT `sidx` FROM `asobi_log` WHERE `midx` = ? AND `log_type` = 'M2' AND date(`acceptDate`) between '2022-01-24' and '2022-01-28')", [$row->midx]);
                            })
                            ->pluck('idx')
                            ->toArray();
                    } else {
                        $rs = RaonMember::where('midx', $row->midx)
                            ->where('mtype', 's')
                            ->where('s_status', 'Y')
                            ->pluck('idx')
                            ->toArray();
                    }

                    $arr_push = UserAppInfo::whereIn('user_id', $rs)
                        ->where('notice_alarm', 'Y')
                        ->where('push_key', '!=', 'web')
                        ->where('updated_at', '>=', now()->subMonths(6))
                        ->whereNotNull('push_key')
                        ->orderByDesc('updated_at')
                        ->distinct('push_key')
                        ->pluck('push_key')
                        ->toArray();

                    $body = "[공지] {$row->title}";
                } else if ($row->writer_type == 'h') {
                    $rs = RaonMember::where('hidx', $row->midx)
                        ->where('mtype', 'm')
                        ->where('m_status', 'Y')
                        ->pluck('idx')
                        ->toArray();

                    $arr_push = UserAppInfo::whereIn('user_id', $rs)
                        ->where('notice_alarm', 'Y')
                        ->where('push_key', '!=', 'web')
                        ->where('updated_at', '>=', now()->subMonths(6))
                        ->whereNotNull('push_key')
                        ->orderByDesc('updated_at')
                        ->distinct('push_key')
                        ->pluck('push_key')
                        ->toArray();
                    $body = "[공지] {$row->title}";
                } else if ($row->writer_type == 'a') {
                    if ($nowTime < $diffTime) {
                        $rs = RaonMember::where('midx', 's')
                            ->where(function($query) use($row) {
                                $query->where('s_status', 'Y')
                                    ->orWhereRaw("idx IN (SELECT `student_id` FROM `logs` WHERE `log_type` = 'M2' AND date(`accepted_at`) between '2022-01-24' and '2022-01-28')");
                            })
                            ->pluck('idx')
                            ->toArray();
                    } else {

//                        $rs = RaonMember::where('mtype', 's')
//                            ->where('s_status', 'Y')
//                            ->pluck('idx')
//                            ->toArray();

                        $rs = RaonMember::where(function($query) {
                            $query->where('mtype', 's')->where('s_status', 'Y');
                                })->orWhere(function($query) {
                            $query->where('mtype', 'm')->where('m_status', 'Y');
                                })->orWhere(function($query) {
                            $query->where('mtype', 'h')->where('h_status', 'Y');
                                })
                            ->pluck('idx')
                            ->toArray();
                    }

                    $arr_push = UserAppInfo::whereIn('user_id', $rs)
                        ->where('notice_alarm', 'Y')
                        ->where('push_key', '!=', 'web')
                        ->where('updated_at', '>=', now()->subMonths(6))
                        ->whereNotNull('push_key')
                        ->orderByDesc('updated_at')
                        ->distinct('push_key')
                        ->pluck('push_key')
                        ->toArray();
                    $body = "[공지] {$row->title}";
                }

                if ($arr_push) {
                    $arr_push = array_unique($arr_push);
                    $arr_push = array_values($arr_push);

                    $pushLog = new PushLog([
                        'type' => $this->type,
                        'type_id' => $this->type_id,
                        'receivers' => json_encode($arr_push)
                    ]);

                    $pushLog->save();

                    if (env('APP_ENV') != 'dev') {
                        $handler = App::make(FcmHandler::class);
                        $handler->setReceivers($arr_push);
                        $handler->setMessage(['title' => $title, 'body' => $body, 'type'=>$this->type, 'id'=>$row->id]);
                        $handler->setMessageData(['title' => $title, 'message' => $body, 'type'=>$this->type, 'id'=>$row->id]);
                        $handler->sendMessage();
                    }
                }
            }
        }
        else if ($this->type == "appNotice") // 어드민으로 테스트
        {
            $row = AppNotice::find($this->type_id);

            if ($row) {
                if ($row->read_branch == 'Y') {
                    $branch_rs = RaonMember::where('mtype', 'h')
                        ->where('h_status', 'Y')
                        ->pluck('idx')
                        ->toArray();

                    $center_rs = RaonMember::where('mtype', 'm')
                        ->where('m_status', 'Y')
                        ->pluck('idx')
                        ->toArray();

                    $rs = array_merge($branch_rs, $center_rs);

//                    $arr_push = UserAppInfo::whereIn('user_id', $rs)
//                        ->where('notice_alarm', 'Y')
//                        ->whereNotNull('push_key')
//                        ->pluck('push_key')
//                        ->toArray();

                    $arr_push = UserAppInfo::whereIn('user_id', $rs)
                        ->where('notice_alarm', 'Y')
                        ->where('push_key', '!=', 'web')
                        ->where('updated_at', '>=', now()->subMonths(6))
                        ->whereNotNull('push_key')
                        ->orderByDesc('updated_at')
                        ->distinct('push_key')
                        ->pluck('push_key')
                        ->toArray();
                } else if ($row->read_center == 'Y') {
                    $rs = RaonMember::where('hidx', $row->hidx)
                        ->where('mtype', 'm')
                        ->where('m_status', 'Y')
                        ->pluck('idx')
                        ->toArray();

//                    $arr_push = UserAppInfo::whereIn('user_id', $rs)
//                        ->where('notice_alarm', 'Y')
//                        ->whereNotNull('push_key')
//                        ->pluck('push_key')
//                        ->toArray();

                    $arr_push = UserAppInfo::whereIn('user_id', $rs)
                        ->where('notice_alarm', 'Y')
                        ->where('push_key', '!=', 'web')
                        ->where('updated_at', '>=', now()->subMonths(6))
                        ->whereNotNull('push_key')
                        ->orderByDesc('updated_at')
                        ->distinct('push_key')
                        ->pluck('push_key')
                        ->toArray();
                }

                if ($arr_push) {
                    $arr_push = array_unique($arr_push);
                    $arr_push = array_values($arr_push);

                    $pushLog = new PushLog([
                        'type' => $this->type,
                        'type_id' => $this->type_id,
                        'receivers' => json_encode($arr_push)
                    ]);

                    $pushLog->save();

                    if (env('APP_ENV') != 'dev') {
                        $body = "[공지] {$row->title}";
                        $handler = App::make(FcmHandler::class);
                        $handler->setReceivers($arr_push);
                        $handler->setMessage(['title' => $title, 'body' => $body, 'type'=>$this->type, 'id'=>$row->id]);
                        $handler->setMessageData(['title' => $title, 'message' => $body, 'type'=>$this->type, 'id'=>$row->id]);
                        $handler->sendMessage();
                    }
                }
            }
        }
        else if ($this->type == "album")
        {
            $row = Album::find($this->type_id);

            if ($row) {
                if ($row->sidx) {
                    $rs = json_decode($row->sidx);

                    if (is_array($rs) && count($rs)) {
                        $arr_push = UserAppInfo::whereIn('user_id', $rs)
                            ->where('album_alarm', 'Y')
                            ->whereNotNull('push_key')
                            ->pluck('push_key')
                            ->toArray();

                        if ($arr_push) {
                            $arr_push = array_unique($arr_push);
                            $arr_push = array_values($arr_push);

                            $pushLog = new PushLog([
                                'type' => $this->type,
                                'type_id' => $this->type_id,
                                'receivers' => json_encode($arr_push)
                            ]);

                            $pushLog->save();

                            $body = "교육원 앨범이 작성되었습니다.";

                            if (env('APP_ENV') != 'dev') {
                                $handler = App::make(FcmHandler::class);
                                $handler->setReceivers($arr_push);
                                $handler->setMessage(['title' => $title, 'body' => $body, 'type'=>$this->type, 'id'=>$row->id]);
                                $handler->setMessageData(['title' => $title, 'message' => $body, 'type'=>$this->type, 'id'=>$row->id]);
                                $handler->sendMessage();
                            }
                        }
                    }
                }
            }
        }
        else if ($this->type == "albumComment")
        {
            $row = AlbumComment::find($this->type_id);

            if ($row) {
                $rs = json_decode($row->sidx);
                if ($row->writer_type == 'a') {
                    if (is_array($rs) && count($rs)) {
                        $arr_push = UserAppInfo::whereIn('user_id', $rs)
                            ->where('album_alarm', 'Y')
                            ->whereNotNull('push_key')
                            ->pluck('push_key')
                            ->toArray();
                    }

                    $body = "본사 댓글이 작성되었습니다.";
                } else if ($row->writer_type == 'h') {
                    if (is_array($rs) && count($rs)) {
                        $arr_push = UserAppInfo::whereIn('user_id', $rs)
                            ->where('album_alarm', 'Y')
                            ->whereNotNull('push_key')
                            ->pluck('push_key')
                            ->toArray();
                    }

                    $body = "지사 댓글이 작성되었습니다.";
                } else if ($row->writer_type == 'm') {
                    if (is_array($rs) && count($rs)) {
                        $arr_push = UserAppInfo::whereIn('user_id', $rs)
                            ->where('album_alarm', 'Y')
                            ->whereNotNull('push_key')
                            ->pluck('push_key')
                            ->toArray();
                    }

                    $body = "교육원 댓글이 작성되었습니다.";
                } else if ($row->writer_type == 's') {
                    if (is_array($rs) && count($rs)) {
                        $student = RaonMember::whereIn('idx', $rs)->first();

                        if ($student) {
                            $arr_push = UserAppInfo::where('user_id', $row->midx)
                                ->where('album_alarm', 'Y')
                                ->whereNotNull('push_key')
                                ->pluck('push_key')
                                ->toArray();

                            $body = "{$student->name} 학부모 댓글이 작성되었습니다.";
                        }
                    }
                }

                if ($arr_push) {
                    $arr_push = array_unique($arr_push);
                    $arr_push = array_values($arr_push);

                    $pushLog = new PushLog([
                        'type' => $this->type,
                        'type_id' => $this->type_id,
                        'receivers' => json_encode($arr_push)
                    ]);

                    $pushLog->save();

                    if (env('APP_ENV') != 'dev') {
                        $handler = App::make(FcmHandler::class);
                        $handler->setReceivers($arr_push);
                        $handler->setMessage(['title' => $title, 'body' => $body, 'type'=>'album', 'id'=>$row->album_id]);
                        $handler->setMessageData(['title' => $title, 'message' => $body, 'type'=>'album', 'id'=>$row->album_id]);
                        $handler->sendMessage();
                    }
                }
            }
        }
        else if ($this->type == 'attendance')
        {
            $row = Attendance::find($this->type_id);

            if ($row) {
                if ($row->sidx) {
                    $user = RaonMember::where('idx', $row->sidx)->first();

                    if ($user) {
                        $arr_push = UserAppInfo::where('user_id', $row->sidx)
                            ->where('attendance_alarm', 'Y')
                            ->whereNotNull('push_key')
                            ->pluck('push_key')
                            ->toArray();

                        $body = "";
                        $attendance_type = $this->param['type'] ?? "";
                        $attendance_check = $this->param['check'] ?? "";
                        if ($attendance_type == "in" && $attendance_check == "1") {
                            $body = $user->name . " " . date('y년m월d일 H시i분', strtotime($row->in_at)) ."에 등원하였습니다.";
                            if (date('Ymd', strtotime($row->in_at)) != $row->year.$row->month.$row->day) {
                                $body = $user->name . " " . date('y년m월d일 H시i분', strtotime($row->in_at)) ."에 등원 체크하였습니다.";
                            }
                        } else if ($attendance_type == "out" && $attendance_check == "1") {
                            $body = $user->name . " " . date('y년m월d일 H시i분', strtotime($row->out_at)) ."에 하원하였습니다.";
                            if (date('Ymd', strtotime($row->out_at)) != $row->year.$row->month.$row->day) {
                                $body = $user->name . " " . date('y년m월d일 H시i분', strtotime($row->out_at)) ."에 하원 체크하였습니다.";
                            }
                        } else if ($attendance_type == "in" && $attendance_check == "0") {
                            $body = $user->name . " 등원 취소하였습니다.";
                        } else if ($attendance_type == "out" && $attendance_check == "0") {
                            $body = $user->name . " 하원 취소하였습니다.";
                        }

                        if ($arr_push) {
                            $arr_push = array_unique($arr_push);
                            $arr_push = array_values($arr_push);

                            $pushLog = new PushLog([
                                'type' => $this->type,
                                'type_id' => $this->type_id,
                                'receivers' => json_encode($arr_push)
                            ]);

                            $pushLog->save();

                            $date = $row->year . '-' . $row->month;

                            if (env('APP_ENV') != 'dev') {
                                $handler = App::make(FcmHandler::class);
                                $handler->setReceivers($arr_push);
                                $handler->setMessage(['title'=> $title, 'body'=> $body, 'type'=> $this->type, 'id'=> $row->id, 'userId'=>$row->sidx, 'check'=>$attendance_check, 'date' => $date]);
                                $handler->setMessageData(['title'=> $title, 'message'=> $body, 'type'=> $this->type, 'id'=> $row->id,'userId'=>$row->sidx,'check'=>$attendance_check, 'date' => $date]);
                                $handler->sendMessage();
                            }
                        }
                    }
                }
            }
        }
        else if ($this->type == 'educatonInfo') // 어드민으로 테스트
        {
            $row = EducatonInfo::find($this->type_id);
            if ($row) {
//                $arr_push = UserAppInfo::where('adu_info_alarm', 'Y')
//                    ->whereNotNull('push_key')
//                    ->pluck('push_key')
//                    ->toArray();

                $rs = RaonMember::where(function($query) {
                    $query->where('mtype', 's')->where('s_status', 'Y');
                })->orWhere(function($query) {
                    $query->where('mtype', 'm')->where('m_status', 'Y');
                })->orWhere(function($query) {
                    $query->where('mtype', 'h')->where('h_status', 'Y');
                })
                    ->pluck('idx')
                    ->toArray();

                $arr_push = UserAppInfo::whereIn('user_id', $rs)
                    ->where('adu_info_alarm', 'Y')
                    ->where('push_key', '!=', 'web')
                    ->where('updated_at', '>=', now()->subMonths(6))
                    ->whereNotNull('push_key')
                    ->orderByDesc('updated_at')
                    ->distinct('push_key')
                    ->pluck('push_key')
                    ->toArray();

//                $arr_push = UserAppInfo::where('user_id', '132895')->where('device_kind', 'iOS')->pluck('push_key')->toArray();

                $body = "교육정보 '{$row->subject}'이 등록되었습니다.";

                if ($arr_push) {
                    $arr_push = array_unique($arr_push);
                    $arr_push = array_values($arr_push);

                    $pushLog = new PushLog([
                        'type' => $this->type,
                        'type_id' => $this->type_id,
                        'receivers' => json_encode($arr_push)
                    ]);

                    $pushLog->save();

                    if (env('APP_ENV') != 'dev') {
                        $handler = App::make(FcmHandler::class);
                        $handler->setReceivers($arr_push);
                        $handler->setMessage(['title'=> $title, 'body'=> $body, 'type'=> $this->type, 'id'=> $row->id]);
                        $handler->setMessageData(['title'=> $title, 'message'=> $body, 'type'=> $this->type, 'id'=> $row->id]);
                        $handler->sendMessage();
                    }
                }
            }
        }
        else if ($this->type == 'educatonInfoComment')
        {
        }
        else if ($this->type == 'event') // 어드민으로 테스트
        {
            $row = Event::find($this->type_id);

            if ($row && date('Y-m-d', strtotime($row->created_at)) >= date('Y-m-d', strtotime($row->start))) {
//                $arr_push = UserAppInfo::where('event_alarm', 'Y')
//                    ->whereNotNull('push_key')
//                    ->pluck('push_key')
//                    ->toArray();

                $rs = RaonMember::where(function($query) {
                    $query->where('mtype', 's')->where('s_status', 'Y');
                })->orWhere(function($query) {
                    $query->where('mtype', 'm')->where('m_status', 'Y');
                })->orWhere(function($query) {
                    $query->where('mtype', 'h')->where('h_status', 'Y');
                })
                    ->pluck('idx')
                    ->toArray();

                $arr_push = UserAppInfo::whereIn('user_id', $rs)
                    ->where('event_alarm', 'Y')
                    ->where('push_key', '!=', 'web')
                    ->where('updated_at', '>=', now()->subMonths(6))
                    ->whereNotNull('push_key')
                    ->orderByDesc('updated_at')
                    ->distinct('push_key')
                    ->pluck('push_key')
                    ->toArray();

                $body = "이벤트 '{$row->subject}'이 등록되었습니다.";

                if ($arr_push) {
                    $arr_push = array_unique($arr_push);
                    $arr_push = array_values($arr_push);

                    $pushLog = new PushLog([
                        'type' => $this->type,
                        'type_id' => $this->type_id,
                        'receivers' => json_encode($arr_push)
                    ]);

                    $pushLog->save();

                    if (env('APP_ENV') != 'dev') {
                        $handler = App::make(FcmHandler::class);
                        $handler->setReceivers($arr_push);
                        $handler->setMessage(['title'=> $title, 'body'=> $body, 'type'=> $this->type, 'id'=> $row->id]);
                        $handler->setMessageData(['title'=> $title, 'message'=> $body, 'type'=> $this->type, 'id'=> $row->id]);
                        $handler->sendMessage();
                    }
                }
            } else {
                $pushLog = new PushLog([
                    'type' => $this->type,
                    'type_id' => $this->type_id,
                    'receivers' => ''
                ]);

                $pushLog->save();
            }
        }
        else if ($this->type == 'eventRePush') // 어드민으로 테스트
        {
            $row = Event::find($this->type_id);

            $rs = RaonMember::where(function($query) {
                $query->where('mtype', 's')->where('s_status', 'Y');
            })->orWhere(function($query) {
                $query->where('mtype', 'm')->where('m_status', 'Y');
            })->orWhere(function($query) {
                $query->where('mtype', 'h')->where('h_status', 'Y');
            })
                ->pluck('idx')
                ->toArray();

            $arr_push = UserAppInfo::whereIn('user_id', $rs)
                ->where('event_alarm', 'Y')
                ->where('push_key', '!=', 'web')
                ->where('updated_at', '>=', now()->subMonths(6))
                ->whereNotNull('push_key')
                ->orderByDesc('updated_at')
                ->distinct('push_key')
                ->pluck('push_key')
                ->toArray();

            $body = '✨ 재원생 100% 경품 증정! 지금 바로 확인하세요!';

//            $arr_push = [
//                /*내 아이폰*/'cYxbJfKY9kzWhA5hrB8u_i:APA91bEIedrv1r_kBty9APISGaDoBSbeXN2eF_RaxsLp1pqamEDUJArVnOBFj83_ilk2rP7qjOmRpMmd2nzsNCMxtNH-qEn2TAD3ZdhH-dBC_iRJCmQPRBAAZj0-xqOnaZWdkXgHZRJn',
//                /*내 갤럭시*/'cDjquBw7SZS8HuZaEC5kiY:APA91bF43bAO8g7ztIiFOhqDnpFas5kKQyHKyzHCuEyEAcPPjJjBnR_r2Pno5P7mu-ToXIIlj00dFTS6fR-IdhVMlP-fUOJ96OFuODFI1leNvmHiHC_nPW21r_I9XQ-0obfCMjtEAWeQ',
//
//                /*갤럭시*/'dui06J6qIEVKvM3KT4cFcv:APA91bGHOxae4i8PPLDM56t2hLwF4P5tORirVIH9J_4CDN0Wt6lbVo8attoTWWhPnPKaoPRxASay-8iSUZnIFiVdDRqzE-quBX21_-r2phe2PMazZJwzFqYyUSGqkophktnilmiTqws8',
//                /*갤탭*/'dwmnlwarQx29eU2lQEzMqk:APA91bFwFpYH3i3ITyq2kvJCa1SOuwRm0WB7_ztkHRhogPWktyPWF_nOhl3So1j1HqQcjR3Di-Ju_skmdSbr2PV0yS3hZ2b5tePZ1xAo7npSlAiu9CEY7sBqjZRlbUJyD7jtDWLsv9NQ',
//                /*아이폰*/'dMpnwMq9RTa-jdhgKSbS-u:APA91bFTn8ugL7a1DG7wB3Yqi-vaiLFUw5Pd8jdfNlqUpvdXzRYWhSe64UszCyY3tpzMIVJpGvK61KLVou3nyh6cfQlulb-bJ1xITRmZQ4m4e7wUWtNcqr5NHpWq8y0ZH2up_6w9YNz0',
//                'dTnJ0XviSluErRNEN1hy2_:APA91bERUleIJlM62OE6X5PaQpLDJlQtd6PyCBjaPVWtBhd4QHPvQmU320BdY7KYKZ95JjmFtwxwujN_x3ksddC3P0n_mpZOwoGrhz9PWzHDuZ6bPEZsIhbYwrBNLpU1xDVmGyNO9tfQ',
//                'eKPqMZSzSqyjRoY1D9aRVu:APA91bFDztk2rGphcE86KWiOQAcv-N0_ctO1o8wCG99UXa1q89Gumha-hbLbwGR7hzACP8vTvH3VvNCbnxeOwBooDUWRwdaKGiTsZJ3xCnpDZEFlLsPBeIVPpBPkfPFp96izCo1QBGYs',
//            ];

            if ($arr_push) {
                $arr_push = array_unique($arr_push);
                $arr_push = array_values($arr_push);

                $pushLog = new PushLog([
                    'type' => $this->type,
                    'type_id' => $this->type_id,
                    'receivers' => json_encode($arr_push)
                ]);

                $pushLog->save();

                $handler = App::make(FcmHandler::class);
                $handler->setReceivers($arr_push);
                $handler->setMessage(['title'=> $title, 'body'=> $body, 'type'=> 'event', 'id'=> $row->id]);
                $handler->setMessageData(['title'=> $title, 'message'=> $body, 'type'=> 'event', 'id'=> $row->id]);
                $handler->sendMessage();
            }

        }
        else if ($this->type == 'eventComment')
        {
        }
    }

    public function test_push($push_key, $mtype)
    {
        $title = "아소비";
        $body = "알림";
        dump($push_key);
        dump($mtype);
        dump($this->type);
        dump($this->type_id);

        if ($this->type == AdviceNote::ADVICE_TYPE || $this->type == AdviceNote::LETTER_TYPE) {
            $row = AdviceNote::find($this->type_id);
            if ($row) {
                $student = RaonMember::where('idx', $row->sidx)->first();
                if ($student) {
                    if ($row->type == AdviceNote::ADVICE_TYPE) {
                        $body = "{$student->name}의 알림장이 작성되었습니다.";
                    } else if ($row->type == AdviceNote::LETTER_TYPE) {
                        $body = "{$student->name}의 {$row->month}월 가정통신문이 작성되었습니다.";
                    }

                    if ($push_key) {
                        $handler = App::make(FcmHandler::class);
                        $handler->setReceivers([$push_key]);
                        $handler->setMessage(['title' => $title, 'body' => $body, 'type'=>$this->type, 'id'=>$row->id]);
                        $handler->setMessageData(['title' => $title, 'message' => $body, 'type'=>$this->type, 'id'=>$row->id]);
                        $handler->sendMessage();
                    }
                }
            }
        } else if ($this->type == "adviceComment") {
            $row = AdviceComment::find($this->type_id);
//            \App::make('helper')->log('adviceComment', ['bbb' => $this->type_id], 'adviceComment');
            if($row){
                if ($row->writer_type == 'a'){
                    $body = "본사 댓글이 작성되었습니다.";
                } else if($row->writer_type == 'h'){
                    $body = "지사 댓글이 작성되었습니다.";
                } else if($row->writer_type == 'm'){
                    $body = "교육원 댓글이 작성되었습니다.";
                } else if($row->writer_type == 's'){
                    $student = RaonMember::where('idx', $row->sidx)->first();
                    if($student){
                        $body = "{$student->name} 학부모 댓글이 작성되었습니다.";
                    }
                }
                $parent_row = AdviceNote::where('id', $row->advice_note_id)->first();
                if ($push_key) {
                    $handler = App::make(FcmHandler::class);
                    $handler->setReceivers([$push_key]);
                    $handler->setMessage(['title' => $title, 'body' => $body, 'type'=>$parent_row->type, 'id'=>$parent_row->id,'userId'=>$parent_row->sidx]);
                    $handler->setMessageData(['title' => $title, 'message' => $body, 'type'=>$parent_row->type, 'id'=>$parent_row->id,'userId'=>$parent_row->sidx]);
                    $handler->sendMessage();
                }
            }
        } else if ($this->type == "notice") {
            $row = Notice::find($this->type_id);
            if ($row) {
                if ($row->writer_type == 'm') {
                    $rs = RaonMember::where('midx', $row->midx)->where('mtype', 's')->where('s_status', 'Y')->pluck('idx')->toArray();
                    $body = "[공지] 교육원 공지사항이 작성되었습니다.";
                } else if ($row->writer_type == 'h') {
                    $rs = RaonMember::where('hidx', $row->midx)->where('mtype', 'm')->where('m_status', 'Y')->pluck('idx')->toArray();
                    $body = "[공지] 지사 공지사항이 작성되었습니다.";
                } else if ($row->writer_type == 'a') {
                    $rs = RaonMember::where('mtype', 's')->where('s_status', 'Y')->pluck('idx')->toArray();
                    $body = "[공지] 공지사항이 작성되었습니다.";
                }
                if ($push_key) {
                    $handler = App::make(FcmHandler::class);
                    $handler->setReceivers([$push_key]);
                    $handler->setMessage(['title' => $title, 'body' => $body, 'type'=>$this->type, 'id'=>$row->id]);
                    $handler->setMessageData(['title' => $title, 'message' => $body, 'type'=>$this->type, 'id'=>$row->id]);
                    $handler->sendMessage();
                }
            }
        } else if ($this->type == "appNotice") {
            $row = AppNotice::find($this->type_id);
            if ($row) {
                if ($row->read_branch == 'Y') {
                    $branch_rs = RaonMember::where('mtype', 'h')->where('h_status', 'Y')->pluck('idx')->toArray();
                    $center_rs = RaonMember::where('mtype', 'm')->where('m_status', 'Y')->pluck('idx')->toArray();
                    $rs = array_merge($branch_rs, $center_rs);
                } else if ($row->read_center == 'Y') {
                    $rs = RaonMember::where('hidx', $row->hidx)->where('mtype', 'm')->where('m_status', 'Y')->pluck('idx')->toArray();
                }
                if ($push_key) {
                    $body = "[공지] 아소비교육 공지사항이 작성되었습니다.";
                    $handler = App::make(FcmHandler::class);
                    $handler->setReceivers([$push_key]);
                    $handler->setMessage(['title' => $title, 'body' => $body, 'type'=>$this->type, 'id'=>$row->id]);
                    $handler->setMessageData(['title' => $title, 'message' => $body, 'type'=>$this->type, 'id'=>$row->id]);
                    $handler->sendMessage();
                }
            }
        } else if ($this->type == "album") {
            $row = Album::find($this->type_id);
            if ($row) {
                if ($row->sidx) {
                    $rs = json_decode($row->sidx);
                    if (is_array($rs) && sizeof($rs)) {
                        if ($push_key) {
                            $body = "교육원 앨범이 작성되었습니다.";
                            $handler = App::make(FcmHandler::class);
                            $handler->setReceivers([$push_key]);
                            $handler->setMessage(['title' => $title, 'body' => $body, 'type'=>$this->type, 'id'=>$row->id]);
                            $handler->setMessageData(['title' => $title, 'message' => $body, 'type'=>$this->type, 'id'=>$row->id]);
                            $handler->sendMessage();
                        }
                    }
                }
            }
        } else if ($this->type == "albumComment") {
            $row = AlbumComment::find($this->type_id);
            if($row){
                if ($row->writer_type == 'a') {
                    $body = "본사 댓글이 작성되었습니다.";
                } else if($row->writer_type == 'h'){
                    $body = "지사 댓글이 작성되었습니다.";
                } else if($row->writer_type == 'm'){
                    $body = "교육원 댓글이 작성되었습니다.";
                } else if($row->writer_type == 's'){
                    $student = RaonMember::where('idx', $row->sidx)->first();
                    if($student){
                        $body = "{$student->name} 학부모 댓글이 작성되었습니다.";
                    }
                }
                if ($push_key) {
                    $handler = App::make(FcmHandler::class);
                    $handler->setReceivers([$push_key]);
                    $handler->setMessage(['title' => $title, 'body' => $body, 'type'=>'album', 'id'=>$row->album_id]);
                    $handler->setMessageData(['title' => $title, 'message' => $body, 'type'=>'album', 'id'=>$row->album_id]);
                    $handler->sendMessage();
                }
            }
        }
    }
}

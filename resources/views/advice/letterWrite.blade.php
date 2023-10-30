@extends('layout.home')
@section('bodyAttr')
class="body"
@endsection
@section('contents')
<?php
$title = "가정통신문 작성";
$hd_bg = "1";
// /advice/letter/write?ym=2023-09
// /advice/143205/letter/view/962603

if ($id && $userId) {
    $back_link = '/advice/'.$userId.'/letter/view/'.$id;
} else {
    $back_link = '/advice';
}
?>
@include('common.headm04')
@include('advice.letterPreview')

<article class="sub_pg">
    <div class="container pt-4 pt_lg_50">
        <div class="d-none d-lg-block">
            @include('common.tabs')
        </div>
        <div class="d-none d-lg-flex align-items-center justify-content-between mb-4 mb-lg-5">
            <h1 class="tit_h1 ff_lotte fw_500">
                <?=$title?>
                <img src="/img/ic_tit.png" class="tit_img">
            </h1>
            <div class="d-flex">
                @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='m')
                    @if($mode == 'w')
                <!-- ※ 임시저장은 교육원 일때만 노출 -->
                <button type="button" class="btn btn-md border border-primary text-primary px-5 mr-3" onclick="jalert2('임시저장을 하시겠습니까?', '임시저장', tmpSave);">임시저장</button>
                    @endif
                @endif
                <button type="button" class="btn btn-md border border-primary text-primary px-5"onclick="getAdvicePreview()">미리보기</button>
            </div>
        </div>

        <form name="adviceForm" id="adviceForm" class="mt-3" method="POST" action="/advice/writeAction" onsubmit="return frm_form_chk(this);" enctype="multipart/form-data">
            <input type="hidden" name="mode" value="{{ $mode }}">
            <input type="hidden" name="id" value="{{ $id }}">
            <input type="hidden" name="userId" value="{{ $userId }}">
            <input type="hidden" name="type" value="letter" />
            <div class="grid02_list">
                <div class="ip_wr">
                    <div class="ip_tit d-flex align-items-center justify-content-between">
                        <h5>작성일자</h5>
                    </div>
{{--                    <input type="date" name="ymd" id="ymd" value="{{ $ymd }}" max="<?php echo date("Y-m-d") ?>" @if($mode != "w")readonly="readonly"@endif class="form-control text-dark_gray">--}}
                    <input type="month" name="ymd" id="ymd" value="{{ $ym }}" min="{{ $minMonth ?? ''}}" max="{{ $nextMonth ?? ''}}" @if(($mode != "w" && $id) || session('auth')['user_type'] != 'a')readonly="readonly"@endif class="form-control text-dark_gray">
                </div>
                <div class="d-none d-lg-block"></div>
                @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='m')
                <!-- 교육원일 때 작성시 -->
                <div class="ip_wr">
                    <div class="ip_tit d-flex align-items-center justify-content-between">
                        <h5>내용</h5>
                        <button type="button" class="btn p-0 h-auto" onclick="boardCopy('content')"><img src="/img/ic_copy.png" style="width: 2rem;"></button>
                    </div>
                    <textarea id="content" name="content" class="form-control" placeholder="내용을 입력해주세요" rows="5">{{ $row['content']??'' }}</textarea>
                </div>
                <div class="ip_wr">
                    <div class="ip_tit d-flex align-items-center justify-content-between">
                        <h5>이번 달 수업에서</h5>
                    </div>
                    <textarea id="class_content" name="class_content" class="form-control" placeholder="내용을 입력해주세요" rows="5">{{ $row['class_content']??'' }}</textarea>
                </div>
                <!-- // 교육원일 때 작성시 -->
                @elseif(isset(session('auth')['user_type']) && session('auth')['user_type'] =='a')
                <!-- 본사일 때 작성시 -->
                <div class="ip_wr">
                    <div class="ip_tit d-flex align-items-center justify-content-between">
                        <h5>아소비 교육원 알림</h5>
                    </div>
                    <textarea id="prefix_content" name="prefix_content" class="form-control" placeholder="내용을 입력해주세요" rows="5">{{ $row['prefix_content']??'' }}</textarea>
                </div>
                <div class="ip_wr">
                    <div class="ip_tit d-flex align-items-center justify-content-between">
                        <h5>교육정보</h5>
                    </div>
                    <textarea id="this_month_education_info" name="this_month_education_info" class="form-control" placeholder="내용을 입력해주세요" rows="5">{{ $row['this_month_education_info']??'' }}</textarea>
                </div>
                <!-- // 본사일 때 작성시 -->
                @endif
            </div>

            @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='m')
            <!-- 학생선택은 교육원일 때만 노출 -->
                @if(session('auth')['user_type'] == 'm')
                    <div class="d-flex align-items-center justify-content-between mt-3 pt-3 mb-4">
                        <div class="ip_wr">
                            <div class="ip_tit mb-0">
                                <h5>학생선택</h5>
                            </div>
                        </div>
                        @if(count($student) > 0)
                        <div class="checks_wr">
                            <div class="checks mr-0">
                                <label>
                                    <input type="checkbox" id="chkStudentAll">
                                    <span class="ic_box"></span>
                                    <div class="chk_p">
                                        <p>전체선택</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                        @endif
                    </div>
                    @if(count($student) > 0)
                    <ul class="grid03_list note_stu_list_chk pb-3">
                        @foreach($student as $l)
{{--                            @if($l['letter'] == "0")--}}
                            <li>
                                <label>
                                    <input type="checkbox" name="student[]" @if($search_user_id!="" && $search_user_id == $l['id']) checked="checked" @endif value="{{ $l['id'] }}" class="chkStudent d-none">
                                    <div class="chk_li">
                                        <div class="d-flex align-items-center">
                                            <div class="rect rounded-circle">
                                                <img src="{{ $l['profile_image'] ?? '/img/profile_default.png' }}">
                                            </div>
                                            <p class="fs_16 fw_700 ml-3">{{ $l['name'] }}</p>
                                        </div>
                                        <span class="ic_box"></span>
                                    </div>
                                </label>
                            </li>
{{--                            @endif--}}
                        @endforeach
                    </ul>
                    @else
                        <!-- //학생없을때 표기해주세요. -->
                        <div class="nodata">
                            <p>조회된 학생이 없습니다.</p>
                        </div>
                    @endif
                @else
                    <input type="hidden" name="student" value="{{ $row['student'] ?? '' }}" >
                @endif
            @endif
            <div class="cmt_wr note_btns pt-0 pt_lg_50 pb-0 pb-lg-4">
                <button type="submit" id="fsubmit" class="btn btn-primary">전송</button>
                <button type="button" class="d-none d-lg-block btn btn-gray text-white" onclick="location.href='/advice'">목록</button>
                @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='m')
                    @if($mode == 'w')
                <!-- ※ 임시저장은 교육원 일때만 노출 -->
                <button type="button" class="d-block d-lg-none btn btn-gray text-white" onclick="jalert2('임시저장을 하시겠습니까?', '임시저장', tmpSave);">임시저장</button>
                    @endif
                @endif
            </div>
        </form>
    </div>
</article>

<div class="loading_wrap" id="loading" style="display: none;">
    <div class="loading_text">
        <i class="loading_circle"></i>
        <span>로딩중</span>
    </div>
</div>

<script>
    var fsubmit = false;

    function frm_form_chk(f) {
        if (fsubmit) {
            return false;
        }
        fsubmit = true;
        $("#fsubmit").prop('disabled',true);

        const currentDate = new Date();
        const ymdValue = new Date(f.ymd.value);

        if (f.ymd.value == "") {
            fsubmit = false;
            $("#fsubmit").prop('disabled',false);
            jalert("작성일자를 입력해주세요.");
            return false;
        }

        // if (ymdValue > currentDate) {
        //     fsubmit = false;
        //     $("#fsubmit").prop('disabled',false);
        //     jalert('미래 날짜는 선택할 수 없습니다.');
        //     return false;
        // }

        @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='m')
            // if (f.content.value == "") {
            //     fsubmit = false;
            //     $("#fsubmit").prop('disabled',false);
            //     jalert("내용을 입력해주세요.");
            //     return false;
            // }

            // if (f.class_content.value == "") {
            //     fsubmit = false;
            //     $("#fsubmit").prop('disabled',false);
            //     jalert("수업내용을 입력해주세요.");
            //     return false;
            // }

            @if($mode == "w")
            if ($("input[name='student[]']:checked").length == 0) {
                fsubmit = false;
                $("#fsubmit").prop('disabled',false);
                jalert("학생을 선택해 주세요.");
                return false;
            }
            @else
            if (f.student.value == "") {
                fsubmit = false;
                $("#fsubmit").prop('disabled',false);
                jalert("잘못된 접근입니다.");
                return false;
            }
            @endif
        @elseif(isset(session('auth')['user_type']) && session('auth')['user_type'] =='a')
            if (f.prefix_content.value == "") {
                fsubmit = false;
                $("#fsubmit").prop('disabled',false);
                jalert("내용을 입력해주세요.");
                return false;
            }
            if (f.this_month_education_info.value == "") {
                fsubmit = false;
                $("#fsubmit").prop('disabled',false);
                jalert("교육정보를 입력해주세요.");
                return false;
            }
        @endif

        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(event) {
                $('#loading').show();
            });
        });

        return true;
    }

    $('.btn_preview').on('click',function(){
        // modalShow('notePreview');
        getAdvicePreview();
    });

    function tmpSave() {
        let content = $('#content').val();
        let ymd = $('#ymd').val();
        let class_content = $('#class_content').val();
        let prefix_content = $('#prefix_content').val();
        let this_month_education_info = $('#this_month_education_info').val();

        let studentChk = $('input[name="student[]"]:checked');
        let student = [];
        if (studentChk.length > 0) {
            for (let i=0; i<studentChk.length; i++) {

                if ($(studentChk[i]).val()) student.push($(studentChk[i]).val());
            }
        }
        ycommon.setData('letter',{
            content: content,
            ymd: ymd,
            student: student,
            class_content: class_content,
            prefix_content: prefix_content,
            this_month_education_info: this_month_education_info,
        });
        jalert("임시저장 되었습니다.");
    }

    function setTmpSave() {
        // console.log("임시 저장 불러오기!!!");
        let tmpData = ycommon.getData('letter');
        if (tmpData.content !== undefined) $('#content').val(tmpData.content);
        if (tmpData.ymd !== undefined) $('#ymd').val(tmpData.ymd);
        if (tmpData.student !== undefined && tmpData.student.length !== undefined) {
            for (let i=0; i<tmpData.student.length; i++) {
                $('input[name="student[]"][value="'+tmpData.student[i]+'"]').prop("checked", true);
            }
        }
        if (tmpData.class_content !== undefined) $('#class_content').val(tmpData.class_content);
        if (tmpData.prefix_content !== undefined) $('#prefix_content').val(tmpData.prefix_content);
        if (tmpData.this_month_education_info !== undefined) $('#this_month_education_info').val(tmpData.this_month_education_info);

        // ycommon.deleteData('letter');
    }

    function getAdvicePreview() {
        let ymd = $('#ymd').val();
        let ymdText = ymd.replaceAll("-",".") + " " + ycommon.getYmdLable(ymd);
        let d = new Date(),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear(),
            H = '' + d.getHours(),
            i = '' + d.getMinutes();
        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
        if (H.length < 2) H = '0' + H;
        if (i.length < 2) i = '0' + i;
        let crDt = [year, month, day].join('.') + " " + [H, i].join(':');

        @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='m')
        let content = $('#content').val();
        let class_content = $('#class_content').val();
        $('#contentModal').text(content);
        $('#classContentModal').text(class_content);
        @elseif(isset(session('auth')['user_type']) && session('auth')['user_type'] =='a')
        let prefix_content = $('#prefix_content').val();
        let this_month_education_info = $('#this_month_education_info').val();
        $('#prefixContentModal').text(prefix_content);
        $('#thisMonthEducationInfoModal').text(this_month_education_info);
        @endif

        $('#subjectModal').text(month + "월 가정통신문");

        $('#ymdModal').text(ymdText);
        $('#crDt').text(crDt);
        $('#imageVideo').html();
        modalShow('letterPreview');
    }

    $(document).ready(function() {
        $("#chkStudentAll").on("click", function() {
            if($("#chkStudentAll").is(":checked")) $("input.chkStudent").prop("checked", true);
            else $("input.chkStudent").prop("checked", false);
        });

        @if($mode == 'w')
        let tmpData = ycommon.getData('letter');
        // 임시 저장 내용 있을 때 alert 띄워주기
        if (tmpData != null) {
            jalert2('임시 저장된 내용을 불러오시겠습니까?', '불러오기', setTmpSave);
        }
        @endif
    });

    document.querySelector('input[type="month"]').addEventListener('change', function(event) {
        const selectedDate = event.target.value; // 선택한 날짜 값
        const url = new URL(window.location.href);
        // const url = new URL(window.location.origin + window.location.pathname);

        url.searchParams.set('ym', selectedDate);

        window.location.href = url;
    });

    document.querySelectorAll('a').forEach(function(anchor) {
        anchor.addEventListener('click', function(event) {
            $('#loading').show();
        });
    });

    document.querySelectorAll('[onclick*="location.href"]').forEach(function(element) {
        element.addEventListener('click', function(event) {
            $('#loading').show();
        });
    });
</script>

@endsection

@extends('layout.home')
@section('bodyAttr')
class="body"
@endsection
@section('contents')
<?php
$title = "공지사항 작성";
$hd_bg = "3";
?>
@include('common.headm04')
@include('asobiNotice.preview')

<article class="sub_pg">
    <div class="container pt-4 pt_lg_50">
        <div class="d-none d-lg-flex align-items-center justify-content-between mb-4 mb-lg-5">
            <h1 class="tit_h1 ff_lotte fw_500">
                <?=$title?>
                <img src="/img/ic_tit.png" class="tit_img">
            </h1>
            <div class="d-flex">
                @if($mode == 'w')
                <button type="button" class="btn btn-md border border-primary text-primary px-5 mr-3" onclick="jalert2('임시저장을 하시겠습니까?', '임시저장', tmpSave);">임시저장</button>
                @endif
                <button type="button" class="btn btn-md border border-primary text-primary px-5" onclick="getAsobiNotePreview()">미리보기</button>
            </div>
        </div>

        <form name="asobiNoticeForm" id="asobiNoticeForm" class="mt-3" method="POST" action="/asobiNotice/writeAction" onsubmit="return frm_form_chk(this);">
            <input type="hidden" name="mode" value="{{ $mode }}">
            <input type="hidden" name="id" value="{{ $id }}">
            <div class="ip_wr mb-4">
                <div class="ip_tit">
                    <h5>구분</h5>
                </div>
                <div class="checks_wr">
                    <div class="checks">
                        <label>
                            <input type="checkbox" name="chk1" checked disabled>
                            <span class="ic_box"></span>
                            <div class="chk_p">
                                @if($type =='h')
                                <p>교육원</p>
                                @elseif($type =='a')
                                <p>교육원+지사장</p>
                                @endif
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="grid02_list">
                <div class="ip_wr">
                    <div class="ip_tit d-flex align-items-center justify-content-between">
                        <h5>제목</h5>
                        <button type="button" class="btn p-0 h-auto" onclick="boardCopy('title')"><img src="/img/ic_copy.png" style="width: 2rem;"></button>
                    </div>
                    <input type="text" name="title" id="title" value="{{ $noticeTitle }}" class="form-control" placeholder="제목을 입력해주세요.">
                </div>
                <div class="ip_wr">
                    <div class="ip_tit d-flex align-items-center justify-content-between">
                        <h5>작성일자</h5>
                    </div>
                    <input type="date" name="ymd" id="ymd" value="{{ $ymd }}" max="<?php echo date("Y-m-d") ?>" class="form-control text-dark_gray">
                </div>
            </div>

            <div class="ip_wr mt-4">
                <div class="ip_tit d-flex align-items-center justify-content-between">
                    <h5>내용</h5>
                    <button type="button" class="btn p-0 h-auto" onclick="boardCopy('content')"><img src="/img/ic_copy.png" style="width: 2rem;"></button>
                </div>
                <textarea id="content" name="content" class="form-control" placeholder="내용을 입력해주세요" rows="5">{{ $content }}</textarea>
            </div>

            <div class="cmt_wr note_btns pt-0 pt_lg_50 pb-0 pb-lg-4">
                <button type="submit" id="fsubmit" class="btn btn-primary">@if($mode == 'u')수정@else전송@endif</button>
                <button type="button" class="d-none d-lg-block btn btn-gray text-white" onclick="location.href='/asobiNotice'">목록</button>
                @if($mode == 'w')
                <button type="button" class="d-block d-lg-none btn btn-gray text-white" onclick="jalert2('임시저장을 하시겠습니까?', '임시저장', tmpSave);">임시저장</button>
                @endif
            </div>
        </form>
    </div>
</article>

<div class="loading_wrap" id="loading" style="display: none">
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

        if (f.title.value == "") {
            fsubmit = false;
            $("#fsubmit").prop('disabled',false);
            jalert("제목을 입력해주세요.");
            return false;
        }

        if (f.ymd.value == "") {
            fsubmit = false;
            $("#fsubmit").prop('disabled',false);
            jalert("작성일자를 입력해주세요.");
            return false;
        }

        if (ymdValue > currentDate) {
            fsubmit = false;
            $("#fsubmit").prop('disabled',false);
            jalert('미래 날짜는 선택할 수 없습니다.');
            return false;
        }

        if (f.content.value == "") {
            fsubmit = false;
            $("#fsubmit").prop('disabled',false);
            jalert("내용을 입력해주세요.");
            return false;
        }

        return true;
    }
    function tmpSave() {
        let title = $('#title').val();
        let content = $('#content').val();
        let ymd = $('#ymd').val();
        ycommon.setData('asobiNotice',{
            accountId: accountId,
            title: title,
            content: content,
            ymd: ymd,
        });
        jalert("임시저장 되었습니다.");
    }
    function getAsobiNotePreview() {
        let userType = '{{ session('auth')['user_type'] ?? "" }}';
        let title = $('#title').val();
        let content = $('#content').val();
        let ymd = $('#ymd').val();
        // console.log(userType, title, content, ymd);

        let userTypeText = "[지사공지]";
        if (userType == 'a') userTypeText = "[본사공지]";

        // 2023.04.01 월요일
        let ymdText = ymd.replaceAll("-",".") + " " + ycommon.getYmdLable(ymd);

        $('#userTypeModal').text(userTypeText);
        $('#titleModal').text(title);
        $('#contentModal').text(content);
        $('#ymdModal').text(ymdText);
        modalShow('noticePreview');
    }
    $('.btn_preview').on('click',function(){
        getAsobiNotePreview();
    });

    function setTmpSave() {
        // console.log("임시 저장 불러오기!!!");
        let tmpData = ycommon.getData('asobiNotice');
        if (tmpData.title !== undefined) $('#title').val(tmpData.title);
        if (tmpData.content !== undefined) $('#content').val(tmpData.content);
        if (tmpData.ymd !== undefined) $('#ymd').val(tmpData.ymd);
        // ycommon.deleteData('asobiNotice');
    }
    $(document).ready(function() {
        @if($mode == 'w')
        let tmpData = ycommon.getData('asobiNotice');
        // 임시 저장 내용 있을 때 alert 띄워주기
        if (tmpData != null) {
            if (tmpData.accountId == accountId) jalert2('임시 저장된 내용을 불러오시겠습니까?', '불러오기', setTmpSave);
        }
        @endif
    });

    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(event) {
            $('#loading').show();
        });
    });
</script>
</script>

@endsection

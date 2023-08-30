@extends('layout.home')
@section('bodyAttr')
class="body"
@endsection
@section('contents')
<?php
$n_menu = '4';
$title = "알림 설정";
$hd_bg = "8";
$tab_active = '1';
$back_link = "/app";
?>
@include('common.headm03')

<article class="sub_pg">
    <div class="container pt-5 pt_lg_50">
        <div class="d-none d-lg-block">
            <h1 class="tit_h1 ff_lotte fw_500 pb-5">
                앱관리
                <img src="/img/ic_tit.png" class="tit_img">
            </h1>
            <div class="tab_btn01">
                @include('common.tabs02')
            </div>
        </div>
        <ul class="grid02_list">
            <li class="d-flex align-items-center justify-content-between p-4 border rounded-lg">
                <p class="fw_700">알림장</p>
                <div class="toggle_wr py-2">
                    <input type="checkbox" id="toggle1" data-push="advice" {{$advice_alarm === 'Y' ? 'checked' : '' }}>
                    <label for="toggle1" class="toggle_switch">
                        <span class="toggle_btn"></span>
                    </label>
                </div>
            </li>
            <li class="d-flex align-items-center justify-content-between p-4 border rounded-lg">
                <p class="fw_700">앨범</p>
                <div class="toggle_wr py-2">
                    <input type="checkbox" id="toggle2" data-push="album" {{$album_alarm === 'Y' ? 'checked' : '' }}>
                    <label for="toggle2" class="toggle_switch">
                        <span class="toggle_btn"></span>
                    </label>
                </div>
            </li>
            <li class="d-flex align-items-center justify-content-between p-4 border rounded-lg">
                <p class="fw_700">출석부</p>
                <div class="toggle_wr py-2">
                    <input type="checkbox" id="toggle3" data-push="attendance" {{$attendance_alarm === 'Y' ? 'checked' : '' }}>
                    <label for="toggle3" class="toggle_switch">
                        <span class="toggle_btn"></span>
                    </label>
                </div>
            </li>
            <li class="d-flex align-items-center justify-content-between p-4 border rounded-lg">
                <p class="fw_700">공지사항</p>
                <div class="toggle_wr py-2">
                    <input type="checkbox" id="toggle4" data-push="notice" {{$notice_alarm === 'Y' ? 'checked' : '' }}>
                    <label for="toggle4" class="toggle_switch">
                        <span class="toggle_btn"></span>
                    </label>
                </div>
            </li>
            <li class="d-flex align-items-center justify-content-between p-4 border rounded-lg">
                <p class="fw_700">교육정보</p>
                <div class="toggle_wr py-2">
                    <input type="checkbox" id="toggle5" data-push="adu_info" {{$adu_info_alarm === 'Y' ? 'checked' : '' }}>
                    <label for="toggle5" class="toggle_switch">
                        <span class="toggle_btn"></span>
                    </label>
                </div>
            </li>
            <li class="d-flex align-items-center justify-content-between p-4 border rounded-lg">
                <p class="fw_700">이벤트</p>
                <div class="toggle_wr py-2">
                    <input type="checkbox" id="toggle6" data-push="event" {{$event_alarm === 'Y' ? 'checked' : '' }}>
                    <label for="toggle6" class="toggle_switch">
                        <span class="toggle_btn"></span>
                    </label>
                </div>
            </li>
        </ul>
    </div>
</article>


<script>
    $(window).on("load", function () {
        var push = '';
        var state = '';
        $('#toggle6,#toggle5,#toggle4,#toggle3,#toggle2,#toggle1').change(function (){
            push = $(this).data('push');
            if($(this).is(":checked")){
                state = 'Y';
            }else{
                state = 'N';
            }
            // 지사 선택
            let action = `/api/user/update/push/${push}`;
            let data = {user: userId ,device_id: deviceId, push:state};
            ycommon.ajaxJson('post', action, data, undefined, function (res) {
                // if (res.error !== undefined && res.error != "") jalert(res.error);
                console.log(res);
            });
        })
    });
</script>
@endsection

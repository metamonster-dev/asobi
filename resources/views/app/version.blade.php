@extends('layout.home')
@section('bodyAttr')
class="body"
@endsection
@section('contents')
<?php
$n_menu = '4';
$title = "앱 버전정보";
$hd_bg = "8";
$tab_active = '2';
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
        <div class="d-block d-lg-none logo mx-auto h-auto" style="max-width: 8rem;">
            <img src="/img/logo.svg">
        </div>
        <div class="bg-light_gray rounded-lg p-3 mt-5 mb-3">
            <div class="text-center p-3">
                <p class="fs_16 line_h1_2 fw_700 wh_pre mb-3">현재 버전
                V<span id="version"></span>(<span id="number"></span>)</p>
                <p class="fs_13 text-light">현재 사용 중인 아소비는 최신 버전입니다.</p>
                <div class="version_text">
                    <p class="fs_13">
                        (주)아소비교육 <br class="d-block d-lg-none" />
                        asobi.co.kr <br class="d-block d-lg-none" />
                        Tel : 1688-1993
                    </p>
                </div>
            </div>
        </div>
        <ul class="grid02_list pt-3">
            <li>
                <a href="javascript:;" class="d-flex align-items-center justify-content-between p-4 border rounded-lg" onclick="modalShow('terms')">
                    <p class="fw_700">서비스 이용약관</p>
                    <img src="/img/ic_arrow_right_b.png" class="py-2" style="max-width: 2rem;">
                </a>
            </li>
            <li>
                <a href="javascript:;" class="d-flex align-items-center justify-content-between p-4 border rounded-lg" onclick="modalShow('policy')">
                    <p class="fw_700">개인정보 처리방침</p>
                    <img src="/img/ic_arrow_right_b.png" class="py-2" style="max-width: 2rem;">
                </a>
            </li>
        </ul>
    </div>
</article>

<script>
    $(window).on("load", function () {

        document.addEventListener('message', (event) => {
            const data = JSON.parse(event.data);
            // alert('wqe',event.data);
            $('#version').html(data.appVersion);
            $('#number').html(data.buildNumber);
        });

        window.addEventListener('message', (event) => {
            if (event.origin !== undefined && event.origin == "https://player.vimeo.com") {
                return false;
            }
            const data = JSON.stringify(event.data);
            // alert(data);
            $('#version').html(data.appVersion);
            $('#number').html(data.buildNumber);
            // let Total = parseInt(data.appDirectorySize);
            // TmpFileSize(Total);
        });
        // if(device_type === 'web'){
        //     location.href='/';
        //     return false;
        // }
        // 지사 선택
        // let action = '/api/version/'+device_type;
        // let data = '';
        // ycommon.ajaxJson('get', action, data, undefined, function (data) {
        //     console.log(data.count)
        //     if (data.message == '성공') {
        //        $('#version').html(data.data.list.version);
        //     }
        // });
    })
</script>
@endsection

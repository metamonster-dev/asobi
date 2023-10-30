@extends('layout.home')
@section('bodyAttr')
class="body"
@endsection
@section('contents')
<?php
$n_menu = '4';
$title = "저장 공간 관리";
$hd_bg = "8";
$tab_active = '3';
$back_link = "/app";
?>
@include('common.headm03')

<article class="sub_pg">
    <div class="container pt-5 pt_lg_50">
        <div class="d-none d-lg-block">
            <h1 class="tit_h1 ff_lotte fw_500 pb-5">
                @if(isset(session('auth')['device_kind']) && session('auth')['device_kind'] != 'web')
                앱관리
                @endif
                저장공간관리
                <img src="/img/ic_tit.png" class="tit_img">
            </h1>
{{--            <div class="tab_btn01">--}}
{{--                @include('common.tabs02')--}}
{{--            </div>--}}
        </div>
        <div>
            <p class="mb-2 pb-4">
                <span class="fw_700">저장된 캐시 데이터</span>
                <br class="d-block d-lg-none" />
                <span class="d-block d-lg-inline-block fs_13 text-light pt-2 pt-lg-0 px-0 px-lg-1"><span id="data"></span> 사용 중</span>
            </p>
            <div class="rounded-lg bg-light_gray p-3">
                <p class="p-3 wh_pre text-light fs_13 line_h1_2">앱에 임시 저장된 캐시 데이터를 삭제하고 정리해 줍니다.
                알림장, 공지사항, 앨범 등 아소비에 업로드된 사진, 동영상, 문서 파일은 그대로 유지됩니다.</p>
            </div>
        </div>
        <div class="py-5 mt-3 mw-450">
            <button type="button" id="cache_btn" class="btn btn-primary btn-block" onclick="FileSizeDelete()">캐시 데이터 삭제</button>
        </div>
    </div>
</article>

<script>
    let size = 0;
    let total = 0;
    function TmpFileSize(Total) {
        console.log('1',Total);
        if(Total === undefined){
            total = 0;
        }else {
            total = Total;
        }
        if(ycommon.getData('asobiNotice') !== null){
            size = size + 1024;
        }
        if(ycommon.getData('advice') !== null){
            size = size + 1024;
        }
        if(ycommon.getData('letter') !== null){
            size = size + 1024;
        }
        if(ycommon.getData('album') !== null){
            size = size + 1024;
        }
        if(ycommon.getData('notice') !== null){
            size = size + 1024;
        }
        let action = '/api/tmpFileSize';
        let data = {user: '{{ session('auth')['user_id'] }}'};
        ycommon.ajaxJson('get', action, data, undefined, function (data) {
            let num2 = '';
            let pullsize = parseInt(data.sum) + size + total;
            console.log('2',pullsize);
            var regexp = /\B(?=(\d{3})+(?!\d))/g;
            let num = 0;
            let name = '';
            if (pullsize >= 1073741824) {
                num2 = pullsize / 1073741824;
                name = 'GB';
            } else if (pullsize >= 1048576) {
                num2 = pullsize / 1048576;
                name = 'MB';
            } else if (pullsize >= 1024) {
                num2 = pullsize / 1024;
                name = 'KB';
            } else {
                num2 = pullsize;
                name = 'bytes';
            }
            // console.log(Math.ceil(data));
            num = Math.ceil(num2).toString().replace(regexp, ',');

          $('#data').text(num + ' '+name);
          console.log('num',num);
        })
    }

    function FileSizeDelete() {
        let Total = 0;

        let action = '/api/tmpFileDelete';
        let data = {user: '{{ session('auth')['user_id'] }}', type: 'all'};
        ycommon.ajaxJson('post', action, data, undefined, function (data) {
            ycommon.clearData();
            if (typeof window.ReactNativeWebView !== 'undefined') {
                window.ReactNativeWebView.postMessage(
                    JSON.stringify({targetFunc: "storage"})
                );
            }
            TmpFileSize(Total);
            // console.log(data);
        })
    }

    $(window).on("load", function () {
        TmpFileSize();

        document.addEventListener('message', (event) => {
            const data = JSON.parse(event.data);
            // alert('wqe',event.data);
            let Total = parseInt(data.appDirectorySize);
            TmpFileSize(Total);
        });

        window.addEventListener('message', (event) => {
            if (event.origin !== undefined && event.origin == "https://player.vimeo.com") {
                return false;
            }
            const data = JSON.stringify(event.data);
            // alert(data);
            let Total = parseInt(data.appDirectorySize);
            TmpFileSize(Total);
        });
    })
</script>

@endsection

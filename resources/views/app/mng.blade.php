@extends('layout.home')
@section('bodyAttr')
class="body"
@endsection
@section('contents')
<?php
$title = "앱관리";
$hd_bg = "8";
$back_link = "/student";
?>
@include('common.headm02')

<article class="sub_pg">
    <div class="container pt-3 pb-5">
        <div class="py-3">
            <ul>
                <li class="mb-4">
                    <a href="/app/alarm" class="d-flex align-items-center justify-content-between p-4 border rounded-lg">
                        <p class="fw_700">알림설정</p>
                        <img src="/img/ic_arrow_right_b.png" class="py-2" style="max-width: 2rem;">
                    </a>
                </li>
                <li class="mb-4">
                    <a href="/app/photo" class="d-flex align-items-center justify-content-between p-4 border rounded-lg">
                        <p class="fw_700">사진/동영상 설정</p>
                        <img src="/img/ic_arrow_right_b.png" class="py-2" style="max-width: 2rem;">
                    </a>
                </li>
                <li class="mb-4">
                    <a href="/app/version" class="d-flex align-items-center justify-content-between p-4 border rounded-lg">
                        <p class="fw_700">앱 버전 정보</p>
                        <img src="/img/ic_arrow_right_b.png" class="py-2" style="max-width: 2rem;">
                    </a>
                </li>
                <li class="">
                    <a href="/app/storage" class="d-flex align-items-center justify-content-between p-4 border rounded-lg">
                        <p class="fw_700">저장 공간 관리</p>
                        <img src="/img/ic_arrow_right_b.png" class="py-2" style="max-width: 2rem;">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</article>

@endsection
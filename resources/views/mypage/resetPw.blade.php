@extends('layout.home')
@section('bodyAttr')
class="body"
@endsection
@section('contents')
<?php
$n_menu = "2";
$title = "비밀번호 변경";
$hd_bg = "8";
$back_link = "/mypage";
?>
@include('common.headm03')

<article class="sub_pg">
    <div class="container container-372 pt-5 pt_lg_50">
        <div class="mb-5 rounded-lg bg-primary_bg p-3">
            <p class="fs_14 p-3 line_h1_5 wh_pre">비밀번호는 4자리 이상의 숫자 또는
            문자이면 등록 가능합니다.</p>
        </div>
        <div>
            @include('mypage.newPw')
        </div>
    </div>
</article>

<script>
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

    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(event) {
            $('#loading').show();
        });
    });
</script>

@endsection

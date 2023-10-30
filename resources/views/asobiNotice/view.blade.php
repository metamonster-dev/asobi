@extends('layout.home')
@section('bodyAttr')
class="body"
@endsection
@section('contents')
<?php
$title = "공지사항 상세";
$hd_bg = "3";
//$back_link = '/asobiNotice';
$back_link = $_SERVER['HTTP_REFERER'];
?>
@include('common.headm03')

<article class="sub_pg">
    <div class="container pt-4 pt_lg_50">
        <div class="pb-4 mb-3 mb-lg-0 border-bottom d-flex align-items-center justify-content-between">
            <div>
                <p class="text-dark_gray fs_13 fw_300 mb-2 line_h1_2">
                    <span class="d-inline-block d-lg-none text-primary fw_500 mr-2">[{{ $row['type'] }}공지]</span> {{ $row['date2'] }}
                </p>
                <h4 class="tit_h4 line1_text line_h1">
                <span class="d-none d-lg-inline-block text-primary mr-2">[{{ $row['type'] }}공지]</span> {{ $row['title'] }}
                </h4>
            </div>
            @if(isset(session('auth')['user_type']) && (session('auth')['user_type'] =='h' || session('auth')['user_type'] =='a') && ($modifyBtn || $deleteBtn))
            <!--  ※ 수정, 삭제 버튼은 지사, 본사일 때 노출 -->
            <div class="position-relative d-block d-lg-none">
                <button type="button" class="btn p-0 btn_more h-auto"><img src="/img/ic_more.png" style="width: 1.6rem;"></button>
                <ul class="more_cont">
                    @if($modifyBtn)
                    <li><button class="btn" onclick="location.href='/asobiNotice/write/{{ $row['id'] }}'">수정</button></li>
                    @endif
                    @if($deleteBtn)
                    <li><button class="btn" onclick="jalert2('삭제하시겠습니까?','삭제하기',function(){location.href='/asobiNotice/delete/{{ $row['id'] }}';})">삭제</button></li>
                    @endif
                </ul>
            </div>
            @endif
        </div>

        <div class="pt-3 pt-lg-5 px-0 px-lg-5">
            <p class="wh_pre fs_15 line_h1_4">{!! $row['content'] !!}</p>
        </div>

        <!--  ※ 수정, 삭제 버튼은 지사, 본사일 때 노출 -->
        <div class="botton_btns d-none d-lg-flex pt_80">
            @if(isset(session('auth')['user_type']) && (session('auth')['user_type'] =='h' || session('auth')['user_type'] =='a'))
                @if($modifyBtn)
                <button type="button" class="btn btn-primary" onclick="location.href='/asobiNotice/write/{{ $row['id'] }}'">수정</button>
                @endif
                <button type="button" class="btn btn-gray text-white" onclick="location.href='{{ $back_link }}'">목록</button>
                @if($deleteBtn)
                <button type="button" class="btn btn-gray text-white" onclick="jalert2('삭제하시겠습니까?','삭제하기',function(){location.href='/asobiNotice/delete/{{ $row['id'] }}';})">삭제</button>
                @endif
            @else
            <button type="button" class="btn btn-gray text-white" onclick="location.href='{{ $back_link }}'">목록</button>
            @endif
        </div>
    </div>
</article>

<div class="loading_wrap" id="loading" style="display: none">
    <div class="loading_text">
        <i class="loading_circle"></i>
        <span>로딩중</span>
    </div>
</div>

<script>
    // document.querySelectorAll('a').forEach(function(anchor) {
    //     anchor.addEventListener('click', function(event) {
    //         $('#loading').show();
    //     });
    // });
    //
    // document.querySelectorAll('[onclick*="location.href"]').forEach(function(element) {
    //     element.addEventListener('click', function(event) {
    //         $('#loading').show();
    //     });
    // });
</script>

@endsection

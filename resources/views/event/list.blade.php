@extends('layout.home')
@section('bodyAttr')
class="body"
@endsection
@section('contents')
<?php
$title = "아소비 이벤트";
$hd_bg = "6";
$back_link = "/";
?>
@include('common.headm02')

<style>
    @media (min-width: 540px) and (max-width: 992px) {
        .container-md, .container-sm, .container {
            max-width: 540px !important;
        }
    }
</style>

<article class="sub_pg overflow-hidden">
    <div class="container pt-4 pt_lg_50">
        <div class="d-none d-lg-block">
            @include('common.tabs')
        </div>

        <div class="d-none d-lg-flex align-items-center justify-content-between mb-4 mb-lg-5">
            <h1 class="tit_h1 ff_lotte fw_500">
                <?=$title?>
                <img src="/img/ic_tit.png" class="tit_img">
            </h1>
            @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='a')
            <!-- ※ 작성하기 버튼은 본사일 때만 노출 -->
            <button type="button" class="btn btn-md btn-primary ml-4 px-5" onclick="location.href='/event/write'">작성하기</button>
            @endif
        </div>

        <div class="mt-3 mt-lg-0">
            @if(count($list) > 0)
            <ul class="event_list row row-cols-1 row-cols-lg-2 row-cols-lg-3">
                @foreach($list as $l)
                    <li class="col">
                        <a href="/event/view/{{ $l['id'] }}">
                            <div class="rect rect4 rounded-lg sizefull img_height">
                                @if(isset($l['image']) && $l['image'])
                                <img src="{{ $l['image'] }}" style="object-fit: contain">
                                @else
                                <i class="no_img"></i>
                                @endif
                            </div>
                            <div class="d-flex align-items-center mt-3">
                                <span class="ev_stat
                                    @if(isset($l['status_text']) && $l['status_text'] == '진행중') ev_1 @else ev_2 @endif">
                                    {{ $l['status_text'] ?? '' }}
                                </span>
                                <p class="fs_15 ml-3">{{ $l['date_range'] ?? '' }}</p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
            @else
            <div class="nodata">
                <p>조회된 이벤트가 없습니다.</p>
            </div>
            @endif
        </div>

        <!-- <ul class="pagination mt-lg-5">
            <li class=""><a href="#" class="page_btn prev"><img src="/img/ic_arrow_left_gr.png"></a></li>
            <li class=""><a href="#" class="on">1</a></li>
            <li class=""><a href="#">2</a></li>
            <li class=""><a href="#">3</a></li>
            <li class=""><a href="#">4</a></li>
            <li class=""><a href="#">5</a></li>
            <li class=""><a href="#" class="page_btn next"><img src="/img/ic_arrow_right_gr.png"></a></li>
        </ul> -->

        @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='a')
        <!-- 모바일 작성 버튼 -->
        <!-- ※ 작성하기 버튼은 본사일 때만 노출 -->
        <div class="f_btn_wr d-block d-lg-none">
            <button type="button" class="btn float_btn" onclick="location.href='/event/write'"><img src="/img/ic_write.png" style="width: 3rem;"></button>
        </div>
        @endif
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

    document.querySelector('.back_button').addEventListener('click', function(event) {
        $('#loading').show();
    });
</script>

@endsection

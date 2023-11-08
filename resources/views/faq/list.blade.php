@extends('layout.home')
@section('bodyAttr')
class="body"
@endsection
@section('contents')
<?php
$n_menu = '5';
$title = "FAQ";
$hd_bg = "8";
$back_link = "/student";
?>
@include('common.headm03')

<article class="sub_pg">
    <div class="container pt-5 pt_lg_50">
        <form action="">
            <div class="faq_search">
                <h1 class="tit_h1 ff_lotte fw_500 pb-3">
                    <span class="d-none d-lg-inline-block">원장님이</span> 자주하는 질문
                    <img src="./img/ic_tit.png" class="tit_img">
                </h1>
                <div class="m_top pt-3">
                    <div class="input-group">
                        <div class="ip_sch_wr col-12 px-0">
                            <input type="search" name="searchText" value="{{ $searchText }}" class="form-control form-control-lg" placeholder="검색">
                            <button type="submit" class="btn btn_sch"></button>
                        </div>
                    </div>
                    <div class="m_top_ico d-block d-lg-none">
                        <img src="./img/faq_top.png">
                    </div>
                </div>
            </div>
        </form>
        <!-- <div class="accordion faq_acc" id="faq_1">
            <div class="card">
                <div class="card-header" id="faq_q1">
                    <button type="button" class="faq_btn" data-toggle="collapse" data-target="#faq_a1" aria-expanded="true" aria-controls="faq_a1">
                        <p class="fs_16 fw_700"><span class="fs_20 mr-3 align-bottom">Q.</span>자주하는 질문</p>
                        <img src="./img/ic_arrow_down_b.png" class="acc_down">
                    </button>
                </div>
                <div class="collapse show" id="faq_a1" aria-labelledby="faq_q1" data-parent="#faq_1">
                    <div class="card-body">
                        <div class="d-flex align-items-start line_h1_5">
                            <p class="fs_20 fw_700 mr-4 text-primary">A.</p>
                            <p class="fs_15">자주하는 FAQ 질문에 대한 답변내용이 들어갑니다.
                            자주하는 FAQ 질문에 대한 답변내용이 들어갑니다.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        @if(count($list) > 0)
            @foreach($list as $k => $l)
                <div class="accordion faq_acc" id="faq_{{$k}}">
                    <div class="card">
                        <div class="card-header" id="faq_q{{$k}}">
                            <button type="button" class="faq_btn collapsed" data-toggle="collapse" data-target="#faq_a{{$k}}" aria-expanded="true" aria-controls="faq_a1">
                                <div class="d-flex align-items-start line_h1_5">
                                    <p class="fs_20 fw_700 mr-3 align-bottom">Q.</p>
                                    <p class="fs_16 fw_700 text-left">{{$l['title']}}</p>
                                </div>
                                <img src="./img/ic_arrow_down_b.png" class="acc_down">
                            </button>
                        </div>
                        <div class="collapse" id="faq_a{{$k}}" aria-labelledby="faq_q{{$k}}" data-parent="#faq_{{$k}}">
                            <div class="card-body">
                                <div class="d-flex align-items-start line_h1_5">
                                    <p class="fs_20 fw_700 mr-4 text-primary">A.</p>
                                    <p class="fs_15">
                                        {{--{!! $l['content'] !!}--}}
                                        {!! strip_tags($l['content'] ?? '') !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="nodata">
                <p>조회된 질문이 없습니다.</p>
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

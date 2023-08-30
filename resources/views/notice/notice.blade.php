@extends('layout.home')
@section('bodyAttr')
class="body"
@endsection
@section('contents')
<?php
// ※ 학부모일 때, 공지사항 / 나머지, 학부모 공지
// $title = "학부모 공지";
?>
@php
    if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='s') $title = "공지사항";
    else $title = "학부모 공지";
@endphp
@include('common.headm06')

<article class="sub_pg sub_bg sub_bg3">
    <div class="container pt-4 pt_md_50">
        <div class="d-none d-md-block">
            @include('common.tabs')
        </div>

        <div class="mb-4 mb-md-5">
            <div class="d-block d-lg-flex align-items-center justify-content-between">
                <h1 class="d-none d-md-block tit_h1 ff_lotte fw_500">
                    <?=$title?>
                    <img src="/img/ic_tit.png" class="tit_img">
                </h1>
                <form action="" class="notice_form">
                    <div class="d-block d-md-flex mt-0 mt-md-3 mt-lg-0 w-100">
                        <div class="ip_sch_wr d-none d-md-block mr-4 col-4 px-0">
                            <input type="search" class="form-control form-control-lg ip_search">
                            <button type="submit" class="btn btn_sch btn_sch2"></button>
                        </div>
                        <div class="m_top mb-0">
                            <div class="input-group">
                                <input type="date" class="form-control form-control-lg">
                                <div class="gr_r col-6 px-0">
                                    <select name="" id="" class="form-control bg-white custom-select m_select d-none d-md-block">
                                        <option value="">전체</option>
                                        <option value="">교육원</option>
                                        <option value="">본사</option>
                                    </select>
                                    <div class="ip_sch_wr d-block d-md-none">
                                        <input type="search" class="form-control ip_search">
                                        <button type="submit" class="btn btn_sch btn_sch2"></button>
                                    </div>
                                </div>
                            </div>
                            <div class="m_top_ico d-block d-md-none">
                                <img src="/img/m3_top.png">
                            </div>
                        </div>
                        @if(isset(session('auth')['user_type']) && (session('auth')['user_type'] =='m' || session('auth')['user_type'] =='a'))
                        <!-- ※ 작성하기 버튼은 교육원, 본사일 때만 노출 -->
                        <button type="button" class="d-none d-md-block btn btn-md btn-primary ml-4 px-5" onclick="location.href='/notice/parents/write'">작성하기</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- ※ 교육원, 본사 공지만 노출!! -->
        <ul class="note_list grid01_list pb-5">
            <li>
                <a href="/notice/parents/view">
                    <p class="text-dark_gray fs_13 fw_300 mb-3"><span class="text-primary fw_500 mr-2">[본사공지]</span> 2023.04.01 월요일</p>
                    <h4 class="tit_h4 mb-3">공지사항 제목 입니다.</h4>
                    <p class="line2_text line_h1_4">공지사항 내용입니다. 두 줄까지 노출 공지사항 내용입니다. 두 줄까지 노출</p>
                </a>
            </li>
            <li>
                <a href="/notice/parents/view">
                    <p class="text-dark_gray fs_13 fw_300 mb-3"><span class="text-primary fw_500 mr-2">[교육원공지]</span> 2023.04.01 월요일</p>
                    <h4 class="tit_h4 mb-3">공지사항 제목 입니다.</h4>
                    <p class="line2_text line_h1_4">공지사항 내용입니다. 두 줄까지 노출 공지사항 내용입니다. 두 줄까지 노출</p>
                    <div class="note_img_list advice_slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="rect rect2">
                                    <img src="/img/sample_img3.jpg">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="rect rect2">
                                    <img src="/img/sample_img3.jpg">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="rect rect2">
                                    <img src="/img/sample_img3.jpg">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="rect rect2">
                                    <img src="/img/sample_img3.jpg">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            <li>
                <a href="/notice/parents/view">
                    <p class="text-dark_gray fs_13 fw_300 mb-3"><span class="text-primary fw_500 mr-2">[본사공지]</span> 2023.04.01 월요일</p>
                    <h4 class="tit_h4 mb-3">공지사항 제목 입니다.</h4>
                    <p class="line2_text line_h1_4">공지사항 내용입니다. 두 줄까지 노출 공지사항 내용입니다. 두 줄까지 노출</p>
                </a>
            </li>
            <li>
                <a href="/notice/parents/view">
                    <p class="text-dark_gray fs_13 fw_300 mb-3"><span class="text-primary fw_500 mr-2">[교육원공지]</span> 2023.04.01 월요일</p>
                    <h4 class="tit_h4 mb-3">공지사항 제목 입니다.</h4>
                    <p class="line2_text line_h1_4">공지사항 내용입니다. 두 줄까지 노출 공지사항 내용입니다. 두 줄까지 노출</p>
                    <div class="note_img_list advice_slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="rect rect2">
                                    <img src="/img/sample_img3.jpg">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="rect rect2">
                                    <img src="/img/sample_img3.jpg">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="rect rect2">
                                    <img src="/img/sample_img3.jpg">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="rect rect2">
                                    <img src="/img/sample_img3.jpg">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            <li>
                <a href="/notice/parents/view">
                    <p class="text-dark_gray fs_13 fw_300 mb-3"><span class="text-primary fw_500 mr-2">[본사공지]</span> 2023.04.01 월요일</p>
                    <h4 class="tit_h4 mb-3">공지사항 제목 입니다.</h4>
                    <p class="line2_text line_h1_4">공지사항 내용입니다. 두 줄까지 노출 공지사항 내용입니다. 두 줄까지 노출</p>
                </a>
            </li>
            <li>
                <a href="/notice/parents/view">
                    <p class="text-dark_gray fs_13 fw_300 mb-3"><span class="text-primary fw_500 mr-2">[교육원공지]</span> 2023.04.01 월요일</p>
                    <h4 class="tit_h4 mb-3">공지사항 제목 입니다.</h4>
                    <p class="line2_text line_h1_4">공지사항 내용입니다. 두 줄까지 노출 공지사항 내용입니다. 두 줄까지 노출</p>
                    <div class="note_img_list advice_slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="rect rect2">
                                    <img src="/img/sample_img3.jpg">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="rect rect2">
                                    <img src="/img/sample_img3.jpg">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="rect rect2">
                                    <img src="/img/sample_img3.jpg">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="rect rect2">
                                    <img src="/img/sample_img3.jpg">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            <li>
                <a href="/notice/parents/view">
                    <p class="text-dark_gray fs_13 fw_300 mb-3"><span class="text-primary fw_500 mr-2">[본사공지]</span> 2023.04.01 월요일</p>
                    <h4 class="tit_h4 mb-3">공지사항 제목 입니다.</h4>
                    <p class="line2_text line_h1_4">공지사항 내용입니다. 두 줄까지 노출 공지사항 내용입니다. 두 줄까지 노출</p>
                </a>
            </li>
            <li>
                <a href="/notice/parents/view">
                    <p class="text-dark_gray fs_13 fw_300 mb-3"><span class="text-primary fw_500 mr-2">[교육원공지]</span> 2023.04.01 월요일</p>
                    <h4 class="tit_h4 mb-3">공지사항 제목 입니다.</h4>
                    <p class="line2_text line_h1_4">공지사항 내용입니다. 두 줄까지 노출 공지사항 내용입니다. 두 줄까지 노출</p>
                    <div class="note_img_list advice_slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="rect rect2">
                                    <img src="/img/sample_img3.jpg">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="rect rect2">
                                    <img src="/img/sample_img3.jpg">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="rect rect2">
                                    <img src="/img/sample_img3.jpg">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="rect rect2">
                                    <img src="/img/sample_img3.jpg">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            <li>
                <a href="/notice/parents/view">
                    <p class="text-dark_gray fs_13 fw_300 mb-3"><span class="text-primary fw_500 mr-2">[본사공지]</span> 2023.04.01 월요일</p>
                    <h4 class="tit_h4 mb-3">공지사항 제목 입니다.</h4>
                    <p class="line2_text line_h1_4">공지사항 내용입니다. 두 줄까지 노출 공지사항 내용입니다. 두 줄까지 노출</p>
                </a>
            </li>
            <li>
                <a href="/notice/parents/view">
                    <p class="text-dark_gray fs_13 fw_300 mb-3"><span class="text-primary fw_500 mr-2">[교육원공지]</span> 2023.04.01 월요일</p>
                    <h4 class="tit_h4 mb-3">공지사항 제목 입니다.</h4>
                    <p class="line2_text line_h1_4">공지사항 내용입니다. 두 줄까지 노출 공지사항 내용입니다. 두 줄까지 노출</p>
                    <div class="note_img_list advice_slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="rect rect2">
                                    <img src="/img/sample_img3.jpg">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="rect rect2">
                                    <img src="/img/sample_img3.jpg">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="rect rect2">
                                    <img src="/img/sample_img3.jpg">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="rect rect2">
                                    <img src="/img/sample_img3.jpg">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
        </ul>

        <ul class="pagination">
            <li class=""><a href="#" class="page_btn prev"><img src="/img/ic_arrow_left_gr.png"></a></li>
            <li class=""><a href="#" class="on">1</a></li>
            <li class=""><a href="#">2</a></li>
            <li class=""><a href="#">3</a></li>
            <li class=""><a href="#">4</a></li>
            <li class=""><a href="#">5</a></li>
            <li class=""><a href="#" class="page_btn next"><img src="/img/ic_arrow_right_gr.png"></a></li>
        </ul>

        @if(isset(session('auth')['user_type']) && (session('auth')['user_type'] =='m' || session('auth')['user_type'] =='a'))
        <!-- 모바일 작성 버튼 -->
        <!-- ※ 작성하기 버튼은 교육원, 본사일 때만 노출 -->
        <div class="f_btn_wr d-block d-md-none">
            <button type="button" class="btn float_btn" onclick="location.href='/notice/parents/write'"><img src="/img/ic_write.png" style="width: 3rem;"></button>
        </div>
        @endif

    </div>
</article>

@endsection

@extends('layout.home')
@section('bodyAttr')
class="body"
@endsection
@section('contents')
<?php
$title = "가정통신문 상세";
$hd_bg = "1";
?>
@php
    $date = substr($row['date2'],0,7);
    if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='s') {
        $back_link = '/advice/list?ym='.$date;
    } else {
        $back_link = '/advice?ym='.$date.'&search_user_id='.$row['student'].'&search_text='.$row['student_name'];
    }
@endphp
@include('common.headm03')

<article class="sub_pg">
    <div class="container pt-4 pt_lg_50">
        <div class="d-none d-lg-block">
            @include('common.tabs')
        </div>
        <div class="pb-4 mb-3 border-bottom d-flex align-items-center justify-content-between">
            <div>
                <p class="text-dark_gray mb-3 fs_14 fw_300">{{ $row['date'] ?? '' }}</p>
                <h4 class="tit_h4 line1_text line_h1">{{ $row['title'] ?? '' }}</h4>
                @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='m')
                <!-- ※ 읽음여부는 교육원일 때만 노출 -->
                <p class="fs_14 fw_300 text-dark_gray mt-3 fs_14 fw_300">
                    읽음여부
                    <span class="ml-3">
                        @if(isset($row['readed']) && $row['readed'] == 'Y')
                        O
                        @else
                        X
                        @endif
                    </span>
                </p>
                @endif
            </div>
            @if(isset(session('auth')['user_type']) && (session('auth')['user_type'] =='m' || session('auth')['user_type'] =='a'))
            <!-- ※ 공유 버튼은 교육원일 때만 노출 -->
            <!-- ※ 삭제 버튼은 교육원, 본사일 때 노출 -->
                @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='m')
                <button class="btn p-0 d-none d-lg-block" onclick="UrlCopy()"><img src="/img/ic_share.png"></button>
                @endif
                <div class="position-relative d-block d-lg-none">
                    <button type="button" class="btn p-0 btn_more h-auto"><img src="/img/ic_more.png" style="width: 1.6rem;"></button>
                    <ul class="more_cont">
                        @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='m')
                        <li><button class="btn" onclick="UrlCopy()">공유</button></li>
                        <li><button class="btn" onclick="location.href='/advice/letter/write/{{ $id }}'">수정</button></li>
                        @endif
                        <li><button class="btn" onclick="jalert2('삭제하시겠습니까?','삭제하기',function(){location.href='/advice/delete/{{ $id }}';})">삭제</button></li>
                    </ul>
                </div>
            @endif
        </div>
        <div class="letter_wrap pt-3 pt-lg-5 px-0 px-lg-5">
            @if(isset($row['content']) || isset($row['prefix_content']))
            <div class="letter_box letter_box1">
                <div class="rounded-pill py-4 text-center position-relative">
                    <p class="fs_16 fw_700 text-white">아소비 교육원 알림</p>
                    <div class="lt_ico">
                        <img src="/img/m1_tit1.png">
                    </div>
                </div>
                <div class="fs_15 line_h1_4">
                    @if(isset($row['content']) && $row['content'])
                    <div class="wh_pre">{!! nl2br($row['content']) !!}</div>
                    @endif
                    @if(isset($row['content']) && $row['content'] && isset($row['prefix_content']) && $row['prefix_content'])
                    <br/>
                    @endif
                    @if(isset($row['prefix_content']) && $row['prefix_content'])
                    <div class="wh_pre">{!! nl2br($row['prefix_content']) !!}</div>
                    @endif
                </div>
            </div>
            @endif
            @if(isset($row['this_month']) && isset($row['this_schedule']) && count($row['this_schedule']) > 0)
            <div class="letter2_box">
                <p class="fs_16 fw_500 text-primary">{{ $row['this_month'] }}월 학습진도</p>
                <div class="text_box mt-3">
                    <div class="fs_15 line_h1_4">
                        @foreach($row['this_schedule'] as $l)
                        {{ $l['name'] }} <br/>
                        <!-- {!! nl2br($l['content']) !!} -->
                        @endforeach
                    </div>
                </div>
                </div>
            @endif
            @if(isset($row['next_month']) && isset($row['next_schedule']) && count($row['next_schedule']) > 0)
            <div class="letter2_box">
                <p class="fs_16 fw_500 text-primary">{{ $row['next_month'] }}월 학습진도</p>
                <div class="text_box mt-3">
                    <div class="fs_15 line_h1_4">
                        @foreach($row['next_schedule'] as $l)
                        {{ $l['name'] }} <br/>
                        <!-- {!! nl2br($l['content']) !!} -->
                        @endforeach
                    </div>
                </div>
                </div>
            @endif
            @if((isset($row['class_content']) && $row['class_content']) || (isset($row['this_month']) && isset($row['this_schedule']) && count($row['this_schedule']) > 0))
            <div class="letter_box letter_box2">
                <div class="rounded-pill py-4 text-center position-relative">
                    <p class="fs_16 fw_700 text-white">이번달 수업에서는</p>
                    <div class="lt_ico">
                        <img src="/img/m1_tit1.png">
                    </div>
                </div>
                <div class="d-flex flex-column gap_15">
                    @if(isset($row['class_content']) && $row['class_content'])
                    <div class="fs_15 line_h1_4">{!! nl2br($row['class_content']) !!}</div>
                    @endif
                    @if(isset($row['this_month']) && isset($row['this_schedule']) && count($row['this_schedule']) > 0)
                        @foreach($row['this_schedule'] as $l)
                        <div class="fs_14 line_h1_4">
                            <b>{{ $l['name'] }}</b><br/>
                            {!! nl2br($l['content']) !!}
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
            @endif
            @if(false)
            @if(isset($row['next_month']) && isset($row['next_schedule']) && count($row['next_schedule']) > 0)
            <div class="letter_box letter_box2">
                <div class="rounded-pill py-4 text-center position-relative">
                    <p class="fs_16 fw_700 text-white">다음달 수업에서는</p>
                    <div class="lt_ico">
                        <img src="/img/m1_tit1.png">
                    </div>
                </div>
                <div class="d-flex flex-column gap_15">
                    @if(isset($row['this_month']) && isset($row['next_schedule']) && count($row['next_schedule']) > 0)
                        @foreach($row['next_schedule'] as $l)
                        <div class="fs_14 line_h1_4">
                            <b>{{ $l['name'] }}</b><br/>
                            {!! nl2br($l['content']) !!}
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
            @endif
            @endif
            @if(isset($row['this_month_education_info']) && $row['this_month_education_info'])
            <div class="letter_box letter_box3">
                <div class="rounded-pill py-4 text-center position-relative">
                    <p class="fs_16 fw_700 text-white">교육정보</p>
                    <div class="lt_ico">
                        <img src="/img/m1_tit1.png">
                    </div>
                </div>
                <div class="fs_15 wh_pre line_h1_4">{!! nl2br($row['this_month_education_info']) !!}</div>
            </div>
            @endif
        </div>
        <!-- ※ 삭제 버튼은 교육원, 본사일 때 노출 -->
        <div class="botton_btns d-none d-lg-flex pt_80">
            @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='m')
            <button type="button" class="btn btn-primary" onclick="location.href='/advice/letter/write/{{ $id }}'">수정</button>
            @endif
            <button type="button" class="btn btn-gray text-white" onclick="location.href='@if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='s') /advice/list @else /advice @endif'">목록</button>
            @if(isset(session('auth')['user_type']) && (session('auth')['user_type'] =='m' || session('auth')['user_type'] =='a'))
            <button type="button" class="btn btn-gray text-white" onclick="jalert2('삭제하시겠습니까?','삭제하기',function(){location.href='/advice/delete/{{ $id }}';})">삭제</button>
            @endif
        </div>
    </div>
</article>

<script>
    function UrlCopy(){
        var url = window.location.href;
        if (typeof window.ReactNativeWebView !== 'undefined') {
            window.ReactNativeWebView.postMessage(
                JSON.stringify({targetFunc: "copy",url: url})
            );
        }else {
            var tempInput = $('<input>');
            tempInput.css({
                position: 'absolute',
                left: '-9999px', // 화면 영역 밖으로 이동
            });
            $('body').append(tempInput);
            let action = `/api/share?link=${url}`;
            let data = '';
            ycommon.ajaxJson('get', action, data, undefined, function (res) {
                tempInput.val(res.shortLink).select();
                const copy = document.execCommand('copy');
                tempInput.remove();
                if (copy) {
                    alert("클립보드 복사되었습니다.");
                } else {
                    alert("이 브라우저는 지원하지 않습니다.");
                }
            })
        }
    }
</script>
@endsection

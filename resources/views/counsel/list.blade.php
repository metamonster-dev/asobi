@extends('layout.home')
@section('bodyAttr')
class="body sub_bg7"
@endsection
@section('contents')
<?php
$title = "상담일지";
$hd_bg = "7";
$back_link = "/";

$device_type = session('auth')['device_type'] ?? '';
$device_kind = session('auth')['device_kind'] ?? '';

$userAgent = $_SERVER['HTTP_USER_AGENT'];
$phpisIOS = false;
if (strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false || strpos($userAgent, 'iPod') !== false) {
    $phpisIOS = true;
} else {
    $phpisIOS = false;
}
?>
@include('common.headm02')

<article class="sub_pg sub_bg sub_bg7">
    <div class="container pt-4 pt_lg_50">
        <div class="d-none d-lg-block">
            @include('common.tabs')
        </div>

        <div class="mb-4 mb-lg-5">
            <div class="d-block d-lg-flex align-items-center justify-content-between">
                <h1 class="d-none d-lg-block tit_h1 ff_lotte fw_500">
                    <?=$title?>
                    <img src="/img/ic_tit.png" class="tit_img">
                </h1>

                <form name="counselAction" id="counselAction" method="GET" action="/counsel">
                    <div class="d-block d-lg-flex mt-0 mt-lg-3 mt-lg-0">
                        <div class="m_top mb-0">
                            <div class="input-group">

                                <select id="ymSelector" name="ym" class="form-control form-control-lg col-6">
                                    <option value="all">전체</option>
                                    <!-- 올해의 각 월 옵션 추가 -->
                                </select>

{{--                                <input type="month" name="ym" id="ym" value="{{ $ym }}" class="form-control form-control-lg col-6"--}}
{{--                                @if ($device_kind == 'iOS' || $phpisIOS)--}}
{{--                                    onBlur="this.form.submit()"--}}
{{--                                @else--}}
{{--                                    onchange="this.form.submit()"--}}
{{--                                @endif--}}
{{--                                >--}}
                                <div class="position-relative gr_r m_select_wrap">
                                    <div class="input_wrap">
                                        <input type="hidden" name="search_user_id" value="{{ $search_user_id }}" >
                                        <input type="text" name="search_text" id="searchText" value="{{ $search_text }}" class="form-control bg-white custom-select m_select" autocomplete="off" placeholder="전체">
                                        <button class="m_delete"><img src="/img/ic_delete_sm.png"></button>
                                    </div>
                                    <ul id="searchList" class="m_select_list none_scroll_bar"></ul>
                                </div>
                            </div>
                            <div class="m_top_ico d-block d-lg-none">
                                <img src="/img/m5_top.png">
                            </div>
                        </div>
                        @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='m')
                        <!-- ※ 작성하기 버튼은 교육원일 때만 노출 -->
                        <button type="button" class="d-none d-lg-block btn btn-md btn-primary ml-4 px-5" onclick="location.href='/counsel/write?ym={{ $ym }}&search_user_id={{ $search_user_id }}'">작성하기</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        @if($search_user_id == "")
            <!-- 전체 선택시 -->
            @if(count($list) > 0)
            <ul class="grid03_list note_stu_list attend_list">
                @foreach($list as $l)
                    @php
                        $link = "/counsel?ym=".$ym."&search_user_id=".$l['id']."&search_text=".$l['name'];
                    @endphp
                    <li>
                        <a href="{{ $link }}">
                            <div class="d-flex align-items-center">
                                <div class="rect rounded-circle">
                                    <img src="{{ $l['profile_image'] ?? '/img/profile_default.png' }}">
                                </div>
                                <p class="fs_16 fw_700 ml-3">{{ $l['name'] ?? '' }}</p>
                            </div>
                            <p>{{ $l['date'] ?? '' }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
            @else
            <div class="nodata">
                <p>조회된 학생이 없습니다.</p>
            </div>
            @endif
            <!-- // 전체 선택시 -->
        @else
            <!-- 학생 선택시 -->
            @if(count($list) > 0)
            <div class="grid01_list">
                @foreach($list as $l)
                <div class="adv_cont rounded-lg border">
                    <p class="fs_13 fw_300 text-dark_gray mt-1">{{ $l['date'] ?? '' }}</p>
                    <p class="fs_15 wh_pre py-3 line_h1_4">{!! strip_tags($l['content'] ?? '') !!}</p>
                    @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='m')
                    <!-- ※ 수정, 삭제 버튼은 교육원일 때만 노출 -->
                    <div class="d-flex align-items-center justify-content-end">
                        <button type="button" class="btn btn-sm btn-light mr-3" onclick="jalert2('삭제하시겠습니까?','삭제하기',function(){location.href='/counsel/delete/{{ $l['id'] }}';})">삭제</button>
                        <button type="button" class="btn btn-sm btn-outline-light" onclick="location.href='/counsel/write/{{ $l['id'] }}'">수정</button>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <div class="nodata">
                <p>조회된 상담일지가 없습니다.</p>
            </div>
            @endif
            <!-- // 학생 선택시 -->
        @endif

        <!-- <ul class="pagination">
            <li class=""><a href="#" class="page_btn prev"><img src="/img/ic_arrow_left_gr.png"></a></li>
            <li class=""><a href="#" class="on">1</a></li>
            <li class=""><a href="#">2</a></li>
            <li class=""><a href="#">3</a></li>
            <li class=""><a href="#">4</a></li>
            <li class=""><a href="#">5</a></li>
            <li class=""><a href="#" class="page_btn next"><img src="/img/ic_arrow_right_gr.png"></a></li>
        </ul> -->

        @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='m')
        <!-- 모바일 작성 버튼 -->
        <!-- ※ 작성하기 버튼은 교육원일 때만 노출 -->
        <div class="f_btn_wr d-block d-lg-none">
            <button type="button" class="btn float_btn" onclick="location.href='/counsel/write?ym={{ $ym }}&search_user_id={{ $search_user_id }}'"><img src="/img/ic_write.png" style="width: 3rem;"></button>
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
    const data = {!! $studentList !!};
    function sClick(e) {
        let s = $(e.target).data('idx');
        let f = $("#counselAction");
        f.find('input[name=search_user_id]').val(s);
        f.submit();
        // document.counselAction.submit(e);
    }
    function xClick(e) {
        let f = $("#counselAction");
        f.find('input[name=search_user_id]').val("");
    }

    $(window).on("load", function() {
        // 학생검색
        autoSearch(data, "searchList", "searchText", sClick, undefined, xClick);
    });

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

    const minYear = <?=$minYear?>;
    const minMonth = <?=$minMonth?>;

    function populateMonthOptions() {
        const select = document.getElementById('ymSelector');
        const now = new Date();
        const currentYear = now.getFullYear();
        const currentMonth = now.getMonth() + 1;

        for (let year = minYear; year <= currentYear; year++) {
            // 해당 연도의 월 범위 설정
            const startMonth = year === minYear ? minMonth : 1;
            const endMonth = year === currentYear ? currentMonth : 12;

            // 각 월에 대해 옵션 추가
            for (let month = startMonth; month <= endMonth; month++) {
                const optionValue = `${year}-${String(month).padStart(2, '0')}`;
                const optionText = `${year}년 ${month}월`;
                const option = new Option(optionText, optionValue);
                select.add(option);
            }
        }
    }

    populateMonthOptions(minYear, minMonth);
</script>

@endsection

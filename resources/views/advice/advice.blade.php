@extends('layout.home')
@section('bodyAttr')
class="body sub_bg1"
@endsection
@section('contents')
<?php
$title = "알림장 관리";
$hd_bg = "1";
$back_link = "/";
$twoYearsAgo = date('Y-m', strtotime('-2 years', mktime(0, 0, 0, 1, 1, date('Y'))));
$thisYear = date(date('Y').'-12');
$device_type = session('auth')['device_type'] ?? '';
?>
@include('common.headm02')

<article class="sub_pg sub_bg sub_bg1">
    <div class="container pt-3 pt_lg_50">
        <div class="d-none d-lg-block">
            @include('common.tabs')
        </div>

        <div class="mb-4 mb-lg-5">
            <div class="d-block d-lg-flex align-items-center justify-content-between">
                <h1 class="d-none d-lg-block tit_h1 ff_lotte fw_500">
                    <?=$title?>
                    <img src="/img/ic_tit.png" class="tit_img">
                </h1>
                <form name="adviceListAction" id="adviceListAction" method="GET" action="/advice">
                    <div class="d-block d-lg-flex mt-0 mt-lg-3 mt-lg-0">
                        <div class="m_top mb-0">
                            <div class="input-group">
                                <input type="month" name="ym" id="ym" value="{{ $ym }}" min="{{ $twoYearsAgo }}" max="{{ $thisYear }}" class="form-control form-control-lg col-6"
                                       @if ($device_type === 'iPhone' || $device_type === 'iPad')
                                           onBlur="this.form.submit()"
                                       @else
                                           onchange="this.form.submit()"
                                       @endif
                                >
                                <div class="position-relative gr_r m_select_wrap">
                                    <div class="input_wrap">
                                        <input type="hidden" name="search_user_id" value="{{ $search_user_id }}" >
                                        <input type="text" name="search_text" id="search_text" value="{{ $search_text }}" class="form-control bg-white custom-select m_select" autocomplete="off" placeholder="전체">
                                        <button class="m_delete"><img src="/img/ic_delete_sm.png"></button>
                                    </div>
                                    <ul id="searchList" class="m_select_list none_scroll_bar"></ul>
                                </div>
                            </div>
                            <div class="m_top_ico d-block d-lg-none">
                                <img src="/img/m1_top.png">
                            </div>
                        </div>
                        @if($writeMode)
                            @if(isset(session('auth')['user_type']) && in_array(session('auth')['user_type'], ["m","a"]))
                        <button type="button" class="d-none d-lg-block btn btn-md btn-primary ml-4 px-5" onclick="location.href='/advice/letter/write?ym={{ $ym }}&search_user_id={{ $search_user_id }}'">가정통신문 작성</button>
                            @endif
                        @endif
                        @if(isset(session('auth')['user_type']) && session('auth')['user_type'] == "m")
                        <button type="button" class="d-none d-lg-block btn btn-md btn-primary ml-4 px-5" onclick="location.href='/advice/note/write?ym={{ $ym }}&search_user_id={{ $search_user_id }}'">알림장 작성</button>
                        @endif
                    </div>
                </form>
            </div>
            @if(isset(session('auth')['user_type']) && (session('auth')['user_type'] =='h' || session('auth')['user_type'] =='a') && $search_user_id == "")
            <!-- ※ 가정통신문 발송 현황은 지사(+본사)일 떄만 노출 -->
            <div class="rounded-pill letter_stat">
                <p class="fw_500 fs_14">가정통신문 발송 현황</p>
                <p class="fw_500 fs_14 px-2 d-none d-lg-block">:</p>
                <p class="fw_500 fs_14">{{ number_format($letter_count) }} / {{ number_format($count) }}</p>
            </div>
            @endif
        </div>

        @if($search_user_id == "")
            <!-- 전체 선택시 -->
            <ul class="grid03_list note_stu_list">
                @if(count($list) > 0)
                    @foreach($list as $l)
                        @php
                            $adviceLink = "/advice?ym=".$ym."&search_user_id=".$l['id']."&search_text=".$l['name'];
                            $letterLink = "return false;";
                            $leterPointer = "";
                            if ($l['letter_id']) {
                                $letterLink = "location.href='/advice/".$l['id']."/letter/view/".$l['letter_id']."'";
                                $leterPointer = "cursor_pointer";
                            }
                        @endphp
                        <li>
                            <div class="d-flex align-items-center">
                                <div class="rect rounded-circle">
                                    <img src="{{ $l['profile_image'] ?? '/img/profile_default.png' }}">
                                </div>
                                <p class="fs_16 fw_700 ml-3">{{ $l['name'] ?? '' }}</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <img src="/img/ic_bell.png" style="width: 2rem;" class="cursor_pointer" onclick="location.href='{{ $adviceLink }}'">
                                <p class="ml-1 fs_16 mr-3 cursor_pointer" onclick="location.href='{{ $adviceLink }}'">{{ sprintf('%02d', $l['advice'] ?? 0) }}</p>
                                <img src="/img/ic_note.png" style="width: 2rem;" class="{{ $leterPointer }}" onclick="{{ $letterLink }}">
                                <p class="ml-1 fs_16 {{ $leterPointer }}" onclick="{{ $letterLink }}">{{ sprintf('%02d', $l['letter'] ?? 0) }}</p>
                            </div>
                        </li>
                    @endforeach
                @else
                <li>
                    <div class="d-flex align-items-center">
                        <div class="rect rounded-circle">
                            <img src="/img/profile_default.png">
                        </div>
                        <p class="fs_16 fw_700 text-gray ml-3">학생이 없습니다.</p>
                    </div>
                </li>
                @endif
            </ul>
            <!-- // 전체 선택시 -->
        @else
            <!-- 학생 선택시 -->
            @if(count($list) > 0)
                <ul class="note_list d-flex flex-column gap_15">
                    @php $k = 0; @endphp
                    @foreach($list as $l)
                        @php
                            $linkType="note";
                            if($l['type'] == 'letter') $linkType="letter";
                        @endphp
                        <li>
                            <a href="/advice/{{ $search_user_id }}/{{ $linkType }}/view/{{ $l['id'] }}">
                                <p class="text-dark_gray mb-2">{{ $l['date'] }}</p>
                                <h4 class="tit_h4 mb-3">{{ $l['title'] }}</h4>
                                <p class="line1_text">{{ $l['content'] }}</p>
                                @if(isset($l['file']))
                                <div class="note_img_list advice_slider">
                                    <div class="swiper-wrapper">
                                    @if(is_array($l['file']))
                                        @foreach($l['file'] as $ll)
                                            <div class="swiper-slide">
                                                <div class="rect rect2">
                                                    @if(isset($ll['file_path']) && $ll['file_path'])
                                                    <img src="{{ $ll['file_path'] }}">
                                                    @elseif(isset($ll['vimeo_id']) && $ll['vimeo_id'])
                                                    <img src="/img/loading.gif" class="video_thumb loading" id="vimeo{{ $k }}" data-vimeo="{{ $ll['vimeo_id'] }}">
                                                    @php $k = $k + 1; @endphp
                                                    @else
                                                    <i class="no_img"></i>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    </div>
                                </div>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="nodata">
                    <p>알림장 및 가정통신문이 없습니다.</p>
                </div>
            @endif
            <!-- // 학생 선택시 -->
        @endif

{{--        <ul class="pagination">--}}
{{--            <li class=""><a href="#" class="page_btn prev"><img src="/img/ic_arrow_left_gr.png"></a></li>--}}
{{--            <li class=""><a href="#" class="on">1</a></li>--}}
{{--            <li class=""><a href="#">2</a></li>--}}
{{--            <li class=""><a href="#">3</a></li>--}}
{{--            <li class=""><a href="#">4</a></li>--}}
{{--            <li class=""><a href="#">5</a></li>--}}
{{--            <li class=""><a href="#" class="page_btn next"><img src="/img/ic_arrow_right_gr.png"></a></li>--}}
{{--        </ul>--}}

        <!-- 모바일 작성 버튼 -->
        @if($writeMode)
            @if(isset(session('auth')['user_type']) && in_array(session('auth')['user_type'], ["m","a"]))
        <div class="f_btn_wr d-block d-lg-none">
{{--            <button type="button" class="btn float_btn" onclick="location.href='/advice/letter/write?ym={{ $ym }}'"><img src="/img/ic_write.png" style="width: 3rem;"></button>--}}
            <button type="button" class="btn float_btn btn_filter"><img src="/img/ic_write.png" style="width: 3rem;"></button>
        </div>
            @endif
        @else
            @if(isset(session('auth')['user_type']) && session('auth')['user_type'] == "m")
        <div class="f_btn_wr d-block d-lg-none">
            <button type="button" class="btn float_btn" onclick="location.href='/advice/note/write?ym={{ $ym }}&search_user_id={{ $search_user_id }}&search_text={{ $search_text }}'"><img src="/img/ic_write.png" style="width: 3rem;"></button>
        </div>
            @endif
        @endif
    </div>
</article>

@if($writeMode)
<!-- 가정통신문 작성 가능할 경우 선택 -->
<div class="filter_modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h4 class="tit_h4 py-4 border-bottom border-text">작성 선택</h4>
                <button class="btn btn-block h-auto px-0 py-4 border-bottom" value="" onclick="location.href='/advice/letter/write?ym={{ $ym }}'">
                    <p class="py-2 fs_16 fw_400">가정통신문 작성</p>
                </button>
                @if(session('auth')['user_type'] != "a")
                <button class="btn btn-block h-auto px-0 py-4 border-bottom mt-0" value="m" onclick="location.href='/advice/note/write?ym={{ $ym }}'">
                    <p class="py-2 fs_16 fw_400">알림장 작성</p>
                </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

<script>
    const data = {!! $studentList !!};
    function sClick(e) {
        let s = $(e.target).data('idx');
        let f = $("#adviceListAction");
        f.find('input[name=search_user_id]').val(s);
        f.submit();
    }
    function xClick(e) {
        let f = $("#adviceListAction");
        f.find('input[name=search_user_id]').val("");
    }
    $(window).on("load", function() {
        // 학생검색
        autoSearch(data, "searchList", "search_text", sClick, undefined, xClick);

        getVimeoThumbs();
    });

    const dateInput = document.getElementById('ym');

    const minDate = new Date();
    const maxDate = new Date();

    minDate.setFullYear(minDate.getFullYear() - 2);
    maxDate.setMonth(11);

    const minYear = minDate.getFullYear();
    const minMonth = String(minDate.getMonth() + 1).padStart(2, '0');

    dateInput.addEventListener('input', function() {
        const selectedDate = new Date(this.value);

        if (selectedDate < minDate) {
            this.value = `${minYear}-${minMonth}`;
        } else if (selectedDate > maxDate) {
            const maxYear = maxDate.getFullYear();
            this.value = `${maxYear}-12`;
        }
    });
</script>

@endsection

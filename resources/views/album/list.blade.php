@extends('layout.home')
@section('bodyAttr')
class="body"
@endsection
@section('contents')
<?php
$title = "앨범관리";
$hd_bg = "2";
$back_link = "/";
$twoYearsAgo = date('Y-m', strtotime('-2 years', mktime(0, 0, 0, 1, 1, date('Y'))));
$thisYear = date(date('Y').'-12');
$device_type = session('auth')['device_type'] ?? '';
?>
@include('common.headm02')

<article class="sub_pg sub_bg">
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
                <form name="albumAction" id="albumAction" method="GET" action="/album">
                    <div class="d-block d-lg-flex mt-0 mt-lg-3 mt-lg-0">
                        <div class="m_top mb-0">
                            <div class="input-group">
{{--                                <input type="month" name="ym" id="ym" value="{{ $ym }}" min="{{ $twoYearsAgo }}" max="{{ $thisYear }}" class="form-control form-control-lg col-6 col-lg-5"--}}
{{--                                       @if ($device_type === 'iPhone' || $device_type === 'iPad')--}}
{{--                                           onBlur="this.form.submit()"--}}
{{--                                       @else--}}
{{--                                           onchange="this.form.submit()"--}}
{{--                                       @endif--}}
{{--                                >--}}
{{--                                    <select name="ym" id="ym" onchange="this.form.submit()" class="form-control form-control-lg col-6 col-lg-5">--}}
{{--                                        <option value="2023-10">2023-10</option>--}}
{{--                                        <option value="2023-09">2023-09</option>--}}
{{--                                    </select>--}}
                               @if ($device_type === 'iPhone' || $device_type === 'iPad')
                                <select name="ym" id="ym" onchange="this.form.submit()" class="form-control form-control-lg col-6 col-lg-5">
                                @php
                                    for ($date = strtotime($twoYearsAgo); $date <= strtotime($thisYear); $date = strtotime("+1 month", $date)) {
                                        $yearMonth = date('Y-m', $date);
                                        $selected = ($yearMonth == $ym) ? 'selected' : ''; // $ym과 일치하는 경우 selected 속성 추가
                                    echo "<option value='$yearMonth' $selected>$yearMonth</option>";
                                    }
                                @endphp
                                </select>
                               @else
                                <input type="month" name="ym" id="ym" value="{{ $ym }}" min="{{ $twoYearsAgo }}" max="{{ $thisYear }}" class="form-control form-control-lg col-6 col-lg-5" onchange="this.form.submit()">
                                @endif

                                <div class="ip_sch_wr col-6 col-lg-7 px-0">
                                    <input type="search" name="search_text" id="search_text" value="{{ $search_text }}" class="form-control ip_search">
                                    <button type="submit" class="btn btn_sch btn_sch2"></button>
                                </div>
                            </div>
                            <div class="m_top_ico d-block d-lg-none">
                                <img src="/img/m2_top.png">
                            </div>
                        </div>
                        @if(isset(session('auth')['user_type']) && (session('auth')['user_type'] =='m' || session('auth')['user_type'] =='a'))
                        <!-- ※ 앨범작성은 교육원, 본사만 가능 -->
                        <button type="button" class="d-none d-lg-block btn btn-md btn-primary ml-4 px-5" onclick="location.href='/album/write?ym={{$ym}}'">앨범작성</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="pb-3">
            @if(count($list) > 0)
            <ul class="album_list">
                @php $k = 0; @endphp
                @foreach($list as $l)
                <li>
                    <a href="/album/view/{{ $l['id'] }}">
                        <p class="fs_14 text-dark_gray fw_300 mb-3">{{ $l['date'] ?? '' }}</p>
                        <h4 class="tit_h4 mb-4 line_text line1_text">{{ $l['title'] ?? '' }}</h4>
                        <div class="pic_li">
                            @if(isset($l['file']) && count($l['file']) > 0)
                                @php
                                    $count = count($l['file']);
                                    $num = 0;
                                    $max = ($count < 6) ? $count : 6;
                                @endphp
                                @for($i=0; $i < $max; $i++)
                                    @php $num = $num + 1; @endphp
                                    <div class="pic_li_wr">
                                        <div class="rect rounded">
                                            @if(isset($l['file'][$i]['file_path']) && $l['file'][$i]['file_path'])
                                            <img src="{{ $l['file'][$i]['file_path'] }}">
                                            @elseif(isset($l['file'][$i]['vimeo_id']) && $l['file'][$i]['vimeo_id'])
                                            <img src="/img/loading.gif" class="video_thumb" id="vimeo{{ $k }}" data-vimeo="{{ $l['file'][$i]['vimeo_id'] }}">
                                            @php $k = $k + 1; @endphp
                                            @else
                                            <i class="no_img"></i>
                                            @endif
                                        </div>
                                    </div>
                                @endfor
                            @else
                                @php $count = $num = 0; @endphp
                            @endif
                            @php $empty = 6 - $num; @endphp
                            @for($i = 0; $i < $empty; $i++)
                                @php $num = $num + 1; @endphp
                                <div class="pic_li_wr">
                                    <div class="rect rounded">
                                        <img src="/img/no_img0{{ $num }}.png">
                                    </div>
                                </div>
                            @endfor
                        </div>
                        @if(isset(session('auth')['user_type']) && session('auth')['user_type'] !=='s')
                            @if(isset($l['student']) && count($l['student']) > 0)
                            <!-- ※ 작성시 선택한 학생 정보는 학부모일 때 미노출 -->
                            <div class="d-flex align-items-center album_stu">
                                <div class="rect rounded-circle">
                                    <img src="{{ $l['student'][0]['user_picture'] ?? '/img/profile_default.png' }}">
                                </div>
                                <p class="fs_15 text-light ml-3">
                                    {{ $l['student'][0]['name'] ?? '' }}
                                    @if(count($l['student']) > 1)
                                    외 {{ count($l['student']) - 1 }}명
                                    @endif
                                </p>
                            </div>
                            @endif
                        @endif
                    </a>
                </li>
                @endforeach
            </ul>
            @else
            <div class="nodata">
                <p>조회된 앨범이 없습니다.</p>
            </div>
            @endif

        </div>

        <!-- <ul class="pagination">
            <li class=""><a href="#" class="page_btn prev"><img src="/img/ic_arrow_left_gr.png"></a></li>
            <li class=""><a href="#" class="on">1</a></li>
            <li class=""><a href="#">2</a></li>
            <li class=""><a href="#">3</a></li>
            <li class=""><a href="#">4</a></li>
            <li class=""><a href="#">5</a></li>
            <li class=""><a href="#" class="page_btn next"><img src="/img/ic_arrow_right_gr.png"></a></li>
        </ul> -->

        @if(isset(session('auth')['user_type']) && (session('auth')['user_type'] =='m' || session('auth')['user_type'] =='a'))
        <!-- 모바일 작성 버튼 -->
        <!-- ※ 앨범작성은 교육원, 본사만 가능 -->
        <div class="f_btn_wr d-block d-lg-none">
            <button type="button" class="btn float_btn" onclick="location.href='/album/write'"><img src="/img/ic_write.png" style="width: 3rem;"></button>
        </div>
        @endif
    </div>
</article>

<script>
    $(window).on("load", function() {
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

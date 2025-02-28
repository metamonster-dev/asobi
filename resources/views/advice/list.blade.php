@extends('layout.home')
@section('bodyAttr')
class="body sub_bg1"
@endsection
@section('contents')
<?php
$title = "알림장";
$hd_bg = "1";
$back_link = "/";
$twoYearsAgo = date('Y-m', strtotime('-2 years', mktime(0, 0, 0, 1, 1, date('Y'))));
$thisYear = date(date('Y').'-12');
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

<article class="sub_pg sub_bg sub_bg1">
    <div class="container pt-4 pt_lg_50">
        <div class="d-none d-lg-block">
            @include('common.tabs')
        </div>

        <div class="d-block d-lg-flex align-items-center justify-content-between mb-4 mb-lg-5">
            <h1 class="d-none d-lg-block tit_h1 ff_lotte fw_500">
                <?=$title?>
                <img src="/img/ic_tit.png" class="tit_img">
            </h1>
            <form name="adviceListAction" id="adviceListAction" method="GET" action="/advice/list">
                <div class="d-block d-lg-flex mt-0 mt-lg-3 mt-lg-0">
                    <div class="m_top mb-0">
                        <div class="input-group">
{{--                            <input type="month" name="ym" id="ym" value="{{ $ym }}" min="{{ $twoYearsAgo }}" max="{{ $thisYear }}" class="form-control form-control-lg col-6 col-lg-5"--}}
{{--                                   @if ($device_type === 'iPhone' || $device_type === 'iPad')--}}
{{--                                       onBlur="this.form.submit()"--}}
{{--                                   @else--}}
{{--                                       onchange="this.form.submit()"--}}
{{--                                   @endif--}}
{{--                            >--}}

                            @if ($device_kind == 'iOS' || $phpisIOS)
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
                                <input type="text" name="search_text" id="search_text" value="{{ $search_text }}" class="form-control form-control-lg ip_search" autocomplete="off" @if ($device_kind == 'iOS' || $phpisIOS)style="height: var(--height_md);"@endif>
                                <button type="submit" class="btn btn_sch btn_sch2"></button>
                            </div>
                        </div>
                        <div class="m_top_ico d-block d-lg-none">
                            <img src="/img/m1_top.png">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- 리스트 없을 시 -->
        <!-- <div class="nodata">
            <p>알림장 및 가정통신문이 없습니다.</p>
        </div> -->
        <ul class="note_list d-flex flex-column gap_15">
            @if(count($list) > 0)
                @php $k = 0; @endphp
                @foreach($list as $l)
                    @php
                        $linkType="note";
                        if($l['type'] == 'letter') $linkType="letter";
                    @endphp
                    <li>
                        <a href="/advice/{{ $user }}/{{ $linkType }}/view/{{ $l['id'] }}">
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
            @else
                <div class="nodata">
                    <p>알림장 및 가정통신문이 없습니다.</p>
                </div>
            @endif
        </ul>

{{--        <ul class="pagination">--}}
{{--            <li class=""><a href="#" class="page_btn prev"><img src="/img/ic_arrow_left_gr.png"></a></li>--}}
{{--            <li class=""><a href="#" class="on">1</a></li>--}}
{{--            <li class=""><a href="#">2</a></li>--}}
{{--            <li class=""><a href="#">3</a></li>--}}
{{--            <li class=""><a href="#">4</a></li>--}}
{{--            <li class=""><a href="#">5</a></li>--}}
{{--            <li class=""><a href="#" class="page_btn next"><img src="/img/ic_arrow_right_gr.png"></a></li>--}}
{{--        </ul>--}}
    </div>
</article>

<script>
    $(window).on("load", function() {
        getVimeoThumbs();
    });


</script>

@endsection

@if(!$ajax)
@include('common.head')
@endif

<?php
$title = "출석부";
$hd_bg = "4";
$back_link = "/";
?>

<div class="parents_attend">
    <div class="modal_bg" id="attendView">
        <div class="modal_wrap md_attend mw-885">
            @include('common.headm02')
            <article class="sub_pg">
                <div class="container pt-4 pt-lg-0">
                    <div class="attend_cal_wrap">
                        <div class="d-block d-lg-none mb-5 bg-light_gray rounded-xl position-relative">
                            <div class="idx_info_box d-flex align-items-center justify-content-start">
                                <div class="ch_img rect rounded-circle mr-4">
                                    @if($studentInfo['picture'] != '')
                                    <img src="{{ $studentInfo['picture'] }}" alt="프로필 이미지">
                                    @else
                                    <img src="/img/profile_default.png" alt="프로필 이미지">
                                    @endif
                                </div>
                                <div class="">
                                    <h2 class="tit_h2 ff_lotte fw_400 mb-2 line_text line1_text">{{ $studentInfo['user_name'] ?? '' }}</h2>
                                    <p class="fs_16 text-dark_gray line_h1_3">이번달 출석 일수 : <br class="w_none">{{ $attendCount }} / {{ $attendAll }}일</p>
                                </div>
                            </div>
                            <div class="position-absolute idx_info_ico">
                                <img src="/img/ic_c_info2.png">
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="d-none d-lg-block mb-4 bg-light_gray rounded-xl position-relative">
                                <div class="idx_info_box d-flex align-items-center justify-content-start">
                                    <div class="ch_img rect rounded-circle mr-4">
                                        @if($studentInfo['picture'] != '')
                                        <img src="{{ $studentInfo['picture'] }}" alt="프로필 이미지">
                                        @else
                                        <img src="/img/profile_default.png" alt="프로필 이미지">
                                        @endif
                                    </div>
                                    <div class="">
                                        <h2 class="tit_h2 ff_lotte fw_400 mb-2 line_text line1_text">{{ $studentInfo['user_name'] ?? '' }}</h2>
                                        <p class="fs_16 text-dark_gray line_h1_3">이번달 출석 일수 : <br class="w_none">{{ $attendCount }} / {{ $attendAll }}일</p>
                                    </div>
                                </div>
                                <div class="position-absolute idx_info_ico">
                                    <img src="/img/ic_c_info2.png">
                                </div>
                            </div>
                            @if(count($infoList) > 0)
                            <ul class="cal_notice mt-4 mt-lg-0">
                                @foreach($infoList as $k => $l)
                                <li>
                                    <p class="fs_13 fw_300 text-light mb-3">
                                        {{ $k }}
                                    </p>
                                    <div class="d-flex align-items-start">
                                        <span class="dot_stat mt-1 bg-primary"></span>
                                        <p class="ml-2 fs_14 line_h1_1">
                                            <?php $text = ''; $firstValue = reset($l); ?>
                                            @foreach($l as $dk => $dl)
                                                @php
                                                    $text .= (
                                                        $dk == 'notice' ? '공지사항 '.$dl.'건' :
                                                        ($dk == 'advice' ? '알림장 '.$dl.'건' :
                                                        ($dk == 'letter' ? '가정통신문 '.$dl.'건' :
                                                        ($dk == 'album' ? '앨범 '.$dl.'건' : '')))
                                                    );
                                                @endphp
                                                @if ($loop->even && !$loop->last)
                                                    @php $text .= ', '; @endphp
                                                @endif
                                            @endforeach

                                            <a href="{{$firstValue}}"><?= $text ?></a>
                                        </p>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                        <div class="pb-3 pb-lg-0">
                        <div class="calendar_wrap">
                            <div class="calendar_month d-flex align-items-center justify-content-center">
                                <button class="btn btn_cal h-auto calPrev" data-date="{{ $ym }}"><img src="/img/ic_cal_prev.png"></button>
                                <h4 class="tit_h4 mx-3"><span id="calYear"></span>년 <span id="calMonth"></span></h4>
                                <button class="btn btn_cal h-auto calNext" data-date="{{ $ym }}"><img src="/img/ic_cal_next.png"></button>
                            </div>
                            <!--
                                ※ 캘린더 내용 / div에 추가해줘야 하는 각 class명
                                출석해야하는 날짜 (홀수 월) : active_blue
                                출석해야하는 날짜 (짝수 월) : active_red
                                -> 추후에 홀, 짝 상관 없이 검정, 공휴일이 빨강
                                공지가 있는 날짜 : notice
                                등원한 날짜 : dot1
                                하원한 날짜 : dot2
                            -->
                            <ul class="cal_date">
                                <li><p class="fs_15 my-2">일</p></li>
                                <li><p class="fs_15 my-2">월</p></li>
                                <li><p class="fs_15 my-2">화</p></li>
                                <li><p class="fs_15 my-2">수</p></li>
                                <li><p class="fs_15 my-2">목</p></li>
                                <li><p class="fs_15 my-2">금</p></li>
                                <li><p class="fs_15 my-2">토</p></li>
                            </ul>
                            <ul class="cal_date mt-0" id="calList"></ul>
                        </div>
                        </div>
                        <hr class="d-block d-lg-none line my-4">
                        <div class="d-flex d-lg-none align-items-center justify-content-end py-2">
                            <div class="d-flex align-items-center">
                                <span class="dot_stat bg-primary"></span>
                                <p class="ml-2 fs_14">등원</p>
                            </div>
                            <div class="d-flex align-items-center ml-3">
                                <span class="dot_stat bg-secondary"></span>
                                <p class="ml-2 fs_14">하원</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 d-none d-lg-block">
                        <button type="button" class="btn btn-primary btn-block close_btn" onclick="calModalHide('attendView')">닫기</button>
                    </div>
                </div>
            </article>
        </div>
    </div>
</div>

<script>
    function calendarChange(ym) {
        let action = `/attend/view/{{ $id }}?ajax=1&list={{ $list }}`;
        let data = { ym: ym };

        ycommon.ajaxJson('get', action, data, undefined, function (data) {
            console.log(data);
            @if(!$list)
            $("body").html("").html(data.calendar);
            @else
            $("#modalConts").html("").html(data.calendar);
            $('#attendView .btn_back').removeAttr("onclick");
            $('#attendView .btn_back').on('click',function(){
                calModalHide('attendView');
            });
            @endif
        });
    }
    function calendarData(ym) { // 캘린더
        let action = '/attend/view/calendar';
        let data = {
            ym: ym,
            attendListBlue: <?= json_encode($blueList) ?>,
            attendListRed: <?= json_encode($redList) ?>,
            attendIn: <?= json_encode($attendIn) ?>,
            attendOut: <?= json_encode($attendOut) ?>,
            infoDates: <?= json_encode($infoDates) ?>
        };

        ycommon.ajaxJson('post', action, data, undefined, function (data) {
            $("#calList").html(data?.calHtml);
            $("#calYear").text(data?.year);
            $("#calMonth").text(data?.month);
        });
    }

    $(document).ready(function() {
        calendarData('{{ $ym }}');
    });
</script>

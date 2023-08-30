<?php
$title = "출석부 관리";
$hd_bg = "4";
include_once("./inc/head.php");
include_once("./inc/head_style03.php");
?>

<article class="sub_pg">
    <div class="container pt-3 pb-5">
        
        <div class="mt-3 mb-5 bg-light_gray rounded-xl position-relative">
            <div class="idx_info_box d-flex align-items-center justify-content-start">
                <div class="ch_img rect mr-4">
                    <img src="./img/sample_img1.png" alt="">
                </div>
                <div class="">
                    <h2 class="tit_h2 ff_lotte fw_400 mb-2 line_text line1_text">아소비</h2>
                    <p class="fs_16 text-dark_gray line_h1_3">이번달 출석 일수 : <br class="w_none">1 / 20일</p>
                </div>
            </div>
            <div class="position-absolute idx_info_ico">
                <img src="./img/ic_c_info2.png">
            </div>
        </div>

        <div class="calendar_wrap pb-3">
            <div class="calendar_month d-flex align-items-center justify-content-center">
                <button class="btn btn_cal h-auto"><img src="./img/ic_cal_prev.png"></button>
                <h4 class="tit_h4 mx-3">2023년 05월</h4>
                <button class="btn btn_cal h-auto"><img src="./img/ic_cal_next.png"></button>
            </div>

            <ul class="cal_date type_a">
                <li>
                    <p class="fs_15 my-2">일</p>
                </li>
                <li>
                    <p class="fs_15 my-2">월</p>
                </li>
                <li>
                    <p class="fs_15 my-2">화</p>
                </li>
                <li>
                    <p class="fs_15 my-2">수</p>
                </li>
                <li>
                    <p class="fs_15 my-2">목</p>
                </li>
                <li>
                    <p class="fs_15 my-2">금</p>
                </li>
                <li>
                    <p class="fs_15 my-2">토</p>
                </li>
                <li></li>
                <li>
                    <div>
                        <p class="fs_16 fw_700">1</p>
                    </div>
                </li>
                <li>
                    <div class="active notice dot1 dot2">
                        <p class="fs_16 fw_700">2</p>
                    </div>
                </li>
                <li>
                    <div class="active dot1">
                        <p class="fs_16 fw_700">3</p>
                    </div>
                </li>
                <li>
                    <div class="active notice">
                        <p class="fs_16 fw_700">4</p>
                    </div>
                </li>
                <li>
                    <div class="active notice">
                        <p class="fs_16 fw_700">5</p>
                    </div>
                </li>
                <li>
                    <div>
                        <p class="fs_16 fw_700">6</p>
                    </div>
                </li>
                <li>
                    <div>
                        <p class="fs_16 fw_700">7</p>
                    </div>
                </li>
                <li>
                    <div class="active">
                        <p class="fs_16 fw_700">8</p>
                    </div>
                </li>
                <li>
                    <div class="active">
                        <p class="fs_16 fw_700">9</p>
                    </div>
                </li>
                <li>
                    <div class="active">
                        <p class="fs_16 fw_700">10</p>
                    </div>
                </li>
                <li>
                    <div class="active">
                        <p class="fs_16 fw_700">11</p>
                    </div>
                </li>
                <li>
                    <div class="active">
                        <p class="fs_16 fw_700">12</p>
                    </div>
                </li>
                <li>
                    <div>
                        <p class="fs_16 fw_700">13</p>
                    </div>
                </li>
                <li>
                    <div>
                        <p class="fs_16 fw_700">14</p>
                    </div>
                </li>
                <li>
                    <div class="active">
                        <p class="fs_16 fw_700">15</p>
                    </div>
                </li>
                <li>
                    <div class="active">
                        <p class="fs_16 fw_700">16</p>
                    </div>
                </li>
                <li>
                    <div class="active">
                        <p class="fs_16 fw_700">17</p>
                    </div>
                </li>
                <li>
                    <div class="active">
                        <p class="fs_16 fw_700">18</p>
                    </div>
                </li>
                <li>
                    <div class="active">
                        <p class="fs_16 fw_700">19</p>
                    </div>
                </li>
                <li>
                    <div>
                        <p class="fs_16 fw_700">20</p>
                    </div>
                </li>
                <li>
                    <div>
                        <p class="fs_16 fw_700">21</p>
                    </div>
                </li>
                <li>
                    <div class="active">
                        <p class="fs_16 fw_700">22</p>
                    </div>
                </li>
                <li>
                    <div class="active">
                        <p class="fs_16 fw_700">23</p>
                    </div>
                </li>
                <li>
                    <div class="active">
                        <p class="fs_16 fw_700">24</p>
                    </div>
                </li>
                <li>
                    <div class="active">
                        <p class="fs_16 fw_700">25</p>
                    </div>
                </li>
                <li>
                    <div class="active">
                        <p class="fs_16 fw_700">26</p>
                    </div>
                </li>
                <li>
                    <div>
                        <p class="fs_16 fw_700">27</p>
                    </div>
                </li>
                <li>
                    <div>
                        <p class="fs_16 fw_700">28</p>
                    </div>
                </li>
                <li>
                    <div class="active">
                        <p class="fs_16 fw_700">29</p>
                    </div>
                </li>
                <li>
                    <div>
                        <p class="fs_16 fw_700">30</p>
                    </div>
                </li>
                <li>
                    <div>
                        <p class="fs_16 fw_700">31</p>
                    </div>
                </li>
            </ul>
        </div>
        <hr class="line my-4">
        <div class="d-flex align-items-center justify-content-end py-2">
            <div class="d-flex align-items-center">
                <span class="dot_stat bg-primary"></span>
                <p class="ml-2 fs_14">등원</p>
            </div>
            <div class="d-flex align-items-center ml-3">
                <span class="dot_stat bg-secondary"></span>
                <p class="ml-2 fs_14">하원</p>
            </div>
        </div>

        <ul class="cal_notice">
            <li>
                <p class="fs_13 fw_300 text-light mb-3">5월 2일 화요일</p>
                <div class="d-flex align-items-start">
                    <span class="dot_stat mt-1 bg-primary"></span>
                    <p class="ml-2 fs_14 line_h1_1">공지사항 1건, 알림장 1건, 가정통신문 1건, 앨범 1건</p>
                </div>
            </li>
            <li>
                <p class="fs_13 fw_300 text-light mb-3">5월 4일 목요일</p>
                <div class="d-flex align-items-start">
                    <span class="dot_stat mt-1 bg-primary"></span>
                    <p class="ml-2 fs_14 line_h1_1">가정통신문 1건, 앨범 1건</p>
                </div>
            </li>
            <li>
                <p class="fs_13 fw_300 text-light mb-3">5월 5일 금요일</p>
                <div class="d-flex align-items-start">
                    <span class="dot_stat mt-1 bg-primary"></span>
                    <p class="ml-2 fs_14 line_h1_1">가정통신문 1건, 앨범 1건</p>
                </div>
            </li>
        </ul>
    </div>
</article>


<?php include_once("./inc/tail.php"); ?>
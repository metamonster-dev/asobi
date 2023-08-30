<?php
$title = "메인";
include_once("./inc/head.php");
include_once("./inc/head_style01.php");
?>

<article class="idx_pg">
    <div class="container pt-3 pb-5">

        <div class="d-flex align-items-center mt-3">
            <a href="./institute_notice1.php" class="d-block rounded-lg overflow-hidden mr-4 w-100">
                <div class="d-flex align-items-center justify-content-between bg-light_gray p-4">
                    <h4 class="tit_h4 fw_500 ff_lotte mb-n2">교육원 공지사항</h4>
                    <img src="./img/ic_arrow_right_b.png" style="max-width: 2rem;">
                </div>
            </a>
            <button type="button" class="btn btn-primary btn_mw" onclick="location.href='./branch_notice_write.php'">작성</button>
        </div>

        <ul class="mb-4">
            <li class="border-bottom">
                <a href="./branch_notice_detail.php" class="d-flex align-items-center justify-content-between p-4">
                    <p class="fs_14 text-text2 line_text line1_text">얼마나 우리는 스며들어 생의 구하기 곳으로 열매를 힘차게 행복스럽고 있으랴?</p>
                    <p class="fs_13 fw_300 text-dark_gray ml-5">04.31</p>
                </a>
            </li>
            <li class="border-bottom">
                <a href="./branch_notice_detail.php" class="d-flex align-items-center justify-content-between p-4">
                    <p class="fs_14 text-text2 line_text line1_text">얼마나 우리는 스며들어 생의 구하기 곳으로 열매를 힘차게 행복스럽고 있으랴?</p>
                    <p class="fs_13 fw_300 text-dark_gray ml-5">04.31</p>
                </a>
            </li>
        </ul>

        <!-- 지사 -->
        <div class="position-relative mb-4">
            <input type="text" class="form-control custom-select m_select" placeholder="교육원 선택">
            <ul class="m_select_list none_scroll_bar">
                <li class="active">아소비 교육원</li>
                <li>아소비 교육원1</li>
                <li>아소비 교육원11</li>
                <li>아소비 교육원12</li>
                <li>아소비 교육원334</li>
            </ul>
        </div>

        <!-- 본사 -->
        <!-- <div class="d-flex align-items-center mb-4">
            <div class="position-relative mr-4">
                <input type="text" class="form-control custom-select m_select" placeholder="교육원 선택">
                <ul class="m_select_list none_scroll_bar">
                    <li class="active">아소비 교육원</li>
                    <li>아소비 교육원1</li>
                    <li>아소비 교육원11</li>
                    <li>아소비 교육원12</li>
                    <li>아소비 교육원334</li>
                </ul>
            </div>
            <div class="position-relative">
                <input type="text" class="form-control custom-select m_select" placeholder="지사 선택">
                <ul class="m_select_list none_scroll_bar">
                    <li class="active">지사</li>
                    <li>지사1</li>
                    <li>지사11</li>
                    <li>지사12</li>
                    <li>지사334</li>
                </ul>
            </div>
        </div> -->


        <!-- 지사 -->
        <div class="row m_menu_wrap">
            <div class="col col-6 m_menu">
                <a href="./branch_note.php" class="">
                    <div class="menu_name d-flex align-items-center">
                        <p class="fs_22 ff_lotte text-white">알림장</p>
                    </div>
                    <div class="menu_bg position-absolute" style="">
                        <img src="./img/m_menu_1.png">
                    </div>
                </a>
            </div>
            <div class="col col-6 m_menu">
                <a href="./branch_album.php" class="">
                    <div class="menu_name d-flex align-items-center">
                        <p class="fs_22 ff_lotte text-white">앨범</p>
                    </div>
                    <div class="menu_bg position-absolute" style="">
                        <img src="./img/m_menu_2.png">
                    </div>
                </a>
            </div>
            <div class="col col-6 m_menu">
                <a href="./institute_notice.php" class="">
                    <div class="menu_name d-flex align-items-center">
                        <p class="fs_22 ff_lotte text-white">학부모 공지</p>
                    </div>
                    <div class="menu_bg position-absolute" style="">
                        <img src="./img/m_menu_3.png">
                    </div>
                </a>
            </div>
            <div class="col col-6 m_menu">
                <a href="./branch_attend.php" class="">
                    <div class="menu_name d-flex align-items-center">
                        <p class="fs_22 ff_lotte text-white">출석부</p>
                    </div>
                    <div class="menu_bg position-absolute" style="">
                        <img src="./img/m_menu_4.png">
                    </div>
                </a>
            </div>
            <div class="col col-6 m_menu">
                <a href="./info.php" class="">
                    <div class="menu_name d-flex align-items-center">
                        <p class="fs_22 ff_lotte text-white">교육정보</p>
                    </div>
                    <div class="menu_bg position-absolute" style="">
                        <img src="./img/m_menu_5.png">
                    </div>
                </a>
            </div>
            <div class="col col-6 m_menu">
                <a href="./event.php" class="">
                    <div class="menu_name d-flex align-items-center">
                        <p class="fs_22 ff_lotte text-white">이벤트</p>
                    </div>
                    <div class="menu_bg position-absolute" style="">
                        <img src="./img/m_menu_6.png">
                    </div>
                </a>
            </div>
            <div class="col col-12 m_menu">
                <a href="./advice.php" class="">
                    <div class="d-flex align-items-center justify-content-between p-4">
                        <p class="fs_20 ff_lotte text-white">상담일지</p>
                        <img src="./img/ic_arrow_right_w.png" style="max-width: 2rem;">
                    </div>
                </a>
            </div>
        </div>


        <!-- 본사 -->
        <!-- <div class="row m_menu_wrap">
            <div class="col col-6 m_menu">
                <a href="./head_note.php" class="">
                    <div class="menu_name d-flex align-items-center">
                        <p class="fs_22 ff_lotte text-white">알림장</p>
                    </div>
                    <div class="menu_bg position-absolute" style="">
                        <img src="./img/m_menu_1.png">
                    </div>
                </a>
            </div>
            <div class="col col-6 m_menu">
                <a href="./institute_album.php" class="">
                    <div class="menu_name d-flex align-items-center">
                        <p class="fs_22 ff_lotte text-white">앨범</p>
                    </div>
                    <div class="menu_bg position-absolute" style="">
                        <img src="./img/m_menu_2.png">
                    </div>
                </a>
            </div>
            <div class="col col-6 m_menu">
                <a href="./institute_notice.php" class="">
                    <div class="menu_name d-flex align-items-center">
                        <p class="fs_22 ff_lotte text-white">공지사항</p>
                    </div>
                    <div class="menu_bg position-absolute" style="">
                        <img src="./img/m_menu_3.png">
                    </div>
                </a>
            </div>
            <div class="col col-6 m_menu">
                <a href="./branch_attend.php" class="">
                    <div class="menu_name d-flex align-items-center">
                        <p class="fs_22 ff_lotte text-white">출석부</p>
                    </div>
                    <div class="menu_bg position-absolute" style="">
                        <img src="./img/m_menu_4.png">
                    </div>
                </a>
            </div>
            <div class="col col-6 m_menu">
                <a href="./info.php" class="">
                    <div class="menu_name d-flex align-items-center">
                        <p class="fs_22 ff_lotte text-white">교육정보</p>
                    </div>
                    <div class="menu_bg position-absolute" style="">
                        <img src="./img/m_menu_5.png">
                    </div>
                </a>
            </div>
            <div class="col col-6 m_menu">
                <a href="./event.php" class="">
                    <div class="menu_name d-flex align-items-center">
                        <p class="fs_22 ff_lotte text-white">이벤트</p>
                    </div>
                    <div class="menu_bg position-absolute" style="">
                        <img src="./img/m_menu_6.png">
                    </div>
                </a>
            </div>
            <div class="col col-12 m_menu">
                <a href="./advice.php" class="">
                    <div class="d-flex align-items-center justify-content-between p-4">
                        <p class="fs_20 ff_lotte text-white">상담일지</p>
                        <img src="./img/ic_arrow_right_w.png" style="max-width: 2rem;">
                    </div>
                </a>
            </div>
        </div> -->

        <div class="py-4 rounded-lg overflow-hidden">
            <a href="#">
                <img src="./img/sample_img2.jpg" alt="">
            </a>
        </div>

    </div>

</article>


<?php include_once("./inc/tail.php"); ?>

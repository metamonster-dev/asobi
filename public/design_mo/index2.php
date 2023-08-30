<?php
$title = "메인";
include_once("./inc/head.php");
include_once("./inc/head_style01.php");
?>

<article class="idx_pg">
    <div class="container pt-3 pb-5">

        <a href="./institute_notice1.php" class="d-block mt-3 rounded-lg overflow-hidden">
            <div class="d-flex align-items-center justify-content-between bg-light_gray p-4">
                <h4 class="tit_h4 fw_500 ff_lotte mb-n2">아소비교육 공지사항</h4>
                <img src="./img/ic_arrow_right_b.png" style="max-width: 2rem;">
            </div>
        </a>

        <ul class="mb-4">
            <li class="border-bottom">
                <a href="./institute_notice_detail1.php" class="d-flex align-items-center justify-content-between p-4">
                    <p class="fs_14 text-text2 line_text line1_text">얼마나 우리는 스며들어 생의 구하기 곳으로 열매를 힘차게 행복스럽고 있으랴?</p>
                    <p class="fs_13 fw_300 text-dark_gray ml-5">04.31</p>
                </a>
            </li>
            <li class="border-bottom">
                <a href="./institute_notice_detail1.php" class="d-flex align-items-center justify-content-between p-4">
                    <p class="fs_14 text-text2 line_text line1_text">얼마나 우리는 스며들어 생의 구하기 곳으로 열매를 힘차게 행복스럽고 있으랴?</p>
                    <p class="fs_13 fw_300 text-dark_gray ml-5">04.31</p>
                </a>
            </li>
        </ul>

        <div class="row m_menu_wrap">
            <div class="col col-6 m_menu">
                <a href="./institute_note.php" class="">
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
                        <p class="fs_22 ff_lotte text-white">학부모 공지</p>
                    </div>
                    <div class="menu_bg position-absolute" style="">
                        <img src="./img/m_menu_3.png">
                    </div>
                </a>
            </div>
            <div class="col col-6 m_menu">
                <a href="./institute_attend.php" class="">
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

        <div class="py-4 rounded-lg overflow-hidden">
            <a href="#">
                <img src="./img/sample_img2.jpg" alt="">
            </a>
        </div>

    </div>

</article>


<?php include_once("./inc/tail.php"); ?>

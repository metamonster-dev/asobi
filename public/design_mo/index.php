<?php
$title = "메인";
include_once("./inc/head.php");
include_once("./inc/head_style01.php");
?>

<article class="idx_pg">
    <div class="container pt-3 pb-5">
        
        <div class="mt-3 mb-4 bg-light_gray rounded-xl position-relative">
            <div class="idx_info_box d-flex align-items-center justify-content-start">
                <div class="ch_img rect mr-4">
                    <img src="./img/sample_img1.png" alt="">
                </div>
                <div class="">
                    <h2 class="tit_h2 ff_lotte fw_400 mb-2 line_text line1_text">아소비</h2>
                    <p class="fs_16 text-dark_gray line_text line1_text">서울 은평증산점</p>
                </div>
            </div>
            <div class="position-absolute idx_info_ico">
                <img src="./img/ic_c_info2.png">
            </div>
        </div>

        <div class="row m_menu_wrap">
            <div class="col col-6 m_menu">
                <a href="./parents_note.php" class="">
                    <div class="menu_name d-flex align-items-center">
                        <p class="fs_22 ff_lotte text-white">알림장</p>
                    </div>
                    <div class="menu_bg position-absolute" style="">
                        <img src="./img/m_menu_1.png">
                    </div>
                </a>
            </div>
            <div class="col col-6 m_menu">
                <a href="./parents_album.php" class="">
                    <div class="menu_name d-flex align-items-center">
                        <p class="fs_22 ff_lotte text-white">앨범</p>
                    </div>
                    <div class="menu_bg position-absolute" style="">
                        <img src="./img/m_menu_2.png">
                    </div>
                </a>
            </div>
            <div class="col col-6 m_menu">
                <a href="./parents_notice.php" class="">
                    <div class="menu_name d-flex align-items-center">
                        <p class="fs_22 ff_lotte text-white">공지사항</p>
                    </div>
                    <div class="menu_bg position-absolute" style="">
                        <img src="./img/m_menu_3.png">
                    </div>
                </a>
            </div>
            <div class="col col-6 m_menu">
                <a href="./parents_attend.php" class="">
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
        </div>

        <div class="py-4 rounded-lg overflow-hidden">
            <a href="#">
                <img src="./img/sample_img2.jpg" alt="">
            </a>
        </div>

    </div>

</article>


<?php include_once("./inc/tail.php"); ?>
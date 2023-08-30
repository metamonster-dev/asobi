<?php
$title = "출석부 관리";
$hd_bg = "4";
include_once("./inc/head.php");
include_once("./inc/head_style02.php");
?>

<article class="sub_pg sub_bg sub_bg4">
    <div class="container-fluid pt-5 pb-5">
        <form action="">
            <h2 class="tit_h2 ff_lotte fw_500 pb-3 position-relative z_2">날짜를 선택해 주세요.<img src="./img/ic_tit.png" class="tit_img"></h2>
            <div class="m_top pt-3">
                <div class="input-group">
                    <input type="date" class="form-control col-12">
                </div>
                <div class="m_top_ico">
                    <img src="./img/m4_top.png">
                </div>
            </div>

            <!-- 전체선택시 -->
            <ul class="note_stu_list attend_list pb-5">
                <li>
                    <a href="./institute_attend_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p class="fs_16 text-right">0 / 16일</p>
                    </a>
                </li>
                <li>
                    <a href="./institute_attend_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p class="fs_16 text-right">0 / 16일</p>
                    </a>
                </li>
                <li>
                    <a href="./institute_attend_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p class="fs_16 text-right">0 / 16일</p>
                    </a>
                </li>
                <li>
                    <a href="./institute_attend_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p class="fs_16 text-right">0 / 16일</p>
                    </a>
                </li>
                <li>
                    <a href="./institute_attend_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p class="fs_16 text-right">0 / 16일</p>
                    </a>
                </li>
                <li>
                    <a href="./institute_attend_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p class="fs_16 text-right">0 / 16일</p>
                    </a>
                </li>
                <li>
                    <a href="./institute_attend_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p class="fs_16 text-right">0 / 16일</p>
                    </a>
                </li>
                <li>
                    <a href="./institute_attend_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p class="fs_16 text-right">0 / 16일</p>
                    </a>
                </li>
                <li>
                    <a href="./institute_attend_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p class="fs_16 text-right">0 / 16일</p>
                    </a>
                </li>
            </ul>
            <!-- // 전체선택시 -->

        </form>
        
    </div>
</article>

<?php include_once("./inc/tail.php"); ?>
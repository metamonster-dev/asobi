<?php
$title = "상담일지";
$hd_bg = "7";
include_once("./inc/head.php");
include_once("./inc/head_style02.php");
?>

<article class="sub_pg sub_bg sub_bg7">
    <div class="container-fluid pt-3 pb-5">
        <form action="">
            <div class="m_top">
                <div class="input-group">
                    <input type="date" class="form-control form-control-lg col-6">
                    <div class="position-relative gr_r">
                        <input type="text" class="form-control bg-white custom-select m_select" value="전체">
                        <ul class="m_select_list none_scroll_bar">
                            <li class="active">전체</li>
                            <li>홍길동</li>
                            <li>홍길동1</li>
                            <li>2홍길동</li>
                            <li>3김길동</li>
                        </ul>
                    </div>
                </div>
                <div class="m_top_ico">
                    <img src="./img/m5_top.png">
                </div>
            </div>

            <!-- 전체선택시 -->
            <ul class="note_stu_list attend_list pb-5">
                <li>
                    <a href="./advice_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p>2023.03.08</p>
                    </a>
                </li>
                <li>
                    <a href="./advice_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p>2023.03.08</p>
                    </a>
                </li>
                <li>
                    <a href="./advice_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p>2023.03.08</p>
                    </a>
                </li>
                <li>
                    <a href="./advice_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p>2023.03.08</p>
                    </a>
                </li>
                <li>
                    <a href="./advice_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p>2023.03.08</p>
                    </a>
                </li>
                <li>
                    <a href="./advice_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p>2023.03.08</p>
                    </a>
                </li>
                <li>
                    <a href="./advice_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p>2023.03.08</p>
                    </a>
                </li>
                <li>
                    <a href="./advice_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p>2023.03.08</p>
                    </a>
                </li>
                <li>
                    <a href="./advice_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p>2023.03.08</p>
                    </a>
                </li>
                <li>
                    <a href="./advice_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p>2023.03.08</p>
                    </a>
                </li>
            </ul>
            <!-- // 전체선택시 -->
        </form>
        
    </div>
</article>

<?php include_once("./inc/tail.php"); ?>
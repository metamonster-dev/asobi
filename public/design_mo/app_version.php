<?php
$title = "앱 버전정보";
$hd_bg = "8";
include_once("./inc/head.php");
include_once("./inc/head_style03.php");
?>

<article class="sub_pg">
    <div class="container pt-5 pb-5">
        <div class="logo mx-auto h-auto" style="max-width: 8rem;">
            <img src="./img/logo.svg">
        </div>
        <div class="bg-light_gray rounded-lg p-3 mt-5 mb-3">
            <div class="text-center p-3">
                <p class="fs_16 line_h1_2 fw_700 wh_pre mb-3">현재 버전
                V1.6.4(95)</p>
                <p class="fs_13 text-light">현재 사용 중인 아소비는 최신 버전입니다.</p>
            </div>
        </div>
        <ul class="py-3">
            <li class="mb-4">
                <a href="./terms.php" class="d-flex align-items-center justify-content-between p-4 border rounded-lg">
                    <p class="fw_700">서비스 이용약관</p>
                    <img src="./img/ic_arrow_right_b.png" class="py-2" style="max-width: 2rem;">
                </a>
            </li>
            <li class="mb-4">
                <a href="./policy.php" class="d-flex align-items-center justify-content-between p-4 border rounded-lg">
                    <p class="fw_700">개인정보 처리방침</p>
                    <img src="./img/ic_arrow_right_b.png" class="py-2" style="max-width: 2rem;">
                </a>
            </li>
        </ul>
    </div>
</article>


<?php include_once("./inc/tail.php"); ?>
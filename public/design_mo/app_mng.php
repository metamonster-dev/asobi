<?php
$title = "앱관리";
$hd_bg = "8";
include_once("./inc/head.php");
include_once("./inc/head_style02.php");
?>

<article class="sub_pg">
    <div class="container pt-3 pb-5">
        <div class="py-3">
            <ul>
                <li class="mb-4">
                    <a href="./app_alarm.php" class="d-flex align-items-center justify-content-between p-4 border rounded-lg">
                        <p class="fw_700">알림설정</p>
                        <img src="./img/ic_arrow_right_b.png" class="py-2" style="max-width: 2rem;">
                    </a>
                </li>
                <li class="mb-4">
                    <a href="./set_photo.php" class="d-flex align-items-center justify-content-between p-4 border rounded-lg">
                        <p class="fw_700">사진/동영상 설정</p>
                        <img src="./img/ic_arrow_right_b.png" class="py-2" style="max-width: 2rem;">
                    </a>
                </li>
                <li class="mb-4">
                    <a href="./app_version.php" class="d-flex align-items-center justify-content-between p-4 border rounded-lg">
                        <p class="fw_700">앱 버전 정보</p>
                        <img src="./img/ic_arrow_right_b.png" class="py-2" style="max-width: 2rem;">
                    </a>
                </li>
                <li class="">
                    <a href="./storage_mng.php" class="d-flex align-items-center justify-content-between p-4 border rounded-lg">
                        <p class="fw_700">저장 공간 관리</p>
                        <img src="./img/ic_arrow_right_b.png" class="py-2" style="max-width: 2rem;">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</article>


<?php include_once("./inc/tail.php"); ?>
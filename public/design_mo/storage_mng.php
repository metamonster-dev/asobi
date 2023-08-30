<?php
$title = "저장 공간 관리";
$hd_bg = "8";
include_once("./inc/head.php");
include_once("./inc/head_style03.php");
?>

<article class="sub_pg">
    <div class="container pt-3 pb-5">
        <div class="py-3">
            <p class="fw_700 mb-2">저장된 캐시 데이터</p>
            <p class="fs_13 text-light pb-4 pt-1">670.6KB 사용 중</p>
            <div class="rounded-lg bg-light_gray p-3">
                <p class="p-3 wh_pre text-light fs_13 line_h1_2">앱에 임시 저장된 캐시 데이터를 삭제하고 정리해 줍니다.
                알림장, 공지사항, 앨범 등 아소비에 업로드된 사진, 동영상, 문서 파일은 그대로 유지됩니다.</p>
            </div>
        </div>
        <div class="py-5 mt-3">
            <button type="button" class="btn btn-primary btn-block">캐시 데이터 삭제</button>
        </div>
    </div>
</article>


<?php include_once("./inc/tail.php"); ?>
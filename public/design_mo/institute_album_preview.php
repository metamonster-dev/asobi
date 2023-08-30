<?php
$title = "앨범 상세";
$hd_bg = "2";
include_once("./inc/head.php");
include_once("./inc/head_style02.php");
?>

<article class="sub_pg">
    <div class="container pt-3 pb-5">
        <div class="pt-3 pb-4 mb-3 border-bottom">
            <div>
                <div class="d-flex align-items-center mb-3 text-dark_gray fs_14 fw_300">
                    <p class="">2023.04.01 16:05 월요일</p>
                </div>
                <h4 class="tit_h4 line1_text line_h1">앨범 제목입니다.</h4>
            </div>
        </div>
        <div class="pt-3">
            <div class="att_img mb-4">
                <div class="rounded overflow-hidden">
                    <img src="./img/sample_img3.jpg" class="w-100">
                </div>
            </div>
        </div>

        <form action="" class="cmt_wr">
            <button type="button" class="btn btn-primary rounded-0 btn-block" onclick="history.back()">닫기</button>
        </form>
    </div>
</article>


<?php include_once("./inc/tail.php"); ?>
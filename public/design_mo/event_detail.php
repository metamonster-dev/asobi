<?php
$title = "아소비 이벤트";
$hd_bg = "6";
include_once("./inc/head.php");
include_once("./inc/head_style02.php");
?>

<article class="sub_pg">
    <div class="container pt-3 pb-5">
        <div class="pt-3 pb-4 mb-3 border-bottom">
            <h4 class="tit_h4 mb-3 line1_text line_h1">이벤트 제목입니다.</h4>
            <div class="d-flex align-items-center">
                <span class="ev_stat ev_1">진행중</span>
                <p class="fs_15 ml-3">이벤트 기간</p>  
                <p class="fs_15 ml-2">2022.03.11 ~ 2023.03.11</p>  
            </div>
        </div>
        <div class="pt-3">
            <div class="att_img mb-4">
                <div class="">
                    <img src="./img/sample_img12.jpg" class="w-100">
                </div>
            </div>
        </div>

        <form action="" class="cmt_wr input-group">
            <input type="text" class="form-control border-0 rounded-0 col-8" placeholder="댓글을 입력해주세요.">
            <button type="button" class="btn btn-primary rounded-0 col-4">등록</button>
        </form>
    </div>
</article>


<?php include_once("./inc/tail.php"); ?>
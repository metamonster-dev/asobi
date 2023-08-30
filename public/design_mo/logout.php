<?php
$title = "로그아웃";
$hd_bg = "8";
include_once("./inc/head.php");
include_once("./inc/head_style02.php");
?>

<article class="sub_pg">
    <div class="container pt-3 pb-5">
        <div class="mt-3 mb-5 rounded-lg bg-primary_bg p-3">
            <h3 class="tit_h3 p-3 fw_600 text-primary">01099999999</h3>
            <p class="fs_14 px-3 pb-3 line_h1_5 wh_pre">아이디가 로그아웃 됩니다.
                로그아웃 하시면 해당 아이디의 알림을 받으실 수 없습니다.</p>
        </div>
        <form action="">

            <div class="py-3">
                <button type="button" class="btn btn-block btn-primary mt-3" onclick="location.href='./login.php'">확인</button>
            </div>

        </form>
    </div>
</article>


<?php include_once("./inc/tail.php"); ?>
<?php
$title = "비밀번호 변경";
$hd_bg = "8";
include_once("./inc/head.php");
include_once("./inc/head_style03.php");
?>

<article class="sub_pg">
    <div class="container pt-3 pb-5">
        <div class="mt-3 mb-5 rounded-lg bg-primary_bg p-3">
            <p class="fs_14 p-3 line_h1_5 wh_pre">비밀번호는 4자리 이상의 숫자 또는
            문자이면 등록 가능합니다.</p>
        </div>
        <form action="">
            
            <div class="ip_wr mt-5">
                <div class="ip_tit">
                    <h5>새 비밀번호</h5>
                </div>
                <input type="password" class="form-control" placeholder="새 비밀번호를 입력해주세요.">
            </div>
            <div class="ip_wr mt-4 pb-3">
                <div class="ip_tit">
                    <h5>새 비밀번호 확인</h5>
                </div>
                <input type="password" class="form-control" placeholder="새 비밀번호를 다시 입력해주세요.">
            </div>

            <div class="py-5 mt-3">
                <button class="btn btn-block btn-primary" type="button" onclick="location.href='./mypage.php'">비밀번호 변경</button>
            </div>

        </form>
    </div>
</article>


<?php include_once("./inc/tail.php"); ?>
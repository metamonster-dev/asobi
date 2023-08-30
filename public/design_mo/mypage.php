<?php
$title = "내정보";
$hd_bg = "8";
include_once("./inc/head.php");
include_once("./inc/head_style02.php");
?>

<article class="sub_pg">
    <div class="container pt-3 pb-5">
        <div class="mt-3 mb-5 rounded-lg bg-primary_bg p-3">
            <h3 class="tit_h3 p-3 fw_600 text-primary">st_132895</h3>
            <p class="fs_14 px-3 pb-3 line_h1_5">사용하시는 아이디와 비밀번호로 여러 기기(다른 스마트폰)에서도 로그인하여 사용할 수 있습니다.</p>
        </div>
        <form action="">

            <div class="pf_img mx-auto">
                <div class="rect rounded-circle">
                    <img src="./img/sample_img1.png">
                </div>
                <button class="btn rounded-circle btn_pf"><img src="./img/ic_photo.png"></button>
            </div>

            <div class="ip_wr mt-5">
                <div class="ip_tit">
                    <h5>이름</h5>
                </div>
                <input type="text" class="form-control" placeholder="이름을 입력해주세요." value="홍길동">
            </div>
            <div class="ip_wr mt-4">
                <div class="ip_tit">
                    <h5>휴대폰번호</h5>
                </div>
                <input type="number" class="form-control" placeholder="휴대폰번호를 입력해주세요." value="01099999999">
            </div>
            <div class="ip_wr mt-4 pb-3">
                <div class="ip_tit d-flex align-items-center justify-content-between">
                    <h5>비밀번호</h5>
                    <a href="./reset_pw.php"><u>변경하기</u></a>
                </div>
                <input type="password" class="form-control" placeholder="비밀번호를 입력해주세요." value="99999999">
            </div>

            <div class="py-5 mt-3">
                <button type="button" class="btn btn-block btn-outline-light border bg-white text-light" onclick="location.href='./logout.php'">로그아웃</button>
            </div>

        </form>
    </div>
</article>


<?php include_once("./inc/tail.php"); ?>
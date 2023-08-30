<?php
$title = "로그인";
include_once("./inc/head.php");
?>

<article class="sub_pg login_pg pt-0">
    <div class="container">
        <div class="login_wr">
            <div class="logo_img text-center pb-5">
                <img src="./img/logo.svg" alt="아소비">
            </div>
            <form action="">
                <input type="text" class="form-control log_id mb-4" placeholder="아이디(전화번호)를 입력해주세요.">
                <input type="password" class="form-control log_pw" placeholder="비밀번호를 입력해주세요.">
                
                <div class="checks_wr pt-4 pb-3">
                    <div class="checks checks-sm">
                        <label>
                            <input type="checkbox" name="chk1">
                            <span class="ic_box"></span>
                            <div class="chk_p">
                                <p class="text-light">자동 로그인</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="py-5">
                    <button type="button" class="btn btn-primary btn-lg btn-block" onclick="location.href='./index.php'">로그인</button>
                </div>

                <div class="py-2 d-flex align-items-center justify-content-center">
                    <p class="border-right"><a href="./find_id.php" class="text-light mx-3">아이디 찾기</a></p>
                    <p class="border-right"><a href="./find_pw.php" class="text-light mx-3">비밀번호 찾기</a></p>
                    <p class=""><a href="./join.php" class="text-light mx-3">입회신청</a></p>
                </div>

            </form>
        </div>

        <div class="lg_btm">
            <button type="button" class="btn btn-block fs_13 fw_400 text-light h-100 rounded-0 border-right" onclick="location.href='./policy.php'">개인정보처리방침</button>
            <button type="button" class="btn btn-block fs_13 fw_400 text-light h-100 mt-0" onclick="location.href='./terms.php'">서비스 이용약관</button>
        </div>
    </div>

</article>


<?php include_once("./inc/tail.php"); ?>
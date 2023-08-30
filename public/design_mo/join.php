<?php
$title = "입회신청";
include_once("./inc/head.php");
include_once("./inc/head_style02.php");
?>

<article class="sub_pg">
    <div class="container pb-5">
        <form action="" class="py-5">
            <div class="ip_wr">
                <div class="ip_tit d-flex align-items-center justify-content-between">
                    <h5>교육원 선택</h5>
                </div>
                <div class="position-relative mb-4">
                    <input type="text" class="form-control custom-select m_select m_select2" placeholder="교육원 선택">
                    <ul class="m_select_list none_scroll_bar">
                        <li class="active">아소비 교육원</li>
                        <li>아소비 교육원1</li>
                        <li>아소비 교육원11</li>
                        <li>아소비 교육원12</li>
                        <li>아소비 교육원334</li>
                    </ul>
                </div>
            </div>
            <div class="ip_wr mt-4">
                <div class="ip_tit">
                    <h5>이름</h5>
                </div>
                <input type="text" class="form-control" placeholder="이름을 입력해주세요.">
            </div>
            <div class="ip_wr mt-4">
                <div class="ip_tit d-flex align-items-center justify-content-between">
                    <h5>생년월일</h5>
                </div>
                <input type="date" class="form-control">
            </div>
            <div class="ip_wr mt-4">
                <div class="ip_tit d-flex align-items-center justify-content-between">
                    <h5>성별 선택</h5>
                </div>
                <select class="form-control custom-select">
                    <option selected hidden>선택해주세요.</option>
                    <option value="1">남</option>
                    <option value="2">여</option>
                </select>
            </div>
            <div class="ip_wr mt-4">
                <div class="ip_tit">
                    <h5>학부모 이름</h5>
                </div>
                <input type="text" class="form-control" placeholder="학부모 이름을 입력해주세요.">
            </div>
            <div class="ip_wr mt-4">
                <div class="ip_tit">
                    <h5>학부모 휴대폰번호</h5>
                </div>
                <input type="number" class="form-control" placeholder="학부모 휴대폰번호를 입력해주세요.">
            </div>
            <div class="ip_wr mt-4">
                <div class="ip_tit">
                    <h5>주소</h5>
                </div>
                <div class="input-group-prepend mb-3">
                    <input type="text" class="form-control" placeholder="주소찾기를 해주세요.">
                    <button class="btn btn-primary ml-3">주소찾기</button>
                </div>
                    <input type="text" class="form-control" placeholder="상세주소를 입력해주세요.">
            </div>
            <div class="ip_wr mt-4">
                <div class="ip_tit">
                    <h5>인지경로</h5>
                </div>
                <input type="text" class="form-control" placeholder="인지경로를 입력해주세요.">
            </div>

            <div class="checks_wr py-5 mb-3">
                <div class="checks checks-sm">
                    <label>
                        <input type="checkbox" name="chk1" checked>
                        <span class="ic_box"></span>
                        <div class="chk_p">
                            <p class="">마케팅 수신 동의</p>
                        </div>
                    </label>
                </div>
            </div>

            <div class="py-3">
                <button class="btn btn-block btn-primary" type="button" onclick="location.href='./login.php'">입회신청</button>
            </div>

        </form>
    </div>

</article>


<?php include_once("./inc/tail.php"); ?>
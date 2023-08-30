<?php
$title = "공지사항 작성";
$hd_bg = "3";
include_once("./inc/head.php");
include_once("./inc/head_style02.php");
?>

<article class="sub_pg">
    <div class="container pt-3 pb-5">
        <form action="" class="mt-3">
            <div class="ip_wr">
                <div class="ip_tit">
                    <h5>구분</h5>
                </div>
                <div class="checks_wr">
                    <div class="checks">
                        <label>
                            <input type="checkbox" name="chk1" checked>
                            <span class="ic_box"></span>
                            <div class="chk_p">
                                <p>교육원</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="ip_wr mt-4">
                <div class="ip_tit">
                    <h5>제목</h5>
                </div>
                <input type="text" class="form-control" placeholder="입력해주세요.">
            </div>
            <div class="ip_wr mt-4">
                <div class="ip_tit">
                    <h5>내용</h5>
                </div>
                <textarea class="form-control" placeholder="내용을 입력해주세요" rows="5"></textarea>
            </div>
        </form>
        
        <div class="cmt_wr d-flex align-items-center">
            <button type="button" class="btn bg-primary_bg text-primary btn-block rounded-0">임시저장</button>
            <button type="button" class="btn btn-primary btn-block rounded-0 mt-0" onclick="location.href='./institute_notice1.php'">전송</button>
        </div>
    </div>
</article>


<?php include_once("./inc/tail.php"); ?>
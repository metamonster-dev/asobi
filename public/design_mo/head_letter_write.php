<?php
$title = "가정통신문 작성";
$hd_bg = "1";
include_once("./inc/head.php");
include_once("./inc/head_style02.php");
?>

<article class="sub_pg">
    <div class="container pt-3 pb-5">
        <form action="" class="mt-3 pb-3">
            <div class="ip_wr">
                <div class="ip_tit d-flex align-items-center justify-content-between">
                    <h5>작성일자</h5>
                </div>
                <input type="date" class="form-control text-dark_gray">
            </div>

            <div class="ip_wr mt-4">
                <div class="ip_tit d-flex align-items-center justify-content-between">
                    <h5>아소비 교육원 알림</h5>
                </div>
                <textarea class="form-control" placeholder="내용을 입력해주세요" rows="5"></textarea>
            </div>
            <div class="ip_wr mt-4">
                <div class="ip_tit d-flex align-items-center justify-content-between">
                    <h5>이번 달 수업에서</h5>
                </div>
                <textarea class="form-control" placeholder="내용을 입력해주세요" rows="5"></textarea>
            </div>
            
        </form>

        <div class="py-5">
            <button type="button" class="btn btn-primary btn-block mt-3" onclick="location.href='./head_note.php'">전송</button>
        </div>
    </div>
</article>



<?php include_once("./inc/tail.php"); ?>
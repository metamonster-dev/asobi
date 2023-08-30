<?php
$title = "상담일지 작성";
$hd_bg = "7";
include_once("./inc/head.php");
include_once("./inc/head_style02.php");
?>

<article class="sub_pg">
    <div class="container pt-3 pb-5">
        <form action="" class="mt-3">
            <div class="ip_wr">
                <div class="ip_tit d-flex align-items-center justify-content-between">
                    <h5>날짜 선택</h5>
                </div>
                <input type="date" class="form-control text-dark_gray">
            </div>
            
            <div class="ip_wr mt-4 pb-3">
                <div class="ip_tit">
                    <h5>상담일지 내용</h5>
                </div>
                <textarea class="form-control" placeholder="내용을 입력해주세요" rows="5"></textarea>
            </div>
            
            <div class="py-3 mt-5">
                <button type="button" class="btn btn-primary btn-block" onclick="location.href='./advice_detail.php'">전송</button>
            </div>
        </form>
        
    </div>
</article>

<script>
    $('.btn_preview').on('click',function(){
        location.href='./institute_notice_preview.php';
    });
</script>



<?php include_once("./inc/tail.php"); ?>
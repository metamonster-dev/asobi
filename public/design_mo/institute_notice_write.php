<?php
$title = "공지사항 작성";
$hd_bg = "3";
include_once("./inc/head.php");
include_once("./inc/head_style04.php");
?>

<article class="sub_pg">
    <div class="container pt-3 pb-5">
        <form action="" class="mt-3">
            <div class="ip_wr">
                <div class="ip_tit">
                    <h5>제목</h5>
                </div>
                <input type="text" class="form-control" placeholder="입력해주세요.">
            </div>
            <div class="ip_wr mt-4">
                <div class="ip_tit d-flex align-items-center justify-content-between">
                    <h5>작성일자</h5>
                </div>
                <input type="date" class="form-control text-dark_gray">
            </div>
            
            <div class="form-group ip_wr mt-4 mb-4">
                <div class="ip_tit d-flex align-items-center">
                    <h5 class="mr-3">사진·동영상</h5>
                    <p class="fs_13 text-light">4/20</p>
                </div>
                <div class="scroll_wrap none_scroll_bar">
                    <div class="input-group-prepend">
                        <div class="image-upload mr-3">
                            <label for="file-input">
                                <div class="upload-icon">
                                    <button class="btn del"></button>
                                </div>
                            </label>
                            <input id="file-input" type="file" />
                        </div>
                        <div class="image-upload on mr-3">
                            <label for="file-input">
                                <div class="upload-icon">
                                    <button class="btn del"></button>
                                    <img src="./img/sample_img3.jpg" alt="">
                                </div>
                            </label>
                            <input id="file-input" type="file" />
                        </div>
                        <div class="image-upload on mr-3">
                            <label for="file-input">
                                <div class="upload-icon">
                                    <button class="btn del"></button>
                                    <img src="./img/sample_img3.jpg" alt="">
                                </div>
                            </label>
                            <input id="file-input" type="file" />
                        </div>
                        <div class="image-upload on mr-3">
                            <label for="file-input">
                                <div class="upload-icon">
                                    <button class="btn del"></button>
                                    <img src="./img/sample_img3.jpg" alt="">
                                </div>
                            </label>
                            <input id="file-input" type="file" />
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="ip_wr mt-4">
                <div class="ip_tit d-flex align-items-center justify-content-between">
                    <h5>내용</h5>
                    <button type="button" class="btn p-0 h-auto"><img src="./img/ic_copy.png" style="width: 2rem;"></button>
                </div>
                <textarea class="form-control" placeholder="내용을 입력해주세요" rows="5"></textarea>
            </div>
        </form>
        
        <div class="cmt_wr d-flex align-items-center">
            <button type="button" class="btn bg-primary_bg text-primary btn-block rounded-0">임시저장</button>
            <button type="button" class="btn btn-primary btn-block rounded-0 mt-0" onclick="location.href='./institute_notice.php'">전송</button>
        </div>
    </div>
</article>

<script>
    $('.btn_preview').on('click',function(){
        location.href='./institute_notice_preview.php';
    });
</script>



<?php include_once("./inc/tail.php"); ?>
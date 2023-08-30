<?php
$title = "알림장 작성";
$hd_bg = "1";
include_once("./inc/head.php");
include_once("./inc/head_style04.php");
?>

<article class="sub_pg">
    <div class="container pt-3 pb-5">
        <form action="" class="mt-3">
            <div class="ip_wr">
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

            <div class="d-flex align-items-center justify-content-between mt-3 pt-3 mb-4">
                <div class="ip_wr">
                    <div class="ip_tit mb-0">
                        <h5>학생선택</h5>
                    </div>
                </div>
                <div class="checks_wr">
                    <div class="checks mr-0">
                        <label>
                            <input type="checkbox" name="chk1">
                            <span class="ic_box"></span>
                            <div class="chk_p">
                                <p>전체선택</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="note_stu_list_chk pb-5 mb-3">
                <label>
                    <input type="checkbox" class="d-none" name="chk1">
                    <div class="chk_li">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <span class="ic_box"></span>
                    </div>
                </label>
                <label>
                    <input type="checkbox" class="d-none" name="chk1">
                    <div class="chk_li">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <span class="ic_box"></span>
                    </div>
                </label>
                <label>
                    <input type="checkbox" class="d-none" name="chk1">
                    <div class="chk_li">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <span class="ic_box"></span>
                    </div>
                </label>
                <label>
                    <input type="checkbox" class="d-none" name="chk1">
                    <div class="chk_li">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <span class="ic_box"></span>
                    </div>
                </label>
                <label>
                    <input type="checkbox" class="d-none" name="chk1">
                    <div class="chk_li">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <span class="ic_box"></span>
                    </div>
                </label>
                <label>
                    <input type="checkbox" class="d-none" name="chk1">
                    <div class="chk_li">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <span class="ic_box"></span>
                    </div>
                </label>
                <label>
                    <input type="checkbox" class="d-none" name="chk1">
                    <div class="chk_li">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <span class="ic_box"></span>
                    </div>
                </label>
                <label>
                    <input type="checkbox" class="d-none" name="chk1">
                    <div class="chk_li">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <span class="ic_box"></span>
                    </div>
                </label>
                <label>
                    <input type="checkbox" class="d-none" name="chk1">
                    <div class="chk_li">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <span class="ic_box"></span>
                    </div>
                </label>
            </div>
        </form>
        
        <div class="cmt_wr d-flex align-items-center">
            <button type="button" class="btn bg-primary_bg text-primary btn-block rounded-0">임시저장</button>
            <button type="button" class="btn btn-primary btn-block rounded-0 mt-0" onclick="location.href='./institute_student_note.php'">전송</button>
        </div>
    </div>
</article>

<script>
    $('.btn_preview').on('click',function(){
        location.href='./institute_note_preview.php';
    });
</script>



<?php include_once("./inc/tail.php"); ?>
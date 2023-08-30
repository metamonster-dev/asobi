<?php
$title = "가정통신문 작성";
$hd_bg = "1";
include_once("./inc/head.php");
include_once("./inc/head_style04.php");
?>

<article class="sub_pg">
    <div class="container pt-3 pb-5">
        <form action="" class="mt-3">
            <div class="ip_wr">
                <div class="ip_tit d-flex align-items-center justify-content-between">
                    <h5>아소비 교육원 알림</h5>
                    <button type="button" class="btn p-0 h-auto"><img src="./img/ic_copy.png" style="width: 2rem;"></button>
                </div>
                <textarea class="form-control" placeholder="내용을 입력해주세요" rows="5"></textarea>
            </div>
            <div class="ip_wr mt-4">
                <div class="ip_tit d-flex align-items-center justify-content-between">
                    <h5>이번 달 수업에서</h5>
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
            <button type="button" class="btn btn-primary btn-block rounded-0 mt-0" onclick="location.href='./institute_note.php'">전송</button>
        </div>
    </div>
</article>

<script>
    $('.btn_preview').on('click',function(){
        location.href='./institute_letter_preview.php';
    });
</script>



<?php include_once("./inc/tail.php"); ?>
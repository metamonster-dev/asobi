<?php
$title = "알림장 상세";
$hd_bg = "1";
include_once("./inc/head.php");
include_once("./inc/head_style03.php");
?>

<article class="sub_pg">
    <div class="container pt-3 pb-5">
        <div class="pt-3 pb-4 mb-3 border-bottom d-flex align-items-center justify-content-between">
            <div>
                <h4 class="tit_h4 mb-3 line1_text line_h1">000의 선생님이 알립니다.</h4>
                <div class="d-flex align-items-center text-dark_gray fs_14 fw_300">
                    <p>2023.04.01 월요일</p>
                    <span class="px-2">|</span>
                    <p>2023.04.17 17:13 작성</p>
                </div>
            </div>
            <div class="position-relative">
                <button type="button" class="btn p-0 btn_more h-auto"><img src="./img/ic_more.png" style="width: 1.6rem;"></button>
                <ul class="more_cont">
                    <li><button class="btn">공유</button></li>
                    <li><button class="btn">수정</button></li>
                    <li><button class="btn">삭제</button></li>
                </ul>
            </div>
        </div>
        <div class="pt-3">
            <div class="att_img mb-4">
                <div class="rounded overflow-hidden">
                    <img src="./img/sample_img3.jpg" class="w-100">
                </div>
                <button type="button" class="btn btn_dl"><img src="./img/ic_download.svg"></button>
            </div>
            <p class="wh_pre fs_15 line_h1_4">군인·군무원·경찰공무원 기타 법률이 정하는 자가 전투·훈련등 직무집행과 관련하여 받은 손해에 대하여는 법률이 정하는 보상외에 국가 또는 공공단체에 공무원의 직무상 불법행위로 인한 배상은 청구할 수 없다.

            국가는 대외무역을 육성하며, 이를 규제·조정할 수 있다. 지방의회의 조직·권한·의원선거와 지방자치단체의 장의 선임방법 기타 지방자치단체의 조직과 운영에 관한 사항은 법률로 정한다.</p>
        </div>
        <hr class="line mb-3">
        <div class="pt-3 pb-4 mb-5">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center">
                    <img src="./img/ic_comment.png" style="width: 2.5rem;">
                    <p class="text-primary fs_18 ml-2">댓글</p>
                </div>
                <p class="text-dark_gray fs_14 fw_300">읽음여부<span class="ml-3">O</span></p>
            </div>
            <hr class="line2 mb-3"></hr>
            <!-- <div class="py-3">
                <div class="d-flex align-items-center justify-content-between cmt_tit">
                    <div class="d-flex align-items-center justify-content-start cmt_name">
                        <div class="rect rounded-circle mr-3">
                            <img src="./img/sample_img5.png">
                        </div>
                        <p class="line1_text fw_600 fs_15">익명인가</p>
                    </div>
                    <div class="position-relative">
                        <button type="button" class="btn p-0 btn_more h-auto"><img src="./img/ic_more2.png" style="width: 1.6rem;"></button>
                        <ul class="more_cont">
                            <li><button class="btn">수정</button></li>
                            <li><button class="btn">삭제</button></li>
                        </ul>
                    </div>

                </div>
                <p class="fs_14 line_h1_4 py-3 text-break">ㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋ ㅠㅠ 새옷인대 흙인가요..?</p>
                <div class="d-flex align-items-center justify-content-between pb-3">
                    <p class="fs_14 fw_300 text-light">2022.12.24 12:30</p>
                    <button type="button" class="btn btn_reply"><img src="./img/ic_comment2.png" style="width: 1.4rem;" class="mr-2">답글</button>
                </div>
                <div class="bg-light_gray reply_wr mt-3 py-3">
                    <div class="d-flex align-items-start justify-content-start container-fluid pt-3">
                        <img src="./img/ic_reply.png" style="width: 2rem;">
                        <div class="w-100 ml-3">
                            <div class="d-flex align-items-center justify-content-between cmt_tit">
                                <div class="d-flex align-items-center justify-content-start cmt_name">
                                    <div class="rect rounded-circle mr-3">
                                        <img src="./img/sample_img5.png">
                                    </div>
                                    <p class="line1_text fw_600 fs_15">익명인가</p>
                                </div>
                                <div class="position-relative">
                                    <button type="button" class="btn p-0 btn_more h-auto"><img src="./img/ic_more2.png" style="width: 1.6rem;"></button>
                                    <ul class="more_cont">
                                        <li><button class="btn">수정</button></li>
                                        <li><button class="btn">삭제</button></li>
                                    </ul>
                                </div>
                            </div>
                            <p class="fs_14 line_h1_4 py-3 text-break">편백나무 블럭입니다!!</p>
                            <div class="pb-3">
                                <p class="fs_14 fw_300 text-light">2022.12.24 12:30</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        <form action="" class="cmt_wr input-group">
            <input type="text" class="form-control border-0 rounded-0 col-8" placeholder="댓글을 입력해주세요.">
            <button type="button" class="btn btn-primary rounded-0 col-4">등록</button>
        </form>
    </div>
</article>


<?php include_once("./inc/tail.php"); ?>
<?php
$title = "공지사항 상세";
$hd_bg = "3";
include_once("./inc/head.php");
include_once("./inc/head_style03.php");
?>

<article class="sub_pg">
    <div class="container pt-3 pb-5">
        <div class="pt-3 pb-4 mb-3 border-bottom d-flex align-items-center justify-content-between">
            <div>
                <p class="text-dark_gray fs_13 fw_300 mb-2 line_h1_2"><span class="text-primary fw_500 mr-2">[교육원공지]</span> 2023.04.01 월요일</p>
                <h4 class="tit_h4 line1_text line_h1">공지사항 제목입니다.</h4>
            </div>
            <!-- 지사 학부모공지(교육원공지,본사공지)/본사 학부모공지(본사공지)에서 비표시 -->
            <div class="position-relative">
                <button type="button" class="btn p-0 btn_more h-auto"><img src="./img/ic_more.png" style="width: 1.6rem;"></button>
                <ul class="more_cont">
                    <li><button class="btn">수정</button></li>
                    <li><button class="btn">삭제</button></li>
                </ul>
            </div>
            <!-- // 지사 학부모공지(교육원공지,본사공지)/본사 학부모공지(본사공지)에서 비표시 -->
        </div>
        <div class="pt-3">
            <div class="att_img mb-4">
                <div class="rounded overflow-hidden">
                    <img src="./img/sample_img4.jpg" class="w-100">
                </div>
            </div>
            <p class="wh_pre fs_15 line_h1_4">군인·군무원·경찰공무원 기타 법률이 정하는 자가 전투·훈련등 직무집행과 관련하여 받은 손해에 대하여는 법률이 정하는 보상외에 국가 또는 공공단체에 공무원의 직무상 불법행위로 인한 배상은 청구할 수 없다.

            국가는 대외무역을 육성하며, 이를 규제·조정할 수 있다. 지방의회의 조직·권한·의원선거와 지방자치단체의 장의 선임방법 기타 지방자치단체의 조직과 운영에 관한 사항은 법률로 정한다.</p>
            
            <!-- 교육원 공지일 때만 표시 -->
            <div class="bg-light_gray p-3 rounded-lg mt-5">
                <p class="m-3 fs_14">읽지 않은 사람</p>
                <div class="m-3 fs_14"><span class="mr-3">홍길동</span><span class="mr-3">홍길동</span></div>
            </div>
            <div class="bg-light_gray p-3 rounded-lg mt-4">
                <p class="m-3 fs_14">읽은 사람</p>
                <div class="m-3 fs_14"><span class="mr-3">홍길동</span></div>
            </div>
            <!-- // 교육원 공지일 때만 표시 -->
        </div>
    </div>
</article>


<?php include_once("./inc/tail.php"); ?>
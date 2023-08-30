<?php
$title = "미리보기";
?>

<div class="modal_bg" id="noticePreview">
    <div class="modal_wrap md_preview w-100 mw-410">
        <div class="h_menu bg bg3">
            <button type="button" class="hd_menu_btn btn_back border-0 bg-transparent" onclick="modalHide('noticePreview')"></button>
            <div><h3 class="tit_h3 ff_lotte fw_400 line_h1"><?php echo $title ?></h3></div>
            <div class="hd_menu_btn"></div>
        </div>
        <div class="d-none d-lg-block text-center p-4 border-bottom">
            <h3 class="tit_h3 ff_lotte fw_400 line_h1 py-1"><?php echo $title ?></h3>
        </div>
        <article class="sub_pg">
            <div class="container">
                <div class="pb-4 mb-3 mb-lg-0 border-bottom d-flex flex-column">
                    <p class="text-dark_gray fs_13 fw_300 mb-2 line_h1_2"><span class="text-primary fw_500 mr-2" id="userTypeModal">[교육원공지]</span> <span id="ymdModal">2023.04.01 월요일</span></p>
                    <h4 class="tit_h4 line1_text line_h1" id="titleModal">공지사항 제목 입니다.</h4>
                </div>
                <div class="scroll_box mt-0 mt-lg-4 mb-0 mb-lg-4">
{{--                    <div class="att_img mb-4">--}}
{{--                        <div class="rounded overflow-hidden">--}}
{{--                            <img src="/img/sample_img4.jpg" class="w-100">--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <p class="wh_pre fs_15 line_h1_4" id="contentModal">군인·군무원·경찰공무원 기타 법률이 정하는 자가 전투·훈련등 직무집행과 관련하여 받은 손해에 대하여는 법률이 정하는 보상외에 국가 또는 공공단체에 공무원의 직무상 불법행위로 인한 배상은 청구할 수 없다.

                    국가는 대외무역을 육성하며, 이를 규제·조정할 수 있다. 지방의회의 조직·권한·의원선거와 지방자치단체의 장의 선임방법 기타 지방자치단체의 조직과 운영에 관한 사항은 법률로 정한다.</p>
                </div>
                <form action="" class="cmt_wr">
                    <button type="button" class="btn btn-primary btn-block close_btn" onclick="modalHide('noticePreview')">닫기</button>
                </form>
            </div>
        </article>
    </div>
</div>

<?php
$title = "미리보기";
?>

<div class="modal_bg" id="albumPreview">
    <div class="modal_wrap md_preview w-100 mw-410">
        <div class="h_menu bg bg2">
            <button type="button" class="hd_menu_btn btn_back border-0 bg-transparent" onclick="modalHide('albumPreview')"></button>
            <div><h3 class="tit_h3 ff_lotte fw_400 line_h1"><?php echo $title ?></h3></div>
            <div class="hd_menu_btn"></div>
        </div>
        <div class="d-none d-lg-block text-center p-4 border-bottom">
            <h3 class="tit_h3 ff_lotte fw_400 line_h1 py-1"><?php echo $title ?></h3>
        </div>
        <article class="sub_pg">
            <div class="container">
                <div class="pb-4 mb-3 mb-lg-0 border-bottom d-flex flex-column">
                    <p class="text-dark_gray fs_14 fw_300" id="ymdModal">날짜</p>
                    <h4 class="tit_h4 mt-3 line1_text line_h1" id="titleModal">제목</h4>
                </div>
                <div class="scroll_box mt-0 mt-lg-4 mb-0 mb-lg-4">
                    <div id="imageVideo"></div>
                </div>
                <form action="" class="cmt_wr">
                    <button type="button" class="btn btn-primary btn-block close_btn" onclick="modalHide('albumPreview')">닫기</button>
                </form>
            </div>
        </article>
    </div>
</div>
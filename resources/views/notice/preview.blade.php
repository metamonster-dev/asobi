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
                    <p class="text-dark_gray fs_13 fw_300 mb-2 line_h1_2"><span class="text-primary fw_500 mr-2">[<span id="typeModal"></span>공지]</span> <span id="ymdModal">날짜</span></p>
                    <h4 class="tit_h4 line1_text line_h1" id="titleModal">제목</h4>
                </div>
                <div class="scroll_box mt-0 mt-lg-4 mb-0 mb-lg-4">
                    <div id="imageVideo"></div>
                    <p class="editor_wrap fs_15" id="contentModal"></p>
                </div>
                <form action="" class="cmt_wr">
                    <button type="button" class="btn btn-primary btn-block close_btn" onclick="modalHide('noticePreview')">닫기</button>
                </form>
            </div>
        </article>
    </div>
</div>

<?php $back_link ?? $back_link = ""; ?>
<div class="h_menu bg8">
    <button type="button" class="hd_menu_btn btn_back border-0 bg-transparent" onclick=<?php echo $back_link ? "location.href='".$back_link."'" : "history.back()"?>></button>
    <div class=""><h3 class="tit_h3 ff_lotte fw_400 line_h1"><?php echo $title ?></h3></div>
    <button type="button" class="hd_menu_btn btn_set border-0 bg-transparent" onclick="location.href='/app'"></button>
</div>
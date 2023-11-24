<?php
$hd_bg ?? $hd_bg = "";
$back_link ?? $back_link = "";
$type ?? $type = '';
?>
<div <?php if ($hd_bg === '1') { ?> class="h_menu bg bg1" <?php } else if ($hd_bg === '2') { ?> class="h_menu bg bg2" <?php } else if ($hd_bg === '3') { ?> class="h_menu bg bg3" <?php } else if ($hd_bg === '4') { ?> class="h_menu bg bg4" <?php } else if ($hd_bg === '5') { ?> class="h_menu bg bg5" <?php } else if ($hd_bg === '6') { ?> class="h_menu bg bg6" <?php } else if ($hd_bg === '7') { ?> class="h_menu bg bg7" <?php } else if ($hd_bg === '8') { ?> class="h_menu bg8" <?php } else { ?> class="h_menu" <?php } ?>>
    <button type="button" class="hd_menu_btn btn_back border-0 bg-transparent back_button" onclick=<?php echo $back_link ? "location.href='".$back_link."'" : "history.back()"?>></button>
    <div class=""><h3 class="tit_h3 ff_lotte fw_400 line_h1"><?php echo $title ?></h3></div>
    <div class="position-relative hd_menu_btn">
        <?php if ($hd_bg === '1' && $type === '') { ?>
            <button type="button" class="btn btn-sm btn_preview btn-outline-primary text-primary bg-white" onclick="location.href='javascript:;'">미리보기</button>
        <?php } else if ($hd_bg === '2') { ?>
            <button type="button" class="btn btn-sm btn_preview btn-outline-secondary_bg text-secondary_bg bg-white" onclick="location.href='javascript:;'">미리보기</button>
        <?php } else if ($hd_bg === '3') { ?>
            <button type="button" class="btn btn-sm btn_preview btn-outline-success text-success bg-white" onclick="location.href='javascript:;'">미리보기</button>
        <?php } ?>
    </div>
</div>

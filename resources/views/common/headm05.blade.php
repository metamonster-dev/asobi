<?php $back_link ?? $back_link = ""; ?>
<div class="h_menu bg8">
    <button type="button" class="hd_menu_btn btn_back border-0 bg-transparent back_button" onclick=<?php echo $back_link ? "location.href='".$back_link."'" : "history.back()"?>></button>

    <div class=""><h3 class="tit_h3 ff_lotte fw_400 line_h1"><?php echo $title ?></h3></div>
    <button type="button" class="hd_menu_btn btn_set border-0 bg-transparent" onclick="location.href='/app'"></button>
</div>

<script>
    // document.querySelectorAll('.hd_menu_btn').forEach(function(element) {
    //     element.addEventListener('click', function(event) {
    //         $('#loading').show();
    //     });
    // });

    // document.querySelectorAll('.temp').forEach(function(element) {
    //     element.addEventListener('click', function(event) {
    //         $('#loading').show();
    //     });
    // });

    // document.querySelector('.temp').addEventListener('click', function () {
    //     console.log(1);
    //     $('#loading').show();
    //     console.log(2);
    // })
</script>

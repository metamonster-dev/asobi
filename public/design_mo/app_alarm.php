<?php
$title = "알림 설정";
$hd_bg = "8";
include_once("./inc/head.php");
include_once("./inc/head_style03.php");
?>

<article class="sub_pg">
    <div class="container pt-3 pb-5">
        <div class="py-3">
            <ul>
                <li class="d-flex align-items-center justify-content-between p-4 border rounded-lg mb-4">
                    <p class="fw_700">알림장</p>
                    <div class="toggle_wr py-2">
                        <input type="checkbox" id="toggle1" checked> 
                        <label for="toggle1" class="toggle_switch">
                            <span class="toggle_btn"></span>
                        </label>
                    </div>
                </li>
                <li class="d-flex align-items-center justify-content-between p-4 border rounded-lg mb-4">
                    <p class="fw_700">앨범</p>
                    <div class="toggle_wr py-2">
                        <input type="checkbox" id="toggle2"> 
                        <label for="toggle2" class="toggle_switch">
                            <span class="toggle_btn"></span>
                        </label>
                    </div>
                </li>
                <li class="d-flex align-items-center justify-content-between p-4 border rounded-lg mb-4">
                    <p class="fw_700">출석부</p>
                    <div class="toggle_wr py-2">
                        <input type="checkbox" id="toggle3"> 
                        <label for="toggle3" class="toggle_switch">
                            <span class="toggle_btn"></span>
                        </label>
                    </div>
                </li>
                <li class="d-flex align-items-center justify-content-between p-4 border rounded-lg mb-4">
                    <p class="fw_700">공지사항</p>
                    <div class="toggle_wr py-2">
                        <input type="checkbox" id="toggle4"> 
                        <label for="toggle4" class="toggle_switch">
                            <span class="toggle_btn"></span>
                        </label>
                    </div>
                </li>
                <li class="d-flex align-items-center justify-content-between p-4 border rounded-lg mb-4">
                    <p class="fw_700">교육정보</p>
                    <div class="toggle_wr py-2">
                        <input type="checkbox" id="toggle5"> 
                        <label for="toggle5" class="toggle_switch">
                            <span class="toggle_btn"></span>
                        </label>
                    </div>
                </li>
                <li class="d-flex align-items-center justify-content-between p-4 border rounded-lg mb-4">
                    <p class="fw_700">이벤트</p>
                    <div class="toggle_wr py-2">
                        <input type="checkbox" id="toggle6"> 
                        <label for="toggle6" class="toggle_switch">
                            <span class="toggle_btn"></span>
                        </label>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</article>


<?php include_once("./inc/tail.php"); ?>
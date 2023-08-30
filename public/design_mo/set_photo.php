<?php
$title = "사진 / 동영상 설정";
$hd_bg = "8";
include_once("./inc/head.php");
include_once("./inc/head_style03.php");
?>

<article class="sub_pg">
    <div class="container pt-3 pb-5">
        <div class="py-3">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <p class="fw_700">WI-FI 연결확인</p>
                <div class="toggle_wr">
                    <input type="checkbox" id="toggle" checked> 
                    <label for="toggle" class="toggle_switch">
                        <span class="toggle_btn"></span>
                    </label>
                </div>
            </div>
            <p class="fs_13 text-light pb-4 pt-1">WI-FI 연결 상태 확인 경고창 설정</p>
            <div class="rounded-lg bg-light_gray p-3">
                <p class="p-3 wh_pre text-light fs_13 line_h1_2">WI-FI 연결 확인을 꺼두시면 모든 네트워크 상황에서
                데이터 상태 확인 없이 동영상 재생/다운로드가 진행됩니다. 

                가입하신 데이터 요금제에 따라 통화료가 과도하게 부과될 수 있어, 확인을 켜두시는 것을 권장합니다.</p>
            </div>
        </div>
    </div>
</article>


<?php include_once("./inc/tail.php"); ?>
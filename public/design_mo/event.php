<?php
$title = "아소비 이벤트";
$hd_bg = "6";
include_once("./inc/head.php");
include_once("./inc/head_style02.php");
?>

<article class="sub_pg">
    <div class="container pt-3 pb-5">
        <ul class="event_list mt-3">
            <li>
                <a href="./event_detail.php">
                    <div class="rect rect4 rounded-lg">
                        <img src="./img/sample_img10.jpg">
                    </div>
                    <div class="d-flex align-items-center mt-3">
                        <span class="ev_stat ev_1">진행중</span>
                        <p class="fs_15 ml-3">2022.03.11 ~ 2023.03.11</p>  
                    </div>
                </a>
            </li>
            <li>
                <a href="./event_detail.php">
                    <div class="rect rect4 rounded-lg">
                        <img src="./img/sample_img11.jpg">
                    </div>
                    <div class="d-flex align-items-center mt-3">
                        <span class="ev_stat ev_2">마감</span>
                        <p class="fs_15 ml-3">2022.03.11 ~ 2023.03.11</p>  
                    </div>
                </a>
            </li>
        </ul>
    </div>
</article>


<?php include_once("./inc/tail.php"); ?>
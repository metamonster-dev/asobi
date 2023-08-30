<?php
$title = "상담일지";
$hd_bg = "7";
include_once("./inc/head.php");
include_once("./inc/head_style02.php");
?>

<article class="sub_pg sub_bg sub_bg7">
    <div class="container-fluid pt-5 pb-5">
        <form action="">
            <h2 class="tit_h2 ff_lotte fw_500 pb-3 position-relative z_2">상담일지<img src="./img/ic_tit.png" class="tit_img"></h2>
            <div class="m_top pt-3">
                <div class="input-group">
                    <input type="date" class="form-control form-control-lg col-6">
                    <div class="position-relative gr_r">
                        <input type="text" class="form-control bg-white custom-select m_select" value="홍길동">
                        <ul class="m_select_list none_scroll_bar">
                            <li>전체</li>
                            <li class="active">홍길동</li>
                            <li>홍길동1</li>
                            <li>2홍길동</li>
                            <li>3김길동</li>
                        </ul>
                    </div>
                </div>
                <div class="m_top_ico">
                    <img src="./img/m5_top.png">
                </div>
            </div>
            <div class="adv_cont rounded-lg border">
                <p class="fs_13 fw_300 text-dark_gray mt-1">2023.04.01</p>
                <p class="fs_15 wh_pre py-3 line_h1_4">군인·군무원·경찰공무원 기타 법률이 정하는 자가 전투·훈련등 직무집행과 관련하여 받은 손해에 대하여는 법률이 정하는 보상외에 국가 또는 공공단체에 공무원의 직무상 불법행위로 인한 배상은 청구할 수 없다.

                국가는 대외무역을 육성하며, 이를 규제·조정할 수 있다. 지방의회의 조직·권한·의원선거와 지방자치단체의 장의 선임방법 기타 지방자치단체의 조직과 운영에 관한 사항은 법률로 정한다.</p>
                <div class="d-flex align-items-center justify-content-end">
                    <button type="button" class="btn btn-sm btn-light mr-3">삭제</button>
                    <button type="button" class="btn btn-sm btn-outline-light" onclick="location.href='./advice_write.php'">수정</button>
                </div>
            </div>
        </form>
        
        <div class="f_btn_wr">
            <button type="button" class="btn float_btn" onclick="location.href='./advice_write.php'"><img src="./img/ic_write.png" style="width: 3rem;"></button>
        </div>
    </div>
</article>

<?php include_once("./inc/tail.php"); ?>
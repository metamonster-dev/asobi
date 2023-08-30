<?php
$title = "출석부 관리";
$hd_bg = "4";
include_once("./inc/head.php");
include_once("./inc/head_style02.php");
?>

<article class="sub_pg sub_bg sub_bg4">
    <div class="container-fluid pt-5 pb-5">
        <form action="">
            <h2 class="tit_h2 ff_lotte fw_500 pb-3 position-relative z_2">날짜를 선택해 주세요.<img src="./img/ic_tit.png" class="tit_img"></h2>
            <div class="m_top pt-3">
                <div class="input-group">
                    <input type="date" class="form-control col-6">
                    <select class="form-control form-control-md bg-white custom-select m_select">
                        <option selected>전체</option>
                        <option value="1">1일</option>
                        <option value="2">2일</option>
                        <option value="3">3일</option>
                    </select>
                </div>
                <div class="m_top_ico">
                    <img src="./img/m4_top.png">
                </div>
            </div>

            <!-- 전체선택시 -->
            <ul class="note_stu_list attend_list pb-5">
                <li>
                    <a href="./institute_attend_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p class="fs_16 text-right">0 / 16일</p>
                    </a>
                </li>
                <li>
                    <a href="./institute_attend_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p class="fs_16 text-right">0 / 16일</p>
                    </a>
                </li>
                <li>
                    <a href="./institute_attend_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p class="fs_16 text-right">0 / 16일</p>
                    </a>
                </li>
                <li>
                    <a href="./institute_attend_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p class="fs_16 text-right">0 / 16일</p>
                    </a>
                </li>
                <li>
                    <a href="./institute_attend_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p class="fs_16 text-right">0 / 16일</p>
                    </a>
                </li>
                <li>
                    <a href="./institute_attend_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p class="fs_16 text-right">0 / 16일</p>
                    </a>
                </li>
                <li>
                    <a href="./institute_attend_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p class="fs_16 text-right">0 / 16일</p>
                    </a>
                </li>
                <li>
                    <a href="./institute_attend_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p class="fs_16 text-right">0 / 16일</p>
                    </a>
                </li>
                <li>
                    <a href="./institute_attend_detail.php">
                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                <img src="./img/sample_img1.png">
                            </div>
                            <p class="fs_16 fw_700 ml-3">홍길동</p>
                        </div>
                        <p class="fs_16 text-right">0 / 16일</p>
                    </a>
                </li>
            </ul>
            <!-- // 전체선택시 -->

            <!-- 날짜선택시 -->
            <!-- <ul class="note_stu_list pb-5">
                <li>
                    <div class="d-flex align-items-center">
                        <div class="rect rounded-circle">
                            <img src="./img/sample_img1.png">
                        </div>
                        <p class="fs_16 fw_700 ml-3 line_text line1_text">홍길동</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center pr-2 pr-sm-3">
                            <p class="fs_14 mr-2">등원 </p>
                            <div class="toggle_wr">
                                <input type="checkbox" id="toggle1" checked> 
                                <label for="toggle1" class="toggle_switch">
                                    <span class="toggle_btn"></span>
                                </label>
                            </div>
                        </div>
                        <div class="d-flex align-items-center pl-2 pl-sm-3">
                            <p class="fs_14 mr-2">하원 </p>
                            <div class="toggle_wr">
                                <input type="checkbox" id="toggle2"> 
                                <label for="toggle2" class="toggle_switch">
                                    <span class="toggle_btn"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="d-flex align-items-center">
                        <div class="rect rounded-circle">
                            <img src="./img/sample_img1.png">
                        </div>
                        <p class="fs_16 fw_700 ml-3 line_text line1_text">홍길동</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center pr-2 pr-sm-3">
                            <p class="fs_14 mr-2">등원 </p>
                            <div class="toggle_wr">
                                <input type="checkbox" id="toggle1" checked> 
                                <label for="toggle1" class="toggle_switch">
                                    <span class="toggle_btn"></span>
                                </label>
                            </div>
                        </div>
                        <div class="d-flex align-items-center pl-2 pl-sm-3">
                            <p class="fs_14 mr-2">하원 </p>
                            <div class="toggle_wr">
                                <input type="checkbox" id="toggle2"> 
                                <label for="toggle2" class="toggle_switch">
                                    <span class="toggle_btn"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="d-flex align-items-center">
                        <div class="rect rounded-circle">
                            <img src="./img/sample_img1.png">
                        </div>
                        <p class="fs_16 fw_700 ml-3 line_text line1_text">홍길동</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center pr-2 pr-sm-3">
                            <p class="fs_14 mr-2">등원 </p>
                            <div class="toggle_wr">
                                <input type="checkbox" id="toggle1" checked> 
                                <label for="toggle1" class="toggle_switch">
                                    <span class="toggle_btn"></span>
                                </label>
                            </div>
                        </div>
                        <div class="d-flex align-items-center pl-2 pl-sm-3">
                            <p class="fs_14 mr-2">하원 </p>
                            <div class="toggle_wr">
                                <input type="checkbox" id="toggle2"> 
                                <label for="toggle2" class="toggle_switch">
                                    <span class="toggle_btn"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="d-flex align-items-center">
                        <div class="rect rounded-circle">
                            <img src="./img/sample_img1.png">
                        </div>
                        <p class="fs_16 fw_700 ml-3 line_text line1_text">홍길동</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center pr-2 pr-sm-3">
                            <p class="fs_14 mr-2">등원 </p>
                            <div class="toggle_wr">
                                <input type="checkbox" id="toggle1" checked> 
                                <label for="toggle1" class="toggle_switch">
                                    <span class="toggle_btn"></span>
                                </label>
                            </div>
                        </div>
                        <div class="d-flex align-items-center pl-2 pl-sm-3">
                            <p class="fs_14 mr-2">하원 </p>
                            <div class="toggle_wr">
                                <input type="checkbox" id="toggle2"> 
                                <label for="toggle2" class="toggle_switch">
                                    <span class="toggle_btn"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="d-flex align-items-center">
                        <div class="rect rounded-circle">
                            <img src="./img/sample_img1.png">
                        </div>
                        <p class="fs_16 fw_700 ml-3 line_text line1_text">홍길동</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center pr-2 pr-sm-3">
                            <p class="fs_14 mr-2">등원 </p>
                            <div class="toggle_wr">
                                <input type="checkbox" id="toggle1" checked> 
                                <label for="toggle1" class="toggle_switch">
                                    <span class="toggle_btn"></span>
                                </label>
                            </div>
                        </div>
                        <div class="d-flex align-items-center pl-2 pl-sm-3">
                            <p class="fs_14 mr-2">하원 </p>
                            <div class="toggle_wr">
                                <input type="checkbox" id="toggle2"> 
                                <label for="toggle2" class="toggle_switch">
                                    <span class="toggle_btn"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="d-flex align-items-center">
                        <div class="rect rounded-circle">
                            <img src="./img/sample_img1.png">
                        </div>
                        <p class="fs_16 fw_700 ml-3 line_text line1_text">홍길동</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center pr-2 pr-sm-3">
                            <p class="fs_14 mr-2">등원 </p>
                            <div class="toggle_wr">
                                <input type="checkbox" id="toggle1" checked> 
                                <label for="toggle1" class="toggle_switch">
                                    <span class="toggle_btn"></span>
                                </label>
                            </div>
                        </div>
                        <div class="d-flex align-items-center pl-2 pl-sm-3">
                            <p class="fs_14 mr-2">하원 </p>
                            <div class="toggle_wr">
                                <input type="checkbox" id="toggle2"> 
                                <label for="toggle2" class="toggle_switch">
                                    <span class="toggle_btn"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="d-flex align-items-center">
                        <div class="rect rounded-circle">
                            <img src="./img/sample_img1.png">
                        </div>
                        <p class="fs_16 fw_700 ml-3 line_text line1_text">홍길동</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center pr-2 pr-sm-3">
                            <p class="fs_14 mr-2">등원 </p>
                            <div class="toggle_wr">
                                <input type="checkbox" id="toggle1" checked> 
                                <label for="toggle1" class="toggle_switch">
                                    <span class="toggle_btn"></span>
                                </label>
                            </div>
                        </div>
                        <div class="d-flex align-items-center pl-2 pl-sm-3">
                            <p class="fs_14 mr-2">하원 </p>
                            <div class="toggle_wr">
                                <input type="checkbox" id="toggle2"> 
                                <label for="toggle2" class="toggle_switch">
                                    <span class="toggle_btn"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="d-flex align-items-center">
                        <div class="rect rounded-circle">
                            <img src="./img/sample_img1.png">
                        </div>
                        <p class="fs_16 fw_700 ml-3 line_text line1_text">홍길동</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center pr-2 pr-sm-3">
                            <p class="fs_14 mr-2">등원 </p>
                            <div class="toggle_wr">
                                <input type="checkbox" id="toggle1" checked> 
                                <label for="toggle1" class="toggle_switch">
                                    <span class="toggle_btn"></span>
                                </label>
                            </div>
                        </div>
                        <div class="d-flex align-items-center pl-2 pl-sm-3">
                            <p class="fs_14 mr-2">하원 </p>
                            <div class="toggle_wr">
                                <input type="checkbox" id="toggle2"> 
                                <label for="toggle2" class="toggle_switch">
                                    <span class="toggle_btn"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="d-flex align-items-center">
                        <div class="rect rounded-circle">
                            <img src="./img/sample_img1.png">
                        </div>
                        <p class="fs_16 fw_700 ml-3 line_text line1_text">홍길동</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center pr-2 pr-sm-3">
                            <p class="fs_14 mr-2">등원 </p>
                            <div class="toggle_wr">
                                <input type="checkbox" id="toggle1" checked> 
                                <label for="toggle1" class="toggle_switch">
                                    <span class="toggle_btn"></span>
                                </label>
                            </div>
                        </div>
                        <div class="d-flex align-items-center pl-2 pl-sm-3">
                            <p class="fs_14 mr-2">하원 </p>
                            <div class="toggle_wr">
                                <input type="checkbox" id="toggle2"> 
                                <label for="toggle2" class="toggle_switch">
                                    <span class="toggle_btn"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
            </ul> -->
            <!-- // 날짜선택시 -->

        </form>
        
    </div>
</article>

<?php include_once("./inc/tail.php"); ?>
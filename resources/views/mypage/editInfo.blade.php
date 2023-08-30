@extends('layout.home')
@section('bodyAttr')
class="body"
@endsection
@section('contents')
<?php
$n_menu = "2";
$title = "회원정보 수정";
$hd_bg = "8";
$back_link = "/mypage";
?>
@include('common.headm03')

<article class="sub_pg">
    <div class="container container-372 pt-5 pt_lg_50">
        <div>
            <form name="editInfoForm" id="editInfoForm" method="POST" action="/mypage/editInfoAction" onsubmit="return edit_form_chk(this);">
                <div class="ip_wr">
                    <div class="ip_tit">
                        <h5>이름</h5>
                    </div>
                    <input type="text" name="name" id="name" value="{{ $row['user_name'] ?? '' }}" class="form-control" placeholder="이름을 입력해주세요.">
                </div>
                <div class="ip_wr mt-4">
                    <div class="ip_tit d-flex align-items-center justify-content-between">
                        <h5>생년월일</h5>
                    </div>
                    <input type="date" name="birth" id="birth" value="{{ $row['birthday'] ?? '' }}" class="form-control">
                </div>
                <div class="ip_wr mt-4">
                    <div class="ip_tit d-flex align-items-center justify-content-between">
                        <h5>성별 선택</h5>
                    </div>
                    <select name="sex" class="form-control custom-select">
                        <option value="" hidden>선택해주세요.</option>
                        <option value="M" @if($row['gender'] == 'M') selected @endif>남</option>
                        <option value="F" @if($row['gender'] == 'F') selected @endif>여</option>
                    </select>
                </div>
                <div class="ip_wr mt-4">
                    <div class="ip_tit">
                        <h5>학부모 이름</h5>
                    </div>
                    <input type="text" name="parent_name" id="parent_name" value="{{ $row['parent_name'] ?? '' }}" class="form-control" placeholder="학부모 이름을 입력해주세요.">
                </div>
            </div>
            <div>
                <div class="ip_wr mt-4">
                    <div class="ip_tit">
                        <h5>학부모 휴대폰번호</h5>
                    </div>
                    <input type="text" name="parent_contact" id="parent_contact" value="{{ $row['phone'] ?? '' }}" class="form-control phoneHypen" placeholder="학부모 휴대폰번호를 입력해주세요.">
                </div>
                <div class="ip_wr mt-4">
                    <div class="ip_tit">
                        <h5>주소</h5>
                    </div>
                    <div class="input-group-prepend mb-3" onclick="DaumPostcode('adress', 'adress_desc', 'zip_wrap');">
                        <input type="text" name="adress" id="adress" value="{{ $row['address'] ?? '' }}" class="form-control" placeholder="주소찾기를 해주세요." readonly>
                        <button type="button" class="btn btn-primary ml-3">주소찾기</button>
                    </div>
                    <div id="zip_wrap" class="mb-3" style="display:none;border:1px solid;width:100%;height:300px;margin:5px 0;position:relative">
                        <img src="//i1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode('zip_wrap')" alt="접기 버튼">
                    </div>
                    <input type="text" name="adress_desc" id="adress_desc" value="{{ $row['address_detail'] ?? '' }}" class="form-control" placeholder="상세주소를 입력해주세요.">
                </div>
                <div class="ip_wr mt-4">
                    <div class="ip_tit">
                        <h5>인지경로</h5>
                    </div>
                    <input type="text" name="cognitive_pathway" id="cognitive_pathway" value="{{ $row['cognitive_pathway'] ?? '' }}" class="form-control" placeholder="인지경로를 입력해주세요.">
                </div>
                <div class="checks_wr pt-4">
                    <div class="checks checks-sm">
                        <label>
                            <input type="checkbox" name="marketing" id="marketing" value="Y" @if($row['marketing_consent'] == 'Y') checked @endif>
                            <span class="ic_box"></span>
                            <div class="chk_p">
                                <p class="">마케팅 수신 동의</p>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="pt-5 mt-3">
                    <button class="btn btn-block btn-primary" type="submit">수정하기</button>
                </div>
            </form>
        </div>
    </div>
</article>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="/js/searchAddr.js"></script>
<script>
    function edit_form_chk(f) {
        if(f.name.value=="") {
            jalert("이름을 입력해주세요.");
            f.name.focus();
            return false;
        }
        if(f.birth.value=="") {
            jalert("생년월일을 입력해주세요.");
            f.birth.focus();
            return false;
        }
        if(f.sex.value=="") {
            jalert("성별을 선택해주세요.");
            f.sex.focus();
            return false;
        }
        if(f.parent_name.value=="") {
            jalert("학부모 이름을 입력해주세요.");
            f.parent_name.focus();
            return false;
        }
        if(f.parent_contact.value=="") {
            jalert("학부모 휴대폰번호를 입력해주세요.");
            f.parent_contact.focus();
            return false;
        }
        if(f.adress.value=="") {
            jalert("주소찾기를 해주세요.");
            f.adress.focus();
            return false;
        }
        if(f.adress_desc.value=="") {
            jalert("상세주소를 입력해주세요.");
            f.adress_desc.focus();
            return false;
        }
        if(f.cognitive_pathway.value=="") {
            jalert("인지경로를 입력해주세요.");
            f.cognitive_pathway.focus();
            return false;
        }
        // if(!f.marketing.checked) {
        //     jalert("마케팅 수신 동의 체크해주세요.");
        //     f.marketing.focus();
        //     return false;
        // }

        return true;
    }
</script>

@endsection
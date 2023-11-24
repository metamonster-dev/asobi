@extends('layout.full')
@section('bodyAttr')
class="body m_view"
@endsection
@section('contents')
<?php
$title = "비밀번호 찾기";
$back_link = "/auth/login";
?>
@include('common.headm02')

<article class="sub_pg">
    <div class="container pb-5">
        <div class="py-5 line_h1_5">
            <p class="text-primary">비밀번호 찾기에 필요한 아이디는 st_로 시작하는 고유 아이디 입니다.</p>
            <p class="wh_pre">등록한 아이디를 모르시거나 잘못된 경우 <br/>교육원 원장님을 통해 확인 가능합니다.</p>
        </div>
        <form name="selectAction" id="selectAction" class="pb-3" method="POST" action="/auth/findPwAction">
            <div class="ip_wr">
                <div class="ip_tit">
                    <h5>아이디</h5>
                    <p class="fs_14 text-light mt-1">st_로 시작하는 고유 아이디를 입력해주세요.</p>
                </div>
                <input type="text" name="login_id" class="form-control" placeholder="입력해주세요.">
            </div>
            <div class="ip_wr mt-4">
                <div class="ip_tit">
                    <h5>휴대폰번호</h5>
                </div>
                <input type="text" name="phone" class="form-control phoneHypen" placeholder="휴대폰번호를 입력해주세요.">
            </div>
            <div class="py-3 mt-5">
                <button class="btn btn-block btn-primary" type="submit">임시 비밀번호 발송</button>
            </div>
        </form>
    </div>
</article>

@endsection

@extends('layout.full')
@section('bodyAttr')
class="body m_view"
@endsection
@section('contents')
<?php
$title = "아이디 찾기";
$back_link = "/auth/login";
?>
@include('common.headm02')

<article class="sub_pg">
    <div class="container pb-5">
        <div class="py-5 mb-3 line_h1_5">
            <p class="text-primary">아소비 앱의 아이디는 학부모님의 휴대폰번호 입니다.</p>
            <p class="wh_pre">등록한 휴대폰번호를 모르시거나 잘못된 경우 </br/>교육원 원장님을 통해 확인 가능합니다.</p>
        </div>
        <div class="py-3">
            <button class="btn btn-block btn-primary" onclick="location.href='/auth/login'">확인</button>
        </div>
    </div>
</article>

@endsection

@extends('layout.home')
@section('bodyAttr')
class="body"
@endsection
@section('contents')
<?php
$n_menu = '3';
// 학부모일 경우, $title="자녀목록";
// 교육원일 경우, $title="회원목록";
// $title = "회원목록";
$back_link = "/";
?>
@php
    if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='s') $title = "자녀목록";
    else $title = "회원목록";
@endphp
@include('common.headm05')

<article class="sub_pg">
    <div class="container pt-5 pt_lg_50">
        <h1 class="tit_h1 ff_lotte fw_500 pb-5 d-none d-lg-block">
            <?=$title ?? ''?>
            <img src="/img/ic_tit.png" class="tit_img">
        </h1>
        <div class="pb-5">
            @if(count($list) > 0)
            <div class="stu_list_chk student_list">
                <!--
                    ※ 권한별
                    1. 교육원일 경우, 리스트만 뿌려줌
                    2. 학부모일 경우, 클릭시 선택한 아이 계정으로 변경됨
                -->
                @foreach($list as $l)
                    <label @if(isset(session('auth')['user_type']) && session('auth')['user_type'] !='s') class="cursor_default" @endif>
                        @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='s')
                            <input type="radio" class="d-none children" name="chk1" value="{{ $l['id'] ?? '' }}" @if(isset(session('auth')['user_id']) && session('auth')['user_id'] == $l['id']) checked @endif>
                        @endif

                        <div class="d-flex align-items-center">
                            <div class="rect rounded-circle">
                                @if(isset($l['profile_image']) && $l['profile_image'] !='')
                                    <img src="{{ $l['profile_image'] ?? '' }}" alt="프로필이미지">
                                @else
                                    <img src="/img/profile_default.png" alt="프로필이미지">
                                @endif
                            </div>
                            <div class="ml-4 w-100">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h2 class="tit_h2 ff_lotte fw_500 line_text line1_text">{{ $l['name'] ?? '' }}</h2>
                                    @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='s')
                                        <span class="ic_box mr-0"></span>
                                    @endif
                                </div>
                                <p class="fs_14 text-dark_gray mb-1">{{ $l['birthday'] ?? '' }}</p>
                                <div class="fs_14 stu_chk_dt text-dark_gray d-flex align-items-center flex-wrap">
                                    <p class="my-1">{{ $l['branch_name'] ?? '' }}</p>
                                    @if($l['branch_name'] && $l['center_name'])
                                    <span class="mx-2 border-right" style="height: 1.1rem;"></span>
                                    @endif
                                    <p class="my-1">{{ $l['center_name'] ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>
            @else
            <div class="nodata">
                <p>조회된 학생이 없습니다.</p>
            </div>
            @endif
        </div>

        @if(isset(session('auth')['user_type']) && session('auth')['user_type'] !=='s')
        <!-- 교육원일 경우, 아래의 FAQ 버튼 노출 -->
        <div class="f_btn_wr bottom px-3 px-lg-5 d-block d-lg-none">
            <a href="/faq" class="d-block px-3 px-lg-0">
                <div class="d-flex align-items-center justify-content-between bg-light_gray rounded btm_sh p-4">
                    <p class="fs_18">FAQ</p>
                    <img src="/img/ic_arrow_right_b.png" style="width: 2rem;">
                </div>
            </a>
        </div>
        @endif
    </div>
</article>

<form name="selectAction" id="selectAction" method="POST" action="/student/changeAction">
    <input type="hidden" name="user" value=""/>
</form>

<div class="loading_wrap" id="loading" style="display: none">
    <div class="loading_text">
        <i class="loading_circle"></i>
        <span>로딩중</span>
    </div>
</div>

<script>
function changeAction(id) {
    let f = $('#selectAction');
    f.find('input[name=user]').val(id);
    f.submit();
}
$(document).ready(function(){
    $('.children').change(function (e) {
        $('#loading').show();

        let value = $(this).val();
        changeAction(value);
{{--    @if(isset(session('auth')['device_kind']) && session('auth')['device_kind'] == 'web')--}}
{{--        changeAction(value);--}}
{{--    @else--}}
{{--        window.webViewBridge.send('webviewChange', {}, function(res) {--}}
{{--            alert(res)--}}
{{--            console.log(res);--}}
{{--            // changeAction(value);--}}
{{--        }, function(err) {--}}
{{--            // console.error(err);--}}
{{--        });--}}
{{--    @endif--}}
    });
});
</script>
@endsection

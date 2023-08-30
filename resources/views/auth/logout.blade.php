<?php
$mdTitle = "로그아웃";
?>

<script>
    function logout() {
        location.href='/auth/logout';

        // ycommon.clearData();
        {{--document.addEventListener('message', (event) => {--}}
        {{--    const data = JSON.parse(event.data);--}}
        {{--    // alert(data.msg);--}}
        {{--    location.href='/auth/logout';--}}

        {{--});--}}

        {{--window.addEventListener('message', (event) => {--}}
        {{--    const data = JSON.parse(event.data);--}}
        {{--    // alert(data.msg);--}}
        {{--    location.href='/auth/logout';--}}

        {{--});--}}

        {{--@if(isset(session('auth')['device_kind']) && session('auth')['device_kind'] == 'web')--}}
        {{--    location.href='/auth/logout';--}}
        {{--@else--}}
        {{--    window.webViewBridge.send('webviewLogout', {}, function(res) {--}}
        {{--        // console.log(res);--}}
        {{--    }, function(err) {--}}
        {{--        // console.error(err);--}}
        {{--    });--}}
        {{--@endif--}}
    }
</script>

<div class="modal_bg" id="logout">
    <div class="modal_wrap md_logout w-100 mw-470">
        <div class="h_menu bg8">
            <button type="button" class="hd_menu_btn btn_back border-0 bg-transparent" onclick="modalHide('logout')"></button>
            <div><h3 class="tit_h3 ff_lotte fw_400 line_h1"><?php echo $mdTitle ?></h3></div>
            <div class="hd_menu_btn"></div>
        </div>
        <article class="sub_pg">
            <div class="container">
                <div class="d-none d-lg-block">
                    <h4 class="tit_h4"><?php echo $mdTitle ?></h4>
                </div>
                <div class="mt-3 rounded-lg bg-primary_bg p-3">
                    <h3 class="tit_h3 p-3 fw_600 text-primary">@if(isset(session('auth')['login_id'])){{session('auth')['login_id']}}@endif</h3>
                    <p class="fs_14 px-3 pb-3 line_h1_5 wh_pre">아이디가 로그아웃 됩니다. <br/>로그아웃 하시면 해당 아이디의 알림을 받으실 수 없습니다.</p>
{{--                    <p>@if(isset(session('auth')['login_id'])){{session('auth')['login_id']}}@endif</p>--}}
                </div>
                <form action="">
                    <div class="pt-5">
                        <button type="button" class="btn btn-block btn-primary" onclick="logout();">확인</button>
                    </div>
                </form>
            </div>
        </article>
        <pre>
        </pre>
    </div>
</div>

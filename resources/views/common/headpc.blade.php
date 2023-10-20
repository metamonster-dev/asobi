<?php $n_menu ?? $n_menu = 'etc' ?>
@include('auth.logout')

<div id="hd" class="d-none d-lg-block">
  <div class="container">
    <h1><a href="/"><img src="/img/hd_logo.svg" alt="홈으로 이동"></a></h1>
    <!-- ※ 로그인 안했을 때, 모든 페이지 접근 불가 -->
    <div class="nav_menu">
      <ul>
        <li <?php if ($n_menu === '1') { ?> class="on" <?php } ?>>
          <a href="/">홈</a>
        </li>
        <li <?php if ($n_menu === '2') { ?> class="on" <?php } ?>>
          <a href="/mypage">내정보</a>
        </li>
        <li <?php if ($n_menu === '3') { ?> class="on" <?php } ?>>
          <a href="/student">
            @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='s')
            자녀목록
            @else
            회원목록
            @endif
          </a>
        </li>
        @if(isset(session('auth')['device_kind']) && session('auth')['device_kind'] != 'web')
          <li <?php if ($n_menu === '4') { ?> class="on" <?php } ?>>
            <a href="/app/alarm">앱관리</a>
          </li>
        @endif
        <!-- <li <?php if ($n_menu === '4') { ?> class="on" <?php } ?>>
          <a href="/app/storage">저장공간관리</a>
        </li> -->
        <li <?php if ($n_menu === '5') { ?> class="on" <?php } ?>>
          <a href="/faq">FAQ</a>
        </li>
      </ul>
      <!-- ※ 로그인 시, 로그아웃 버튼 -->
      @if(session('auth'))
      <button class="btn btn-block btn-lg fs_18 fw_400 text-light h-100" onclick="modalShow('logout')">로그아웃</button>
      @endif
    </div>
  </div>
</div>

{{--<div class="loading_wrap" id="loading">--}}
{{--    <div class="loading_text">--}}
{{--        <i class="loading_circle"></i>--}}
{{--        <span>로딩중</span>--}}
{{--    </div>--}}
{{--</div>--}}
<script>
// $(window).on('load',function () {
//     $("#loading").hide();
// });
</script>

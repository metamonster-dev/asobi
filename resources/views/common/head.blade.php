<meta name="Generator" content="아소비">
<meta name="Author" content="아소비">
<meta name="Keywords" content="아소비">
<meta name="Description" content="아소비">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
<meta name="apple-mobile-web-app-title" content="아소비">
<meta content="telephone=no" name="format-detection">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta property="og:title" content="아소비">
<meta property="og:description" content="아소비">
<meta property="og:image" content="/img/og-image.png">
<link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
<link rel="manifest" href="">
<link rel="mask-icon" href="" color="#ffffff">
<meta name="msapplication-TileColor" content="">
<meta name="theme-color" content="">
<title>@yield('title',env('APP_TITLE'))</title>

<!-- 제이쿼리 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!--부트스트랩-->
<!-- 부트스트랩 커스텀 -->
<link rel="stylesheet" href="/css/boot_custom.css">
<link rel="stylesheet" href="/css/boot_custom.css.map">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- xe아이콘 -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/xeicon@2.3.3/xeicon.min.css">

<!-- 리믹스 아이콘 -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">


<!-- ie css 변수적용 -->
<script src="https://cdn.jsdelivr.net/gh/nuxodin/ie11CustomProperties@4.1.0/ie11CustomProperties.min.js"></script>

<!-- 폰트-->
<link rel="stylesheet" as="style" crossorigin href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard@v1.3.6/dist/web/variable/pretendardvariable-dynamic-subset.css" />

<!-- swiper -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.3.1/swiper-bundle.css" integrity="sha512-5TGRCl3hPoqtruhO+mubTuySHOfcEBvyIfiWHoCK8wDLmf6C1U73OUoNCU6ZvyT/8vfCcha1INDIo8dabDmQjw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<?php
$resourceVersion = date('YmdHis');
?>

<!-- jalert -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="/js/jalert.js?v={{$resourceVersion}}"></script>

<!-- JS -->
<script src="https://player.vimeo.com/api/player.js"></script>
<script src="//unpkg.com/hangul-js" type="text/javascript"></script><!-- 자동검색 -->
<script src="/js/custom.js?v={{$resourceVersion}}" defer></script>
<script src="/js/main.js?v={{$resourceVersion}}" defer></script>
<script src="/js/webViewBridge.js?v={{$resourceVersion}}" defer></script>
<script src="/js/ycommon.js?v={{$resourceVersion}}" defer></script>

<!-- CSS -->
<link rel="stylesheet" href="/css/custom.css?v={{$resourceVersion}}"><!-- UI 커스텀 -->
<link rel="stylesheet" href="/css/common.css?v={{$resourceVersion}}"><!-- 헤더/푸터 관련 CSS -->
<link rel="stylesheet" href="/css/design.css?v={{$resourceVersion}}"><!-- 디자인 변경되는 부분 -->
<link rel="stylesheet" href="/css/design_mo.css?v={{$resourceVersion}}"><!-- 디자인 변경되는 부분 -->

<!DOCTYPE html>
<html lang="ko">
<head>
    <title>아소비</title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge, chrome=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, viewport-fit=cover" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="robots" content="noindex,nofollow" />
</head>
<body>
<script>
    var launchAppUrl_ios = "{{ $app_schema }}://launch?type={{ $type }}&id={{ $hashId }}"; // 앱 스키마
    var launchAppUrl_android = "intent://launch?type={{ $type }}&id={{ $hashId }}#Intent;scheme={{ $app_schema }};package=com.asobi;end"; // 앱 스키마

    var isIPHONE = (navigator.userAgent.match('iPhone') != null || navigator.userAgent.match('iPod') != null);
    var isIPAD = (navigator.userAgent.match('iPad') != null);
    var isANDROID = (navigator.userAgent.match('Android') != null);

    var _APP_INSTALL_URL_IOS = 'https://itunes.apple.com/app/id1494648238';
    var _APP_INSTALL_URL_ANDROID = 'https://play.google.com/store/apps/details?id=com.asobi&hl=ko';
    var _APP_INSTALL_CONFIRM = '아소비를 설치하시겠습니까?';

    function executeApp() {
        installApp();

        if (isANDROID) {
            window.location.href = launchAppUrl_android;
        } else if (isIPHONE || isIPAD) {
            window.location.href = launchAppUrl_ios;
        }
    }

    function installApp() {
        var b = new Date();

        setTimeout(function(){
            if (new Date() - b < 2000) {
                if (isIPHONE || isIPAD) {
                    if (confirm(_APP_INSTALL_CONFIRM)) { window.location.href = _APP_INSTALL_URL_IOS; }
                } else if (isANDROID) {
                    if (confirm(_APP_INSTALL_CONFIRM)) { window.location.href = _APP_INSTALL_URL_ANDROID; }
                }
            }
        }, 1000);
    }

    setTimeout(function() {
        executeApp();
    }, 0);
</script>
</body>
</html>

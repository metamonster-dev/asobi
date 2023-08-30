<!DOCTYPE html>
<html lang="ko">
<head>
@yield('head')
</head>
<body @yield('bodyAttr')>

<!-- body start -->
@yield('body')
<!-- body end -->

@include('auth.policy')
@include('auth.terms')

</body>
</html>

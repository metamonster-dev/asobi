@extends('layout.default')
@section('head')
@include('common.head')
    <script>
        var userId = '{{ session('auth')['user_id'] ?? '' }}';
        var accountId = '{{ session('auth')['account_id'] ?? '' }}';
        var user_type_ko = '{{ session('auth')['user_type_ko'] ?? '' }}';
        var device_type = '{{ session('auth')['device_type'] ?? '' }}';
        var deviceId = '{{ session('auth')['device_id'] ?? '' }}';
        var os = '{{session('auth')['device_kind'] ?? ''}}';
        var wifi = '{{session('auth')['wifi'] ?? 'N'}}';

    </script>
@endsection
@section('body')

@include('common.headpc')
<!-- contents start -->
@yield('contents')
<!-- contents end -->
@include('common.tailpc')

@endsection

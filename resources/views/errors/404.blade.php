{{--@extends('errors::minimal')--}}

{{--@section('title', __('Not Found'))--}}
{{--@section('code', '404')--}}
{{--@section('message', __('Not Found'))--}}

<script>
    alert("일시적인 네트워크 오류입니다. 잠시 후에 다시 사용해주세요.");
    window.location.href = "/";
</script>

@extends('layout.full')
@section('bodyAttr')
class="body"
@endsection
@section('contents')
        <form class="login-form" name="login-form" id="login-form" method="POST" action="/auth/intra_loginAction">

            <input type="hidden" name="temp" id="" value="" />
            <input type="hidden" name="device_kind" id="device_kind" value="web" />
            <input type="hidden" name="device_type" id="device_type" value="web" />
            <input type="hidden" name="device_id" id="device_id" value="web" />
            <input type="hidden" name="push_key" id="push_key" value="web" />
            <input type="hidden" name="login_id" id="login_id" value="{{ $login_id }}"/>
            
        </form>

<script>
    window.onload = function(){
      document.getElementById('login-form').submit();
    };
    
</script>

@endsection

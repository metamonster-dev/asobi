<button type="button" @if(isset($tab_active) && $tab_active=='1')class="btn btn-primary"@else class="btn btn-light_gray text-light" onclick="location.href='/app/alarm'" @endif>알림설정</button>
{{--@if(isset(session('auth')['device_kind']) && session('auth')['device_kind'] != 'web')--}}
<button type="button" @if(isset($tab_active) && $tab_active=='2')class="btn btn-primary"@else class="btn btn-light_gray text-light" onclick="location.href='/app/version'" @endif>앱 버전정보</button>
<button type="button" @if(isset($tab_active) && $tab_active=='3')class="btn btn-primary"@else class="btn btn-light_gray text-light" onclick="location.href='/app/storage'" @endif>저장 공간 관리</button>
{{--@endif--}}

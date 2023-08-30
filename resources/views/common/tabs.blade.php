<div class="tab_btn02" id="cmTabs">
    @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='s')
    <a href="/advice/list" class="btn btn-lg btn-light_gray text-light">알림장</a>
    @else
    <a href="/advice" class="btn btn-lg btn-light_gray text-light">알림장 관리</a>
    @endif
    <a href="/album" class="btn btn-lg btn-light_gray text-light">앨범관리</a>
    <a href="/notice" class="btn btn-lg btn-light_gray text-light">
        @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='s')
        공지사항
        @else
        회원 공지
        @endif
    </a>
    @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='s')
    <a href="/attend/view/{{ session('auth')['user_id'] }}" class="btn btn-lg btn-light_gray text-light">출석부 관리</a>
    @else
    <a href="/attend" class="btn btn-lg btn-light_gray text-light">출석부 관리</a>
    @endif
    @if(isset(session('auth')['user_type']) && session('auth')['user_type'] !=='s')
    <a href="/counsel" class="btn btn-lg btn-light_gray text-light">상담일지</a>
    @endif
    <a href="/education" class="btn btn-lg btn-light_gray text-light">교육정보</a>
    <a href="/event" class="btn btn-lg btn-light_gray text-light">이벤트</a>
</div>

<script>
    const path = window.location.pathname;
    const pathGroup = path.split("/")[1];

    $("#cmTabs a").each(function() {
        const href = $(this).attr("href");
        if (href.indexOf(pathGroup) !== -1) {
            $(this).removeClass("btn-light_gray");
            $(this).removeClass("text-light");
            $(this).addClass("btn-primary");
        }
    });
</script>

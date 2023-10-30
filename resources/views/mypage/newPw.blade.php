<form name="resetPwForm" id="resetPwForm" method="POST" action="/mypage/resetPwAction" onsubmit="return pw_form_chk(this);">
    <div class="ip_wr mt-4">
        <div class="ip_tit">
            <h5>새 비밀번호</h5>
            <p class="d-none d-lg-block fs_14 text-light line_h1_4 mt-1">비밀번호는 4자리 이상의 숫자 또는 문자이면 등록 가능합니다.</p>
        </div>
        <input type="password" name="password" id="password" value="" class="form-control" placeholder="새 비밀번호를 입력해주세요.">
    </div>
    <div class="ip_wr mt-4 mt-lg-0">
        <div class="ip_tit d-block d-lg-none">
            <h5>새 비밀번호 확인</h5>
        </div>
        <input type="password" name="password2" id="password2" value="" class="form-control mt-3" placeholder="새 비밀번호를 다시 입력해주세요.">
    </div>
    <div class="pt-5 mt-3">
        <button class="btn btn-block btn-primary" type="submit">
            <span class="d-none d-lg-block">수정하기</span>
            <span class="d-block d-lg-none">비밀번호 변경</span>
        </button>
    </div>
</form>

<div class="loading_wrap" id="loading" style="display: none">
    <div class="loading_text">
        <i class="loading_circle"></i>
        <span>로딩중</span>
    </div>
</div>

<script>
    function pw_form_chk(f) {
        const regPw = /^[a-zA-Z0-9]{4,}$/;
        if(f.password.value == "") {
            jalert("새 비밀번호를 입력해주세요.");
            f.password.focus();
            return false;
        }
        if(!regPw.test(f.password.value)) {
            jalert("비밀번호는 4자리 이상의 숫자 또는 문자를 입력해주세요.");
            f.password.focus();
            return false;
        }
        if(f.password.value != f.password2.value) {
            jalert("비밀번호가 일치하지 않습니다.");
            f.password2.focus();
            return false;
        }
    }
</script>

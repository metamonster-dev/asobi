function jalert(c, t="") {
    $.alert({
        title: t,
        content: c,
        buttons: {
            confirm: {
                text: '확인',
                action: function() {
                    //close();
                }
            },
        }
    });
}

function jalert2(c, t="", fn) {
    $.alert({
        title: t,
        content: c,
        buttons: {
            confirm: {
                text: '확인',
                action: function() {
                    fn();
                }
            },
            cancel: {
                text: '취소',
                action: function() {
                    //close();
                }
            },
        }
    });
}

function jalert_url(c, u, t="",k) {
    $.alert({
        title: t,
        content: c,
        buttons: {
            confirm: {
                text: '확인',
                action: function() {
                    if(u=='back') {
                        history.go(-1);
                    } else if(u=='reload') {
                        location.hash = '';
                        location.reload();
                    } else if (u=='none') {
                    } else if (u=='p_reload') {
                        parent.location.hash = '';
                        parent.location.reload();
                    } else if (u == 'fn') {
                        k();
                    } else if (u == "") {
                    } else {
                        document.location.href = u;
                    }
                }
            },
        }
    });
}

// 엔터 키를 눌렀을 때 jalert 확인 버튼 실행
$(document).on('keypress', function(e) {
    if (e.which == 13) {
        if($("body").find(".jconfirm").length != 0) {
            $('.jconfirm-box').find('.jconfirm-buttons button').eq(0).trigger('click');
        }
    }
});

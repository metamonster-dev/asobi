var ycommon = (function(ycommon, $, window) {

    //채팅 목록 오픈
    ycommon.openChat = function(url, name, width, height) {
        var filterBool = false;
        var filter = "win16|win32|win64|mac|macintel";
        if (navigator.platform && ycommon.getCookie('app') != '1') {
            if (filter.indexOf(navigator.platform.toLowerCase()) >= 0) {
                filterBool = true;
            }
        }
        if (filterBool) {
            var screenWidth = screen.availWidth;
            var screenHeight = screen.availHeight;
            if (screenWidth < width) {
                width = screenWidth;
            } else if (screenWidth / 3 > width) {
                width = screenWidth / 3;
            }
            height = screenHeight;
        }
        var chatWindow = ycommon.winOpen(url,name,'width='+width+',height='+height+',scrollbars=1');
        if (filterBool) chatWindow.moveTo(0,0);
    }

    //앞에 0채움
    ycommon.isMobile = function() {
        var UserAgent = navigator.userAgent;
        if (UserAgent.match(/iPhone|iPod|Android|Windows CE|BlackBerry|Symbian|Windows Phone|webOS|Opera Mini|Opera Mobi|POLARIS|IEMobile|lgtelecom|nokia|SonyEricsson/i) != null || UserAgent.match(/LG|SAMSUNG|Samsung/) != null) {
            return true;
        } else {
            return false;
        }
    };

    // URL 에서 파라미터를 가져온다
    ycommon.getUrlParams = function() {
        return ycommon.getParams(window.location.search);
    };

    ycommon.getParams = function(text) {
        var params = {};
        text.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(str, key, value) { params[key] = value; });
        return params;
    }

    ycommon.setCookie = function(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    };

    ycommon.getCookie = function(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    };

    ycommon.deleteCookie = function(cname) {
        var expireDate = new Date();
        expireDate.setDate( expireDate.getDate() - 1 );
        document.cookie = cname + "= " + "; expires=" + expireDate.toGMTString() + "; path=/";
    }

    ycommon.getSegment = function(idx) {
        var site_domain_location = document.location.pathname;
        var se = site_domain_location.split("/");
        if (idx === undefined) return se;
        else se[idx];
    }

    //날자 선택시 트리거로 요일찾아서 넣어준다.
    ycommon.dayCall = function(id) {
        var sDate = $("#"+id).val();

        var yy = parseInt(sDate.substr(0, 4), 10);
        var mm = parseInt(sDate.substr(5, 2), 10);
        var dd = parseInt(sDate.substr(8), 10);

        var d = new Date(yy,mm - 1, dd);
        var weekday=new Array(7);
        weekday[0]="일";
        weekday[1]="월";
        weekday[2]="화";
        weekday[3]="수";
        weekday[4]="목";
        weekday[5]="금";
        weekday[6]="토";

        $("#"+id).parent().find('.dayCall').text( weekday[d.getDay()] );
    };

    ycommon.setDatepicker = function() {
        var dates = $('.cal').datepicker({
            onSelect: function( selectedDate ) {
                var trigger = $(this).attr('trigger');
                var f = eval;

                if (this.id.indexOf('from') !== -1  ||  this.id.indexOf('to') !== -1) {
                    var option = this.id.indexOf('from') !== -1 ? "from" : "to";
                    var instance = $( this ).data( "datepicker" );
                    var date = $.datepicker.parseDate( instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings );
                    var target = '';
                    //프롬이 포함되어있으면..
                    if (option == "from") {
                        target = "#" + this.id.replace('from', 'to');
                    } else {
                        target = "#" + this.id.replace('to', 'from');
                    }
                    var targetDate = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, $(target).val(), instance.settings);
                    if (targetDate != null) {
                        if (option == "from") {
                            //to보다 뒤에 날자를 선택한거라면 to의 값을 비움.
                            if (date > targetDate) $(target).val("");
                        } else {
                            //form보다 이전 날자를 선택한거라면 from값을 비움.
                            if (date < targetDate) $(target).val("");
                        }
                    }
                }
                if(trigger != undefined) {
                    f(trigger);
                }
                $(this).change();
            },
            changeMonth:true,
            changeYear:true,
            dateFormat:"yy-mm-dd",
            dayNames : ['일요일','월요일','화요일','수요일','목요일','금요일','토요일'],
            dayNamesMin : ['일','월','화','수','목','금','토'],
            monthNamesShort:  [ "1월", "2월", "3월", "4월", "5월", "6월","7월", "8월", "9월", "10월", "11월", "12월" ]
        });
    }

    ycommon.setDatepicker2 = function() {
        var dates = $('.cal').datetimepicker({
            onSelect: function(selectedDate) {
                var trigger = $(this).attr('trigger');
                var f = eval;

                if (this.id.indexOf('from') !== -1  ||  this.id.indexOf('to') !== -1) {
                    var option = this.id.indexOf('from') !== -1 ? "from" : "to";
                    var instance = $( this ).data( "datepicker" );
                    var date = $.datepicker.parseDateTime( instance.settings.dateFormat || $.datepicker._defaults.dateFormat, instance.settings.timeFormat, selectedDate, instance.settings );
                    var target = '';
                    //프롬이 포함되어있으면..
                    if (option == "from") {
                        target = "#" + this.id.replace('from', 'to');
                    } else {
                        target = "#" + this.id.replace('to', 'from');
                    }
                    var targetDate = $.datepicker.parseDateTime(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, instance.settings.timeFormat, $(target).val(), instance.settings);

                    if (targetDate != null) {
                        if (option == "from") {
                            //to보다 뒤에 날자를 선택한거라면 to의 값을 비움.
                            if (date > targetDate) $(target).val("");
                        } else {
                            //form보다 이전 날자를 선택한거라면 from값을 비움.
                            if (date < targetDate) $(target).val("");
                        }
                    }
                }

                if ($(this).is('.chkNow')) {
                    try {
                        var dt = selectedDate.split(" ");
                        var dArr = dt[0].split("-");
                        var tArr = dt[1].split(":");
                        var selDateObj = new Date(parseInt(dArr[0]),parseInt(dArr[1])-1,parseInt(dArr[2]),parseInt(tArr[0]),parseInt(tArr[1]),0);
                        var nowDateObj = new Date();
                        if (selDateObj < nowDateObj) {
                            alert("시작 시간을 현재 시간 이전으로 설정 할 수 없습니다");
                        }
                    } catch (e) {
                        console.log(e);
                    }
                }

                if (trigger != undefined) {
                    f(trigger);
                }
                $(this).change();
            },
            changeMonth:true,
            changeYear:true,
            dateFormat:"yy-mm-dd",
            dayNames : ['일요일','월요일','화요일','수요일','목요일','금요일','토요일'],
            dayNamesMin : ['일','월','화','수','목','금','토'],
            monthNamesShort:  [ "1월", "2월", "3월", "4월", "5월", "6월","7월", "8월", "9월", "10월", "11월", "12월" ],
            // timepicker 설정
            timeFormat:'HH:mm',
            controlType:'select',
            oneLine:true,
        }).on('change',function(e){
            var selectedDate = $(this).val();
            //현재 시간 비교 클래스가 있으면..
            if ($(this).hasClass('chkNow')) {
                try {
                    var dt = selectedDate.split(" ");
                    var dArr = dt[0].split("-");
                    var tArr = dt[1].split(":");
                    var selDateObj = new Date(parseInt(dArr[0]),parseInt(dArr[1])-1,parseInt(dArr[2]),parseInt(tArr[0]),parseInt(tArr[1]),0);
                    var nowDateObj = new Date();
                    if (selDateObj < nowDateObj) {
                        var setNowDate = ycommon.getTimeStamp(nowDateObj, "Y-m-d H:i");
                        $(this).val(setNowDate);
                    }
                } catch (e) {
                    console.log(e);
                    $(this).val('');
                }
            }
        });
    }

    ycommon.getTimeStamp = function(dateObj, format) {
        if (format === undefined) format = "Y-m-d H:i:s"
        var y = ycommon.leadingZeros(dateObj.getFullYear(), 4);
        var m = ycommon.leadingZeros(dateObj.getMonth() + 1, 2);
        var d = ycommon.leadingZeros(dateObj.getDate(), 2);
        var h = ycommon.leadingZeros(dateObj.getHours(), 2);
        var i = ycommon.leadingZeros(dateObj.getMinutes(), 2);
        var s = ycommon.leadingZeros(dateObj.getSeconds(), 2);
        format = format.replace(/Y/g, y);
        format = format.replace(/m/g, m);
        format = format.replace(/d/g, d);
        format = format.replace(/H/g, h);
        format = format.replace(/i/g, i);
        format = format.replace(/s/g, s);
        return format;
    }

    ycommon.checkDateTime = function(value) {
        var pattern = /^(19|20)\d{2}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[0-1]) (0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/;
        return pattern.test(value);
    }

    ycommon.delConfirm = function(link) {
        if (confirm("삭제 하시겠습니까?")) {
            ycommon.goLink(link);
        }
    }

    ycommon.goLink = function(link){
        document.location.href=link;
    }

    //팝업 창
    ycommon.winOpen = function(url, name, option) {
        var popup = window.open(url, name, option);
        popup.focus();
        return popup;
    }

    ycommon.checkKey = function(e) {
        var keycode = '';
        if(window.event) keycode = window.event.keyCode;
        else if(e) keycode = e.which;
        else {
            event.returnValue = false;
            return false;
        }
        //48~57 키패드위 숫자키, 96~106 숫자패드 숫자키, 8 백스페이스, 46 delete키, 9 탭, 새로고침 116, 37 arrow left, 39 arrow right, 13 enter
        //17 ctrl,67 c, 86 v, 65 a
        // 109 오른쪽 -, 189 중간 -
        if ((keycode >= 48 && keycode <= 57) || (keycode >= 96 && keycode <= 106) || keycode == 8 || keycode == 46 || keycode == 9
            || keycode == 116 || keycode == 37 || keycode == 39 || keycode == 13 || keycode == 17 || keycode == 67 || keycode == 86 || keycode == 65
            || keycode == 109 || keycode == 189
        ) {
            event.returnValue = true;
        } else {
            event.returnValue = false;
        }
    }

    ycommon.replaceNumber = function(obj){
        obj.val(obj.val().replace(/[^0-9]/g,''));
    }

    ycommon.replaceInt = function(obj){
        obj.val(obj.val().replace(/[^0-9-]/g,''));
    }

    //1원 단위 반올림하여 10원 단위로 표현
    ycommon.setTenRound = function(pri) {
        pri = Math.round(Number(pri)/10) * 10;
        return pri;
    }

    // 지정된 자리 - 1 올림 처리(지정된 자리 이하 0)
    ycommon.calCeil = function(x, y) {
        return Math.ceil (x / y) * y;
    }

    // 지정된 자리 - 1 내림 처리(지정된 자리 이하 0)
    ycommon.calFloor = function(x, y) {
        return Math.floor (x / y) * y;
    }

    //천자리마다 콤마
    ycommon.setPriceInput = function(str) {
        if (typeof str !== 'string') str = str.toString();
        str = str.replace(/,/g,'');
        var negativeNumber = false;
        if (str.indexOf('-') !== -1) negativeNumber = true;
        str = str.replace(/-/g,'');
        if (str.replace(/^0*/, '') != '') str = str.replace(/^0*/, '');
        else str = "0";
        var retValue = "";
        for(i=1; i<=str.length; i++)
        {
            if (i > 1 && (i%3)==1)
                retValue = str.charAt(str.length - i) + "," + retValue;
            else
                retValue = str.charAt(str.length - i) + retValue;
        }
        if (negativeNumber) retValue = "-" + retValue;
        return retValue;
    }

    //천자리 마다 ,찍은거 중에 ,를 제거하고 타입을 number로 형변환 하여 넘긴다.
    ycommon.getPriceNumber = function(str) {
        //str이 정의되지 않으면 0을 반환한다.
        if (str === undefined) return 0;

        str = str.replace(/,/g,'');

        if (isNaN(Number(str))){
            return 0;
        } else {
            return Number(str);
        }
    }

    // Y-m-d 형태로 포매팅된 날짜 반환
    ycommon.formatStandardYmd = function(date) {
        var yyyy = date.getFullYear().toString();
        var mm = (date.getMonth() + 1).toString();
        var dd = date.getDate().toString();
        return yyyy + "-" + (mm[1] ? mm : '0'+mm[0]) + "-" + (dd[1] ? dd : '0'+dd[0]);
    }

    // Y년 m월 d일 형태로 포매팅된 날짜 반환
    ycommon.formatStandardYmd2 = function(date) {
        var yyyy = date.getFullYear().toString();
        var mm = (date.getMonth() + 1).toString();
        var dd = date.getDate().toString();
        return yyyy + "년 " + (mm[1] ? mm : '0'+mm[0]) + "월 " + (dd[1] ? dd : '0'+dd[0]) + "일";
    }

    //문자의 바이트를 계산하여 리턴한다.
    ycommon.getByte = function(str) {
        var strByte = 0;
        for(var i =0; i < str.length; i++) {
            var currentByte = str.charCodeAt(i);
            if(currentByte > 128) strByte += 2;
            else strByte++;
        }
        return strByte;
    }

    //글자를 앞에서부터 원하는 바이트만큼 잘라 리턴. 한글의 경우 2바이트로 계산하며, 글자 중간에서 잘리지 않는다.
    ycommon.cutByte = function(str,len) {
        var count = 0;
        for(var i = 0; i < str.length; i++) {
            if(escape(str.charAt(i)).length >= 4) count += 2;
            else if(escape(str.charAt(i)) != "%0D") count++;
            if(count >  len) {
                if(escape(str.charAt(i)) == "%0A") i--;
                break;
            }
        }
        return str.substring(0, i);
    }

    //휴대폰번호 체크
    ycommon.checkHpNum = function(hp) {
        var regExp = /^\d{3}-\d{3,4}-\d{4}$/;
        return regExp.test(hp.toString());
    }

    //자동하이픈
    ycommon.autoHypenPhone = function(str) {
        str = str.replace(/[^0-9]/g, '');
        var tmp = '';
        if (str.length < 4) {
            return str;
        } else if(str.length < 7) {
            tmp += str.substr(0, 3);
            tmp += '-';
            tmp += str.substr(3);
            return tmp;
        } else if(str.length < 11) {
            tmp += str.substr(0, 3);
            tmp += '-';
            tmp += str.substr(3, 3);
            tmp += '-';
            tmp += str.substr(6);
            return tmp;
        } else {
            tmp += str.substr(0, 3);
            tmp += '-';
            tmp += str.substr(3, 4);
            tmp += '-';
            tmp += str.substr(7);
            return tmp;
        }
        return str;
    }

    ycommon.alertMsg = function(msg) {
        alert(msg);
        // $(".designAlert .msg").html(msg.replace(/\n/g, "<br />"));
        // $(".designAlert").fadeIn().delay(3000).fadeOut();
        // $(".designAlert").show(0).delay(7000).hide(0);
    }

    /**
     * ajax json
     * @param action string url
     * @param data array
     * @param $el 엘리먼트 (jquery element obj)
     * @param successFn success callback
     * @param loading 엘리먼트 (jquery element obj)
     * @param errorFn error callback
     * @param timeout micro second
     * @param async bool //비동기여부 true 비동기, false 동기
     * @param etcConf object //기타콘피그
     */
    ycommon.ajaxJson = function(amethod,action,data,$el,successFn,loading,errorFn,timeout,async,etcConf) {
        if ( loading !== undefined ) {
            if ( loading == 1 ) {
                $(".loading").show();
            } else {
                loading.show();
            }
        }
        var ajaxMethod = 'post';
        if ( amethod !== undefined ) {
            ajaxMethod = amethod;
        }

        var ajaxTimeOut = 5000;
        if ( timeout !== undefined ) {
            ajaxTimeOut = timeout;
        }

        var asyncBool = true;
        if (async !== undefined) {
            asyncBool = async;
        }

        var setting = {
            url : action,
            type : ajaxMethod,
            async: asyncBool,
            timeout : ajaxTimeOut,
            dataType : 'json',
            data : data,
            success : function(returnData){
                if ( loading !== undefined ) {
                    if ( loading == 1 ) {
                        $(".loading").fadeOut();
                    } else {
                        loading.fadeOut();
                    }
                }
                //만약 메세지가 정의되었으면..
                if ( returnData.msg !== undefined && data.debug_jwt === undefined && action.indexOf('/api/') === -1 ) {
                    // ycommon.alertMsg(returnData.msg);
                    jalert_url(returnData.msg, 'none', '');
                }

                //만약 리턴된 html이 정의되었으면..
                if ( returnData.returnHtml !== undefined ) {
                    $el.html(returnData.returnHtml);
                }

                //만약 타입이 함수면...
                if ( typeof ( successFn ) == "function" ){
                    successFn(returnData);
                }
            },
            error : function(jqXHR, textStatus, errorThrown){
                if ( loading !== undefined ) {
                    if ( loading == 1 ) {
                        $(".loading").fadeOut();
                    } else {
                        loading.fadeOut();
                    }
                }
                if ( typeof ( errorFn ) == "function" ){
                    errorFn(jqXHR, textStatus, errorThrown);
                } else {
                    ycommon.alertMsg( ycommon.ajaxJsonError(jqXHR, textStatus, errorThrown) );
                }
            }
        };

        //기타 콘피가 있으면 for in문을 통해 세팅한다.
        if (etcConf !== undefined) {
            for (var key in etcConf) {
                setting[key] = etcConf[key];
            }
        }

        return $.ajax(setting);
    }

    ycommon.ajaxJsonError = function(jqXHR, textStatus, errorThrown) {
        var err_msg = '';
        if (jqXHR.status === 0) {
            err_msg = '네트워크가 오프라인입니다.\n네트워크를 확인하시기 바랍니다.';
        } else if (jqXHR.status == 404) {
            err_msg = '요청 된 페이지를 찾을 수 없습니다. [404]';
        } else if (jqXHR.status == 500) {
            err_msg = '내부 서버 오류. [500]';
        } else if (textStatus === 'parsererror') {
            err_msg = '요청 된 JSON 구문 분석에 실패했습니다.';
        } else if (textStatus === 'timeout') {
            err_msg = '시간 초과 오류가 발생했습니다.';
        } else if (textStatus === 'abort') {
            err_msg = 'Ajax 요청이 중단되었습니다.';
        } else {
            err_msg = 'Uncaught Error.\n' + jqXHR.responseText;
        }
        return err_msg;
    }

    ycommon.ajaxTask = function(tasks) {
        var defer = new $.Deferred();
        var next = defer;
        $.each(tasks, function(k,v) {
            if (k == 0) {
                next = v;
            } else {
                next  = next.then(function(){
                    return v;
                });
            }
        });
        return next;
    }

    //시간을 체크 00:00~ 23:59
    ycommon.validTimeCheck = function(time) {
        var bool = false;
        if (/(2[0-3]|[01][0-9]):([0-5][0-9])/.test(time)) {
            bool = true;
        }
        return bool;
    }

    //자바스크립트 Date객체 Y-m-d로 변환
    ycommon.formatDate = function(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }

    //자바스크립트 time객체를 H:i로 변환
    ycommon.formatTime = function(date) {
        var d = new Date(date),
            H = '' + d.getHours(),
            i = '' + d.getMinutes();
        if (H.length < 2) H = '0' + H;
        if (i.length < 2) i = '0' + i;
        return [H, i].join(':');
    }

    //앞에 0채움
    ycommon.leadingZeros = function(n, digits) {
        var zero = '';
        n = n.toString();

        if (n.length < digits) {
            for (i = 0; i < digits - n.length; i++)
                zero += '0';
        }
        return zero + n;
    }

    ycommon.copyToClipboard = function(str) {
        // var input = document.querySelector('input');
        try {
            var tempElem = document.createElement('textarea');
            tempElem.value = str;
            document.body.appendChild(tempElem);

            tempElem.select();
            // textarea.setSelectionRange(0, 9999);
            var returnValue = document.execCommand("copy");
            document.body.removeChild(tempElem);
            console.debug(returnValue);
            if (!returnValue) {
                throw new Error('copied nothing');
            }
            alert('복사 되었습니다.');
        } catch (e) {
            prompt('Copy to clipboard: Ctrl+C, Enter', str);
        }
    }

    ycommon.chosung = function(str) {
        var res = "", // 초성으로 변환
            choArr = ["ㄱ","ㄲ","ㄴ","ㄷ","ㄸ","ㄹ","ㅁ","ㅂ","ㅃ","ㅅ","ㅆ","ㅇ","ㅈ","ㅉ","ㅊ","ㅋ","ㅌ","ㅍ","ㅎ"];
        for (var i in str) {
            code = Math.floor((str[i].charCodeAt() - 44032) / 588)
            res += code >= 0 ? choArr[code] : str[i];
        }
        return res;
    }

    ycommon.jwtDecode = function (token) {
        var base64Url = token.split('.')[1];
        var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
        var jsonPayload = decodeURIComponent(window.atob(base64).split('').map(function(c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));

        return JSON.parse(jsonPayload);
    };

    ycommon.jwtEncode = function (data,secret) {
        var header = {
            "alg": "HS256",
            "typ": "JWT"
        };

        var stringifiedHeader = CryptoJS.enc.Utf8.parse(JSON.stringify(header));
        var encodedHeader = ycommon.base64url(stringifiedHeader);

        var stringifiedData = CryptoJS.enc.Utf8.parse(JSON.stringify(data));
        var encodedData = ycommon.base64url(stringifiedData);

        var token = encodedHeader + "." + encodedData;

        var signature = CryptoJS.HmacSHA256(token, secret);
        signature = ycommon.base64url(signature);

        var signedToken = token + "." + signature;
        return signedToken;
    }

    // Jwt_Encode_Decode.php
    ycommon.base64url = function(source) {
        // Encode in classical base64
        var encodedSource = CryptoJS.enc.Base64.stringify(source);

        // Remove padding equal characters
        encodedSource = encodedSource.replace(/=+$/, '');

        // Replace characters according to base64url specifications
        encodedSource = encodedSource.replace(/\+/g, '-');
        encodedSource = encodedSource.replace(/\//g, '_');

        return encodedSource;
    }

    ycommon.openModal = function (url, params) {
        if (url === undefined) url = "";
        if (params === undefined) params = {};
        // $('#modal-default').modal('hide');
        $.post(url, params, function (data) {
            if(data) {
                $('#modal-default-content').html(data);
                $('#modal-default').modal();
            }
        });
    }

    ycommon.financial = function(x) {
        return Number.parseFloat(x).toFixed(2);
    }

    ycommon.replaceFloat = function (val) {
        val = val + "";
        var a = val.split('.')
        if (a.length == 1) {
            return ycommon.setPriceInput(val);
        } else {
            return ycommon.setPriceInput(a[0]) + '.' + a[1];
        }
    }

    ycommon.uploadSummernoteImageFile = function (file, el, name) {
        data = new FormData();
        data.append("file", file);
        $.ajax({
            data : data,
            type : "POST",
            url : "/mng/file_upload2.php?Type=Images&upload_name="+name,
            contentType : false,
            processData : false,
            dataType : 'json',
            success : function(data) {
                if (!data.result) {
                    jalert_url(data.msg,'none');
                    return;
                }
                console.log(data)
                console.log(el)
                el.summernote('insertImage', data.url);
            }
        });
    }

    ycommon.maxByteCalc = function (obj,SEQ,txid='SBY_',tyid='SMS_') {
        var ls_str		= obj.value;
        var li_str_len	= ls_str.length;
        var i			= 0;
        var li_byte		= 0;
        var li_len      = 0;
        var ls_one_char = "";

        for(i=0; i< li_str_len; i++)
        {
            ls_one_char = ls_str.charAt(i);
            if (escape(ls_one_char).length > 4)
            {
                li_byte = li_byte+2;
            }
            else
            {
                li_byte++;
            }
        }

        var li_SMS = "SMS";
        if (li_byte>80 && li_byte<2000)
        {
            li_SMS	= "LMS";
        }
        else if (li_byte>=2000)
        {
            li_SMS = "MMS";
        }

        $("#"+txid+SEQ).html(li_byte);
        $("#"+tyid+SEQ).html(li_SMS);
        obj.focus();
    }

    ycommon.setMessage = function (no) {
        if ($("#Ssject_0").val().length>0)
        {
            if (!confirm("메시지를 바꾸시겠습니까?")) return;
        }
        $("#SMS_0").html($("#SLSMS_"+no).html());
        $("#SBY_0").html($("#SLSBY_"+no).html());
        $("#Ssject_0").val($("#SLbady_"+no).val());
    }

    ycommon.saveBoilerplate = function (idx) {
        var action = '/mng/category_update.php';
        var msg = $('#SLbady_'+idx).val();
        var data = {act:'save_boilerplate', msg:msg, no: idx};
        ycommon.ajaxJson(action,data,undefined,function(data){
            // location.reload();
            if (data.bool) {
                jalert_url("저장되었습니다.", 'none');
            }
        });
    }

    ycommon.colorbox = function (w,h,url,title) {
        if (title.length==0) title = "";
        $.colorbox({
            iframe:true,
            width:w,
            height:h,
            fixed:true,
            title:title,
            href:url
        });
    }

    ycommon.f_m_hp_chk2 = function(e) {
        if (!$("#m_hp_chk_btn").hasClass('disabled2')) {
            if($('#mt_hp').val()=="" || $('#mt_hp').val().indexOf("_") !== -1) {
                $("#mt_hp_error").text("휴대전화번호를 입력해주세요.");
                $('#mt_hp').focus();
                return false;
            }

            $("#mt_hp_error").text("");

            $(".mt_hp_confirm_wrap, #m_hp_confirm_timer_error").show();

            $.post('/webview/join_update.php', {act: 'chk_mt_hp', mt_hp: $('#mt_hp').val()}, function (data) {
                if(data=='Y') {
                    ycommon.set_timer2();
                }
            });
        }

        return false;
    }

    ycommon.timer;

    ycommon.set_timer2 = function () {
        var time = 119;
        var min = "";
        var sec = "";
        $("#m_hp_chk_btn").css("color", "#013DFD");
        // $("#mt_hp").prop("readonly", true);
        $("#m_hp_chk_btn").addClass("disabled2");
        $('#m_hp_confirm_timer_error').removeClass("on").html("");
        ycommon.timer = setInterval(function () {
            min = parseInt(time / 60);
            sec = time % 60;
            $(".tf_input_wrap").show();
            $("#m_hp_confirm_timer").show().text(ycommon.leadingZeros(min,2)+":"+ycommon.leadingZeros(sec,2));
            time--;
            if(time<-1) {
                $("#m_hp_confirm_timer_error").text("인증번호 유효시간이 만료 되었습니다.");
                clearInterval(ycommon.timer);
                $("#m_hp_chk_btn").css("color", "#9CA3AF");
                // $("#mt_hp").prop("readonly", false);
                $("#m_hp_chk_btn").removeClass("disabled2");
                $("#m_hp_confirm_timer").hide().text("");
            }
        }, 1000);
    }

    ycommon.showmodal = function (mode) {
        $(".modal_overlay > *").hide();
        if (mode == "member_confirm") {
            $("#member_confirm_modal").css("display","flex").fadeIn();
        } else if (mode == "not_find_id") {
            $("#not_find_id_modal").css("display","flex").fadeIn();
        } else if (mode == "change_pwd") {
            $("#change_pwd_modal").css("display","flex").fadeIn();
        } else if (mode == "rectification") {
            $("#rectification_modal").css("display","flex").fadeIn();
        } else if (mode == "refund") {
            $("#refund_modal").css("display","flex").fadeIn();
        }

        $(".modal_overlay").fadeIn();
    }

    ycommon.hidemodal = function (mode) {
        $(".modal_overlay > *").fadeOut();
        $(".modal_overlay").fadeOut();
    }

    ycommon.f_hp_confirm2 = function () {
        if($('#mt_hp_confirm').val()=="") {
            $('#m_hp_confirm_timer_error').html("인증번호를 입력해주세요.");
            $('#mt_hp_confirm').focus();
            return false;
        }

        $.post('./join_update.php', {act: 'confirm_mt_hp', mt_hp: $('#mt_hp').val(), mt_hp_confirm: $('#mt_hp_confirm').val()}, function (data) {
            clearInterval(ycommon.timer);
            if(data=='Y') {
                $('#mt_hp_chk').val('Y').trigger('change');
                $("#mt_hp_confirm").prop("readonly", true);
                $("#mt_hp").prop("readonly", true);
                $("#m_hp_confirm_timer").text("");
                $('#m_hp_confirm_timer_error').addClass("on").html("인증번호가 확인되었습니다.");
                // $('#m_hp_confirm_btn').css("color", "#013DFD");
            } else if (data=='change_hp') {

                $("#m_hp_chk_btn").css("color", "#9CA3AF");
                $("#m_hp_chk_btn").removeClass("disabled2");

                $('#m_hp_confirm_timer_error').html("휴대폰 번호 변경시 재 인증 하셔야 합니다.");
                $("#m_hp_confirm_timer").text("");
            } else {
                $('#m_hp_confirm_timer_error').html("인증번호가 틀립니다.");
                $("#m_hp_confirm_timer").text("");
            }
        });

        return false;
    }

    ycommon.maxLengthCheck = function (object) {
        if (object.value.length > object.maxLength){
            object.value = object.value.slice(0, object.maxLength);
        }
    }

    ycommon.f_mt_id_overlab = function () {
        if ($("#id_check").val() == "Y") return false;
        if($('#mt_id').val()=="") {
            $('#mt_id').addClass("error");
            $('#mt_id_error').html("아이디를 입력해주세요.");
            $('#mt_id').focus();
            return false;
        } else {
            var regExp = /^[a-z]+[a-z0-9]{5,19}$/g;
            if (! regExp.test($('#mt_id').val())) {
                $('#mt_id').addClass("error");
                $('#mt_id_error').html("아이디는 영문자로 시작하는 6~20자 영문자 또는 숫자이어야 합니다.");
                $('#mt_id').focus();
                return false;
            }
        }

        $('#mt_id').removeClass("error");
        $('#mt_id_error').html("");

        $.post('./join_update.php', {act: 'm_id_chk', m_id: $('#mt_id').val()}, function (data) {
            var data = JSON.parse(data);
            console.log(data)
            if(data) {
                $('#id_check').val('Y').trigger('change');
                $("#mt_id").prop("readonly", true);
                $('#mt_id_error').addClass("on").html("사용가능한 아이디입니다.");
                $('#mt_id_overlab_btn').css("color", "#013DFD");
                $('#mt_id').removeClass("error");
            } else {
                $('#mt_id_error').removeClass("on").html("중복 아이디입니다.");
                $('#mt_id').addClass("error");
            }
        });
    }

    ycommon.changeStack = function (page='',extra='') {
        window.webViewBridge.send('changeStack', {page:page,extra:extra}, function(res) {
            // console.log(res);
        }, function(err) {
            // console.error(err);
        });
    }

    ycommon.webviewLogout = function () {
        window.webViewBridge.send('webviewLogout', {}, function(res) {
            // console.log(res);
        }, function(err) {
            // console.error(err);
        });
    }

    ycommon.toastMessage = function (msg) {
        $('.toast_wrap').stop(true).css('display','flex').css('opacity','0').css('bottom','10px');
        $('.toast_wrap').animate({
            opacity: 1,
            bottom: "130px",
        }, 600).delay(1500).animate({
            opacity: 0,
            bottom: "10px",
        },1000,function () {
            $('.toast_wrap').css('display','none');
        });

        $('.toast_message').text(msg);
    }

    ycommon.downloadImage = function (os,url,path) {
        if (os == "iOS") {
            window.webViewBridge.send('downloadImage', {url:path}, function(res) {
                // console.log(res);
            }, function(err) {
                // console.error(err);
            });
        } else {
            location.href = url;
        }
    }

    ycommon.downloadMovie = function (os,url,ext) {
        if (os == "iOS") {
            window.webViewBridge.send('downloadMovie', {url:encodeURI(url), ext:ext}, function(res) {
                // console.log(res);
            }, function(err) {
                // console.error(err);
            });
        } else {
            location.href = url;
        }
    }

    ycommon.getYmdLable = function (ymd='2023-05-19') {
        var week = new Array('일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일');
        return week[new Date(ymd).getDay()];
    }

    ycommon.setData = function(key,data) {
        localStorage.setItem(key, JSON.stringify(data));
    }

    ycommon.getData = function(key) {
        return JSON.parse(localStorage.getItem(key));
    }

    ycommon.deleteData = function(key) {
        localStorage.removeItem(key);
    }

    ycommon.clearData = function() {
        localStorage.clear();
    }

    ycommon.getMultiformDeleteIdxs = function (multiform_delete_idx) {
        let multiform_delete_idx2 = [];
        for (let i=0; i < multiform_delete_idx.length; i++) {
            let multiform_delete_value = multiform_delete_idx[i]+"";
            let ds = multiform_delete_value.split('_');
            let push_data;
            if (ds.length == 1) {
                push_data = ds[0]+"_0";
            } else {
                push_data = multiform_delete_value;
            }
            multiform_delete_idx2.push(push_data);
        }
        return multiform_delete_idx2;
    }

    ycommon.getGenMultiformUploadIdxs = function (multiform_idx) {
        let multiform_idx2 = [];
        for (let i=0; i < multiform_idx.length; i++) {
            let multiform_value = multiform_idx[i]+"";
            let ds = multiform_value.split('_');
            let push_data;
            if (ds.length == 1) {
                push_data = ds[0]+"_0";
            } else {
                push_data = multiform_value;
            }
            multiform_idx2.push(push_data);
        }
        return multiform_idx2;
    }

    ycommon.sortMultiformDeleteIdxs = function (multiform_delete_idx) {
        multiform_delete_idx.sort(function (a,b) {
            let aDs = a+"".split('_');
            let bDs = b+"".split('_');
            if (aDs[0] > bDs[0]) {
                return 1;
            } else if (aDs[0] === bDs[0]) {
                let ads2 = (aDs[2] === undefined) ? 0 : aDs[2];
                let bds2 = (bDs[2] === undefined) ? 0 : bDs[2];
                // console.log('ads2', ads2);
                // console.log('bds2', bds2);
                if (ads2 > bds2) {
                    return 1;
                } else if (ads2 === bds2) {
                    return 0;
                } else if (ads2 < bds2) {
                    return -1;
                }
            } else if ((aDs[0] < bDs[0])) {
                return -1;
            }
        });
        // console.log('multiform_delete_idx', multiform_delete_idx);
    }

    ycommon.setDeleteUploadFile = function (multiform_delete_idx) {

        let multiform_delete_idx2 = ycommon.getMultiformDeleteIdxs(multiform_delete_idx);
        console.log('multiform_delete_idx2', multiform_delete_idx2);
        for(let i=0; i < $('.upload_files').length; i++) {
            let del_keys = [];
            for(let j=0; j < multiform_delete_idx2.length; j++) {
                let ds = multiform_delete_idx2[j].split('_');
                if (ds[0] == i) {
                    del_keys.push(ds[1]);
                }
            }
            del_keys.reverse();
            // console.log('i=',i)
            // console.log('del_keys', del_keys);
            if ($('.upload_files').eq(i).val()) {
                // console.log($('.upload_files')[i].files);
                let files = $('.upload_files')[i].files;
                let fileArray = Array.from(files);
                for(let k=0; k < del_keys.length; k++) {
                    // console.log('del_keys[k]', del_keys[k]);
                    fileArray.splice(del_keys[k], 1);
                }
                // console.log('fileArray', fileArray);
                const dataTransfer = new DataTransfer();
                fileArray.forEach(file => { dataTransfer.items.add(file); });
                $('.upload_files')[i].files = dataTransfer.files;
            }
        }

        multiform_delete_idx = [];
    }

    ycommon.previewImage = function (e, id, upload_cont) {
        var files = e.target.files;
        var filesArr = Array.prototype.slice.call(files);
        filesArr.forEach(function(f,i) {
            // console.log(f);
            if(f.type.match("image.*")) {
                if(f.size > 10 * 1024 * 1024) {
                    alert("이미지는 10메가 이하만 가능합니다.");
                    return;
                }
            } else if (f.type.match("video.*")) {
                if(f.size > 10 * 10 * 1024 * 1024) {
                    alert("이미지는 100메가 이하만 가능합니다.");
                    return;
                }
            } else {
                alert("확장자는 이미지 및 비디오만 가능합니다.");
                return;
            }

            var reader = new FileReader();
            reader.onload = function(e) {
                // console.log('i',i)
                let id2 = id;
                if (i > 0) {
                    id2 = id+"_"+i;
                } else if (i == 0) {
                    $('#label_upload_file_'+id).attr('for','00');
                }
                multiform_idx.push(id2);


                // let rotatedImageDataUrl;
                //
                // loadImage(
                //     e.target.result,
                //     function (img, data) {
                //
                //         console.log(img);
                //         console.log(data);
                //
                //         if (data && data.exif) {
                //             // Exif 데이터가 있을 경우 (회전 정보가 있는 경우)
                //             const orientation = data.exif.get('Orientation');
                //
                //             if (orientation) {
                //                 // 이미지를 회전시키는 작업
                //                 const canvas = document.createElement('canvas');
                //                 const ctx = canvas.getContext('2d');
                //                 canvas.width = img.width;
                //                 canvas.height = img.height;
                //
                //                 // Exif 데이터의 Orientation 정보에 따라 이미지를 회전
                //                 switch (orientation) {
                //                     case 3:
                //                         ctx.rotate(Math.PI);
                //                         ctx.drawImage(img, -img.width, -img.height);
                //                         break;
                //                     case 6:
                //                         canvas.width = img.height;
                //                         canvas.height = img.width;
                //                         ctx.rotate(0.5 * Math.PI);
                //                         ctx.drawImage(img, 0, -img.height);
                //                         break;
                //                     case 8:
                //                         canvas.width = img.height;
                //                         canvas.height = img.width;
                //                         ctx.rotate(-0.5 * Math.PI);
                //                         ctx.drawImage(img, -img.width, 0);
                //                         break;
                //                     default:
                //                         ctx.drawImage(img, 0, 0);
                //                         break;
                //                 }
                //
                //                 // 회전된 이미지를 data URL로 가져옴
                //                 rotatedImageDataUrl = canvas.toDataURL('image/jpeg');
                //             }
                //         }
                //     },
                //     { meta: true, orientation: true, canvas: true }
                // );

                // loadImage(
                //     e.target.result,
                //     function(img) {
                //         var canvas = document.createElement('canvas');
                //         var ctx = canvas.getContext('2d');
                //         canvas.width = img.width;
                //         canvas.height = img.height;
                //         ctx.drawImage(img, 0, 0);
                //
                //         rotatedImageDataUrl = canvas.toDataURL('image/jpeg'); // 회전된 이미지를 JPEG 형식으로 가져옵니다.
                //     }
                //
                //     // function (img, data) {
                //     //     if (data.imageHead && data.exif) {
                //     //         // 3. exif 값이 있다면 orientation 값을 1로 변경
                //     //         loadImage.writeExifData(data.imageHead, data, 'Orientation', 1);
                //     //         img.toBlob(function (blob) {
                //     //             loadImage.replaceHead(blob, data.imageHead, async function (newBlob) {
                //     //                 newBlob.name = file.name;
                //     //             });
                //     //         }, 'image/jpeg');
                //     //     }
                //     // }
                // );

                // e.target.result = rotatedImageDataUrl;

                // console.log(e.target.result);
                $("#image-upload-"+id2).addClass('on');
                if (e.target.result.match("video.*")) {
                    let html = '<div class="att_img mb-4" id="imageVideo'+id2+'">' +
                        '<div class="rounded overflow-hidden">' +
                            '<video>' +
                                '<source src="'+e.target.result+'" class="w-100">' +
                            '</video>' +
                        '</div>' +
                    '</div>' ;
                    // console.log(html);
                    $("#imageVideo").append(html);
                    if (i == 0) {
                        $("#image-upload-"+id2).find('.del').after('<video><source src="'+e.target.result+'" /></video>');
                    } else {
                        let addForm = '<div class="image-upload2 mr-3 on" data-id="'+id2+'" id="image-upload-'+id2+'">'+
                            '<label id="label_upload_file_'+id2+'" for="upload_file_'+id2+'">' +
                            '<div class="upload-icon2">' +
                            '<button type="button" class="btn del"></button>' +
                            '<video><source src="'+e.target.result+'" /></video>' +
                            '</div>' +
                            '</label>' +
                            '</div>';
                        $('#imgUpload').append(addForm);
                    }
                } else {
                    let html = '<div class="att_img mb-4" id="imageVideo'+id2+'">' +
                        '<div class="rounded overflow-hidden">' +
                            '<img src="'+e.target.result+'" class="w-100">' +
                        '</div>' +
                    '</div>' ;
                    // console.log(html);
                    $("#imageVideo").append(html);

                    if (i == 0) {
                        $("#image-upload-"+id2).find('.del').after('<img src="'+e.target.result+'" />');
                    } else {
                        let addForm = '<div class="image-upload2 mr-3 on" data-id="'+id2+'" id="image-upload-'+id2+'">'+
                            '<label id="label_upload_file_'+id2+'" for="upload_file_'+id2+'">' +
                            '<div class="upload-icon2">' +
                            '<button type="button" class="btn del"></button>' +
                            '<img src="'+e.target.result+'" />' +
                            '</div>' +
                            '</label>' +
                            '</div>';
                        $('#imgUpload').append(addForm);
                    }
                }

                ycommon.setUploadCount(upload_cont);
            }
            reader.readAsDataURL(f);
        });
    }

    ycommon.getUploadCount = function (upload_cont) {
        let up_idx = ycommon.getGenMultiformUploadIdxs(multiform_idx);
        let del_idx = ycommon.getMultiformDeleteIdxs(multiform_delete_idx);
        // console.log('up_idx', up_idx);
        // console.log('del_idx', del_idx);
        let j = 0;
        for(let i=0; i < $('.upload_files').length; i++) {
            if ($('.upload_files').eq(i).val()) {
                let jPlus = 1;
                for (let k=0; k<up_idx.length; k++) {
                    if (up_idx[k].indexOf(i+"_") !== -1 && (up_idx[k] != i+"_0")) {
                        // console.log('k',k);
                        // console.log('up_idx[k]',up_idx[k]);
                        // console.log('i_0',i+"_0");
                        jPlus++;
                    }
                }
                for (let k=0; k<del_idx.length; k++) {
                    if (del_idx[k].indexOf(i+"_") !== -1) {
                        jPlus--;
                    }
                }
                j += jPlus;
            }
        }
        // console.log('j',j);
        // console.log("----");
        // console.log('multiform_idx.length',multiform_idx.length);
        // console.log('multiform_delete_idx.length',multiform_delete_idx.length);
        // console.log('upload_cont',upload_cont);
        // j = multiform_idx.length - multiform_delete_idx.length;
        if (upload_cont !== undefined) j += upload_cont;
        return j;
    }

    ycommon.setUploadCount = function (upload_cont) {
        $('#uploadCount').text(ycommon.getUploadCount(upload_cont));
    }

    /* 2번째 이미지 */

    ycommon.previewImage2 = function (e, id, upload_cont) {
        var files = e.target.files;
        var filesArr = Array.prototype.slice.call(files);
        filesArr.forEach(function(f,i) {
            // console.log(f);
            if(f.type.match("image.*")) {
                if(f.size > 10 * 1024 * 1024) {
                    alert("이미지는 10메가 이하만 가능합니다.");
                    return;
                }
            } else if (f.type.match("video.*")) {
                if(f.size > 10 * 10 * 1024 * 1024) {
                    alert("이미지는 100메가 이하만 가능합니다.");
                    return;
                }
            } else {
                alert("확장자는 이미지 및 비디오만 가능합니다.");
                return;
            }

            var reader = new FileReader();
            reader.onload = function(e) {
                // console.log('i',i)
                let id2 = id;
                if (i > 0) {
                    id2 = id+"_"+i;
                } else if (i == 0) {
                    $('#label_upload_file2_'+id).attr('for','00');
                }
                multiform_idx2.push(id2);
                // console.log(e.target.result);
                $("#image-upload2-"+id2).addClass('on');
                if (e.target.result.match("video.*")) {
                    let html = '<div class="att_img mb-4" id="imageVideo2'+id2+'">' +
                        '<div class="rounded overflow-hidden">' +
                        '<video>' +
                        '<source src="'+e.target.result+'" class="w-100">' +
                        '</video>' +
                        '</div>' +
                        '</div>' ;
                    // console.log(html);
                    $("#imageVideo2").append(html);
                    if (i == 0) {
                        $("#image-upload2-"+id2).find('.del2').after('<video><source src="'+e.target.result+'" /></video>');
                    } else {
                        let addForm = '<div class="image-upload2 mr-3 on" data-id2="'+id2+'" id="image-upload2-'+id2+'">'+
                            '<label id="label_upload_file2_'+id2+'" for="upload_file2_'+id2+'">' +
                            '<div class="upload-icon2">' +
                            '<button type="button" class="btn del2"></button>' +
                            '<video><source src="'+e.target.result+'" /></video>' +
                            '</div>' +
                            '</label>' +
                            '</div>';
                        $('#imgUpload2').append(addForm);
                    }
                } else {
                    let html = '<div class="att_img mb-4" id="imageVideo2'+id2+'">' +
                        '<div class="rounded overflow-hidden">' +
                        '<img src="'+e.target.result+'" class="w-100">' +
                        '</div>' +
                        '</div>' ;
                    // console.log(html);
                    $("#imageVideo2").append(html);

                    if (i == 0) {
                        $("#image-upload2-"+id2).find('.del2').after('<img src="'+e.target.result+'" />');
                    } else {
                        let addForm = '<div class="image-upload2 mr-3 on" data-id2="'+id2+'" id="image-upload2-'+id2+'">'+
                            '<label id="label_upload_file2_'+id2+'" for="upload_file2_'+id2+'">' +
                            '<div class="upload-icon2">' +
                            '<button type="button" class="btn del2"></button>' +
                            '<img src="'+e.target.result+'" />' +
                            '</div>' +
                            '</label>' +
                            '</div>';
                        $('#imgUpload2').append(addForm);
                    }
                }

                ycommon.setUploadCount2(upload_cont);
            }
            reader.readAsDataURL(f);
        });
    }

    ycommon.getUploadCount2 = function (upload_cont2) {
        let up_idx = ycommon.getGenMultiformUploadIdxs(multiform_idx2);
        let del_idx = ycommon.getMultiformDeleteIdxs(multiform_delete_idx2);
        // console.log('up_idx', up_idx);
        // console.log('del_idx', del_idx);
        let j = 0;
        for(let i=0; i < $('.upload_files2').length; i++) {
            if ($('.upload_files2').eq(i).val()) {
                let jPlus = 1;
                for (let k=0; k<up_idx.length; k++) {
                    if (up_idx[k].indexOf(i+"_") !== -1 && (up_idx[k] != i+"_0")) {
                        // console.log('k',k);
                        // console.log('up_idx[k]',up_idx[k]);
                        // console.log('i_0',i+"_0");
                        jPlus++;
                    }
                }
                for (let k=0; k<del_idx.length; k++) {
                    if (del_idx[k].indexOf(i+"_") !== -1) {
                        jPlus--;
                    }
                }
                j += jPlus;
            }
        }
        // console.log('j',j);
        // console.log("----");
        // console.log('multiform_idx.length',multiform_idx.length);
        // console.log('multiform_delete_idx.length',multiform_delete_idx.length);
        // console.log('upload_cont2',upload_cont2);
        // j = multiform_idx.length - multiform_delete_idx.length;
        if (upload_cont2 !== undefined) j += upload_cont2;
        return j;
    }

    ycommon.setUploadCount2 = function (upload_cont) {
        $('#uploadCount2').text(ycommon.getUploadCount2(upload_cont));
    }

    /* 3번째 이미지 */

    ycommon.previewImage3 = function (e, id, upload_cont) {
        var files = e.target.files;
        var filesArr = Array.prototype.slice.call(files);
        filesArr.forEach(function(f,i) {
            // console.log(f);
            if(f.type.match("image.*")) {
                if(f.size > 10 * 1024 * 1024) {
                    alert("이미지는 10메가 이하만 가능합니다.");
                    return;
                }
            } else if (f.type.match("video.*")) {
                if(f.size > 10 * 10 * 1024 * 1024) {
                    alert("이미지는 100메가 이하만 가능합니다.");
                    return;
                }
            } else {
                alert("확장자는 이미지 및 비디오만 가능합니다.");
                return;
            }

            var reader = new FileReader();
            reader.onload = function(e) {
                // console.log('i',i)
                let id2 = id;
                if (i > 0) {
                    id2 = id+"_"+i;
                } else if (i == 0) {
                    $('#label_upload_file3_'+id).attr('for','00');
                }
                multiform_idx3.push(id2);
                // console.log(e.target.result);
                $("#image-upload3-"+id2).addClass('on');
                if (e.target.result.match("video.*")) {
                    let html = '<div class="att_img mb-4" id="imageVideo3'+id2+'">' +
                        '<div class="rounded overflow-hidden">' +
                        '<video>' +
                        '<source src="'+e.target.result+'" class="w-100">' +
                        '</video>' +
                        '</div>' +
                        '</div>' ;
                    // console.log(html);
                    $("#imageVideo3").append(html);
                    if (i == 0) {
                        $("#image-upload3-"+id2).find('.del3').after('<video><source src="'+e.target.result+'" /></video>');
                    } else {
                        let addForm = '<div class="image-upload2 mr-3 on" data-id3="'+id2+'" id="image-upload3-'+id2+'">'+
                            '<label id="label_upload_file3_'+id2+'" for="upload_file3_'+id2+'">' +
                            '<div class="upload-icon2">' +
                            '<button type="button" class="btn del3"></button>' +
                            '<video><source src="'+e.target.result+'" /></video>' +
                            '</div>' +
                            '</label>' +
                            '</div>';
                        $('#imgUpload3').append(addForm);
                    }
                } else {
                    let html = '<div class="att_img mb-4" id="imageVideo3'+id2+'">' +
                        '<div class="rounded overflow-hidden">' +
                        '<img src="'+e.target.result+'" class="w-100">' +
                        '</div>' +
                        '</div>' ;
                    // console.log(html);
                    $("#imageVideo3").append(html);

                    if (i == 0) {
                        $("#image-upload3-"+id2).find('.del3').after('<img src="'+e.target.result+'" />');
                    } else {
                        let addForm = '<div class="image-upload2 mr-3 on" data-id3="'+id2+'" id="image-upload3-'+id2+'">'+
                            '<label id="label_upload_file3_'+id2+'" for="upload_file3_'+id2+'">' +
                            '<div class="upload-icon2">' +
                            '<button type="button" class="btn del3"></button>' +
                            '<img src="'+e.target.result+'" />' +
                            '</div>' +
                            '</label>' +
                            '</div>';
                        $('#imgUpload3').append(addForm);
                    }
                }

                ycommon.setUploadCount3(upload_cont);
            }
            reader.readAsDataURL(f);
        });
    }

    ycommon.getUploadCount3 = function (upload_cont2) {
        let up_idx = ycommon.getGenMultiformUploadIdxs(multiform_idx3);
        let del_idx = ycommon.getMultiformDeleteIdxs(multiform_delete_idx3);
        // console.log('up_idx', up_idx);
        // console.log('del_idx', del_idx);
        let j = 0;
        for(let i=0; i < $('.upload_files3').length; i++) {
            if ($('.upload_files3').eq(i).val()) {
                let jPlus = 1;
                for (let k=0; k<up_idx.length; k++) {
                    if (up_idx[k].indexOf(i+"_") !== -1 && (up_idx[k] != i+"_0")) {
                        // console.log('k',k);
                        // console.log('up_idx[k]',up_idx[k]);
                        // console.log('i_0',i+"_0");
                        jPlus++;
                    }
                }
                for (let k=0; k<del_idx.length; k++) {
                    if (del_idx[k].indexOf(i+"_") !== -1) {
                        jPlus--;
                    }
                }
                j += jPlus;
            }
        }
        // console.log('j',j);
        // console.log("----");
        // console.log('multiform_idx.length',multiform_idx.length);
        // console.log('multiform_delete_idx.length',multiform_delete_idx.length);
        // console.log('upload_cont2',upload_cont2);
        // j = multiform_idx.length - multiform_delete_idx.length;
        if (upload_cont2 !== undefined) j += upload_cont2;
        return j;
    }

    ycommon.setUploadCount3 = function (upload_cont) {
        $('#uploadCount3').text(ycommon.getUploadCount3(upload_cont));
    }

    $(document).ready(function() {
        //복사 버튼 클릭시 복사
        $(document).on('click','button.clip',function(e){
            $("body").append("<input type=\"text\" id=\"clipIpt\" value=\"\" />");

            var clip = $(this).data('clip');
            $('#clipIpt').val(clip);

            var inputClip = document.getElementById("clipIpt");
            inputClip.select();
            try {
                var successful = document.execCommand('copy');
                if (!successful) {
                    alert('이 브라우저는 지원하지 않습니다.');
                }
            } catch (err) {
                alert('이 브라우저는 지원하지 않습니다.');
            }
            $('#clipIpt').remove();

            // alert(clip)
            $('button.clip').each(function(i,ee){
                if ($(ee).hasClass('bg_YE')) {
                    $(ee).removeClass('bg_YE').addClass('bg_F9');
                }
                // $(ee).hasClass('bg_F9').removeClass('bg_F9').addClass('bg_Rt');
            });
            $(this).removeClass('bg_ER').removeClass('bg_F9').addClass('bg_YE');
            e.preventDefault();
            return false;
        });

        //정수만
        $(document).on('keyup','.onlyint',function(e){
            ycommon.checkKey(e);
            ycommon.replaceInt($(this));
        });

        //숫자만..
        $(document).on('keyup','.onlynum',function(e){
            ycommon.checkKey(e);
            ycommon.replaceNumber($(this));
        });


        //숫자만 + 넘버포멧
        $(document).on('keydown keyup','.numformat2',function(e){
            if(window.event) keycode = window.event.keyCode;
            else if(e) keycode = e.which;
            else {
                event.returnValue = false;
                return false;
            }
            if( e.type == 'keydown'){
                ycommon.checkKey(e);
            }
            if( e.type == 'keyup'){
                ycommon.replaceNumber($(this));
                $(this).val( ycommon.setPriceInput($(this).val()) );
                if(keycode == 9) {
                    $(this).select();
                }
            }
        });

        //정수만 + 넘버포멧
        $(document).on('keydown keyup','.numformat',function(e){
            if(window.event) keycode = window.event.keyCode;
            else if(e) keycode = e.which;
            else {
                event.returnValue = false;
                return false;
            }
            if( e.type == 'keydown'){
                ycommon.checkKey(e);
            }
            if( e.type == 'keyup'){
                ycommon.replaceInt($(this));
                $(this).val( ycommon.setPriceInput($(this).val()) );
                if(keycode == 9) {
                    $(this).select();
                }
            }
        });

        //휴대폰번호
        $(document).on('keydown keyup','.phoneHypen',function(e){
            var limitByte = 13;
            var keycode   = '';
            if(window.event) keycode = window.event.keyCode;
            else if(e) keycode = e.which;
            else {
                event.returnValue = false;
                return false;
            }
            if( e.type == 'keydown'){
                ycommon.checkKey(e);
            }
            if( e.type == 'keyup'){
                var str = $(this).val();
                if (str.length > 13) $(this).val(ycommon.cutByte(str,limitByte));
                str = $(this).val();
                $(this).val(ycommon.autoHypenPhone(str));
                if(keycode == 9) {
                    $(this).select();
                }
            }
        });

        //기업코드검색
        $(document).on('click', '#ct_code_search', function(){
            var ct_name = $('#ct_name').val();
            ct_name = ct_name.trim();
            if (ct_name == "") {
                jalert_url('기업명을 입력해주세요.','none','기업선택검색');
                return false;
            }

            var modal_body = "";
            $('#ct_idx option').each(function(){
                var txt = $(this).text();
                if (txt.indexOf(ct_name) !== -1) {
                    modal_body += '<div class="form-group row">\
                                                <label class="col-sm-2 col-form-label text-center">기업명</label>\
                                            <div class="col-sm-6 col-form-text">\
                                                '+txt+'\
                                            </div>\
                                            <div class="col-sm-4">\
                                                <input type="button" class="btn btn-info select_customer22_btn" data-value="'+txt+'" data-key="'+this.value+'" value="선택">\
                                            </div>\
                                        </div>';
                }
            });

            var html = '<div class="modal-header">\
                                        <h5 class="modal-title" id="staticBackdropLabel">등록된 기업 검색</h5>\
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>\
                                    </button>\
                                </div>\
                                    <div class="modal-body company_form">\
                                        {modal_body}\
                                    </div>';

            html = html.replace(/{modal_body}/gi, modal_body);

            $('#modal-default-content').html(html);
            $('#modal-default').modal();

        });

        $(document).on('click', '.select_customer22_btn', function(){
            var value = $(this).data('value');
            var key = $(this).data('key');

            // $('#ct_code').val(ts_isin).attr('readonly','readonly');
            // $('#ct_name').val(ts_com_name).attr('readonly','readonly');
            // console.log(key,value)
            $('#ct_idx').val(key);
            $('#modal-default').modal('hide');
        });

        $(document).on('click', '.company_add', function(){
            window.open('/mng/company_form.php?act=input')
        });

        $(document).on('keyup','#ct_name',function (){
            if (event.keyCode === 13) {
                $('#ct_code_search').trigger('click');
            };
        });

        $(document).on('click', '#mt_id_chk_btn', function (e){
            var mt_id = $('input[name=mt_id]').val();
            if (mt_id == '') {
                jalert_url("아이디를 입력해주세요.","none");
                return false;
            }

            var action = './member_update.php';
            var data = {act:'chk_mt_id',mt_id:mt_id};
            ycommon.ajaxJson(action,data,undefined,function(data){
                if (data.bool) {
                    // jalert_url("아이디가 중복되지 않습니다. <br />입력하신 "+mt_id+"는 사용가능합니다.", 'none');
                    $('input[name=mt_id]').attr("readonly", true);
                    $('input[name=mt_id]').css("background-color", '#e9ecef');
                    $('#mt_id_chk_btn').addClass('d-none');
                } else {
                    jalert_url("아이디가 중복됩니다. <br />다른 아이디를 입력해주세요.", 'none');
                }
            });

            e.preventDefault();
            return false;
        });

        $(document).on('click','#push_wating_add',function (e){
            var title = $('#subject1').val();
            var msg = $('#Ssject_0').val();
            var ct_idx = $(this).data('ct_idx');
            var action = '/mng/category_update.php';
            var data = {act:'push_wating_add',ct_idx:ct_idx,msg:msg,title:title};
            ycommon.ajaxJson(action,data,undefined,function(data){
                if (data.bool) {
                    jalert_url(data.msg2, '/mng/push_list.php')
                }
            });
            e.preventDefault();
            return false;
        });

        $(document).on('click','#push_member_send',function (e){
            var title = $('#subject1').val();
            var msg = $('#Ssject_0').val();
            var mt_idx = $(this).data('mt_idx');
            var action = '/mng/category_update.php';
            var data = {act:'push_member_send',mt_idx:mt_idx,msg:msg,title:title};
            ycommon.ajaxJson(action,data,undefined,function(data){
                if (data.bool) {
                    jalert_url(data.msg2, '/mng/push_list.php')
                }
            });
            e.preventDefault();
            return false;
        });

        // $("#mt_hp, #rf_hp").inputmask("999-9{3,4}-9{3,5}");
        $("#mt_hp, #rf_hp").on('keydown keyup',function (e){

            var limitByte = 13;
            var keycode   = '';
            if(window.event) keycode = window.event.keyCode;
            else if(e) keycode = e.which;
            else {
                event.returnValue = false;
                return false;
            }
            if( e.type == 'keydown'){
                ycommon.checkKey(e);
            }
            if( e.type == 'keyup'){
                var str = $(this).val();
                if (str.length > 13) $(this).val(ycommon.cutByte(str,limitByte));
                str = $(this).val();
                $(this).val(ycommon.autoHypenPhone(str));
                if(keycode == 9) {
                    $(this).select();
                }
            }

            check_next_btn();
        });

        //숫자만 + 넘버포멧
        $(document).on('keydown keyup','#mt_hp_confirm',function(e){
            if(window.event) keycode = window.event.keyCode;
            else if(e) keycode = e.which;
            else {
                event.returnValue = false;
                return false;
            }
            if( e.type == 'keydown'){
                ycommon.checkKey(e);
            }
            if( e.type == 'keyup'){
                // ycommon.replaceNumber($(this));
                // $(this).val( ycommon.setPriceInput($(this).val()) );
                // if(keycode == 9) {
                //     $(this).select();
                // }

                console.log()

                if ($(this).val().length == 6) {
                    $('#m_hp_confirm_btn').css("color", "#013DFD");
                } else {
                    $("#m_hp_confirm_btn").css("color", "#9CA3AF");
                }
            }
        });

        $(".modal_overlay").click(function (){
            ycommon.hidemodal();
        });

    });

    return ycommon;
})(window.ycommon || {}, window.jQuery || $, window)

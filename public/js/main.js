// fixed 포지션 변수 설정
// $(window).on('load resize', function () {
//     let wrap_wd_2 = $('.right_wrapper').outerWidth() / 2;
//     $(':root').css('--wrap_wd_2', wrap_wd_2 + 'px');
// });

$(window).on('scroll', function () {
    if ($(this).scrollTop() > 50) {
        $('.h_menu').addClass('scroll');
    } else {
        $('.h_menu').removeClass('scroll');
    }
});

$(window).on("load resize", function() {
    const winW = $(window).innerWidth();
    if(winW > 991) {
        $('.filter_modal').addClass('fade');
        $('.filter_modal').removeClass('show');
    }
});

$('html').click(function (e) {
    const btn = $(e.target).parents('.btn_more');
    if (!btn.hasClass('btn_more')) {
        $('.more_cont').removeClass('on');
        $('.more_cont').slideUp();
    }

    const select = $(e.target).parents(".m_select_wrap");
    if (!select.hasClass('m_select_wrap')) {
        $(".m_select").removeClass("focus");
        $('.m_select_list').hide();
    }
});



// 더보기 버튼
$('.btn_more').on('click', function (e) {
    e.preventDefault();
    $('.more_cont').removeClass('on');
    $('.more_cont').slideUp();
    if ($(this).siblings('.more_cont').hasClass('on')) {

    } else {
        $('.more_cont').removeClass('on');
        $('.more_cont').slideUp();
    }
    $(this).siblings('.more_cont').slideToggle();
    $(this).siblings('.more_cont').addClass('on');
});

$('.more_cont .btn').on('click', function (e) {
    e.preventDefault();
});

// 공지사항 필터 on-off
$('.btn_filter').on('click', function () {
    $('body').addClass('scrollDisable').on('scroll touchmove mousewheel', function(e){
        e.preventDefault();
    });
    $('.filter_modal').addClass('show');
    $('.filter_modal').removeClass('fade');
});
$('.filter_modal').on('click', function () {
    $('body').removeClass('scrollDisable').off('scroll touchmove mousewheel');

    $('.filter_modal').addClass('fade');
    $('.filter_modal').removeClass('show');
});

// 모달창 show-hide
function modalShow(tgId) {
    $(".modal_bg#"+tgId).addClass("show");
    $("body").addClass("overflow-hidden");
}
function modalHide(tgId) {
    $(".modal_bg#"+tgId).removeClass("show");
    $("body").removeClass("overflow-hidden");
}
$(".modal_bg").on("click", function(e) {
    const modalConts = $(e.target).parents(".modal_wrap");
    if (!modalConts.hasClass('modal_wrap')) {
        $(".modal_bg").removeClass("show");
        $("body").removeClass("overflow-hidden");
    }
});

// 로딩 show-hide
function loadingShow() {
    $("#loading").show();
}
function loadingHide() {
    $("#loading").hide();
}


// slider
const adviceSlider = new Swiper(".advice_slider", {
    spaceBetween: 15,
    breakpoints: {
        0: { slidesPerView: 1 },
        768: { slidesPerView: "auto" },
    },
});

const bannerSlider = new Swiper(".banner_slider", {
    slidesPerView: 1,
    spaceBetween: 4,
    // direction: "vertical",
    loop: true,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false
    },
});

// 클립보드 복사
function boardCopy(inputId) {
    const copyElement = document.getElementById(inputId);
    copyElement.select();
    copyElement.setSelectionRange(0, 9999);
    const copy = document.execCommand("copy");

    if (copy) {
        alert("클립보드 복사되었습니다.");
    } else {
        alert("이 브라우저는 지원하지 않습니다.");
    }
}

// 전체 선택
$("#chkAll").on("click", function() {
    if($("#chkAll").is(":checked")) $("input[name=chk1]").prop("checked", true);
    else $("input[name=chk1]").prop("checked", false);
});
$("input[name=chk1]").on("click", function() {
    const total = $("input[name=chk1]").length;
    const checked = $("input[name=chk1]:checked").length;

    if(total != checked) $("#chkAll").prop("checked", false);
    else $("#chkAll").prop("checked", true);
});

// 자동 검색
$(".m_select").on("click", function() {
    $(this).addClass("focus");
    $(this).parents(".m_select_wrap").find(".m_select_list").show();
});
function autoSearch(data, listId, inputId, fn, index, xFn) {
    const ulEl = document.getElementById(listId);
    const inputEl = document.getElementById(inputId);

    // 선택되있는 상태
    if(index) {
        const selectedData = data.filter((item) => {
            if(item.idx == index) return item;
        });
        inputEl.value = selectedData[0].name;
    }

    // object 에 초성필드 추가 {name:"홍길동", diassembled:"ㅎㄱㄷ"}
    data.map((item) => {
        const dis = Hangul.disassemble(item.name, true);
        const cho = dis.reduce(function (prev, elem) {
        elem = elem[0] ? elem[0] : elem;
        return prev + elem;
        }, "");
        item.diassembled = cho;
    });

    const btnClick = (e) => {
        const text = e.target.innerText;
        inputEl.value = text;
        inputEl.blur();
        ulEl.innerHTML = "";
        if ( typeof ( fn ) == "function" ){
            fn(e);
        }
    };
    const noData = (listId) => {
        const ulEl = document.getElementById(listId);
        const li = document.createElement("li");
        li.setAttribute('class', 'list_none');
        li.innerHTML = "데이터가 없습니다.";
        ulEl.appendChild(li);
    }
    const dataAdd = (listId, item) => {
        // 검색결과 ul 아래에 li 로 추가
        const ul = document.getElementById(listId);
        const li = document.createElement("li");
        li.setAttribute('data-idx', item.idx);
        const button = document.createElement("button");
        button.addEventListener("click", btnClick);
        button.setAttribute('data-idx', item.idx);
        button.innerHTML = item.name;
        li.appendChild(button);
        ul.appendChild(li);
    }
    function dataListAppend(deleteBtn, _this) {
        ulEl.innerHTML = "";

        if(data.length <= 0) noData(listId);
        if(deleteBtn == true) { // X 버튼 클릭 시
            data.map((item) => {
                dataAdd(listId, item);
            });
        } else {
            if(this.value === "") {
                this.nextElementSibling.classList.remove('show');
                data.map((item) => {
                    dataAdd(listId, item);
                });
                return;
            } else {
                this.nextElementSibling.classList.add('show');
            }
        }

        // while (ulEl.firstChild) {
        //     ulEl.removeChild(ulEl.firstChild);
        // }
        const search = this.value || _this.value;
        const search1 = Hangul.disassemble(search).join(""); // ㄺ=>ㄹㄱ

        data.filter((item) => {
            // 문자열 검색 || 초성검색
            return (
                item.name.includes(search) || item.diassembled.includes(search1)
            );
        }).map((item) => {
            dataAdd(listId, item);
        });
    }

    // $(`#${inputId}`).on("click keyup", dataListAppend);

    inputEl.addEventListener("click", dataListAppend);
    inputEl.addEventListener("keyup", dataListAppend);

    $(".m_delete").on("click", function(e) {
        let xFnReturn = true;
        if ( typeof ( xFn ) == "function" ){
            xFnReturn = xFn(e);
        }
        if (xFnReturn === false) {
            return false;
        }
        dataListAppend(true, e.currentTarget);
        $(this).prev(".m_select").focus().addClass("focus").val("");
        $(this).removeClass("show");
    });
}

// 비메오 비디오 썸네일 받아오기
function vimeoThumbRecall (num, i) {
    let action = `/api/videos/${num}`;
    ycommon.ajaxJson('get', action, '', undefined, function(data) {
        // console.log("DATA2:", i, data);
        const resData = data?.data?.body?.pictures;
        const src = resData?.sizes[2]?.link;
        if($(`.video_thumb#vimeo${i}`).hasClass("loading"))
            $(`.video_thumb#vimeo${i}`).removeClass("loading");
        $(`.video_thumb#vimeo${i}`).attr('src', src);
    }, undefined,()=>{});
}
function getVimeoThumbs () {
    const count = $(".video_thumb").length;
    if(count > 0) {
        let defer = new $.Deferred();
        let next = defer;

        for(let i=0; i<count; i++){
            const num = $(`.video_thumb#vimeo${i}`).data('vimeo');

            if(num){
                let action = `/api/videos/${num}`;

                next = ycommon.ajaxJson('get', action, '', undefined, undefined, undefined, () => vimeoThumbRecall(num, i));

                next.then(function(data){
                    // console.log("DATA:", i, data);
                    const resData = data?.data?.body?.pictures;
                    const src = resData?.sizes[2]?.link;
                    if($(`.video_thumb#vimeo${i}`).hasClass("loading"))
                        $(`.video_thumb#vimeo${i}`).removeClass("loading");
                    $(`.video_thumb#vimeo${i}`).attr('src', src);
                });
            }
        }
    }
}
// 비메오 비디오 받아오기
function vimeoVideoRecall (num, i) {
    let action = `/api/videos/${num}`;
    ycommon.ajaxJson('get', action, '', undefined, function(data) {
        // console.log("DATA2:", i, data);
        const resData = data?.data?.body;
        let link = resData?.download[0]?.link ?? '';
        if (link == "") link = 'javascript:void(0);';
        else {
            let qtIdx = 0;
            let tmpIdxValue = 0;
            if (resData?.download.length > 0) {
                for (let i=0; i<resData?.download.length; i++) {
                    let rendition = resData?.download[i].rendition;
                    rendition = rendition.replaceAll('p','');
                    rendition = Number(rendition);
                    // console.log('rendition',rendition,'tmpIdxValue',tmpIdxValue);
                    if (rendition > tmpIdxValue) {
                        tmpIdxValue = rendition;
                        qtIdx = i;
                        // console.log(tmpIdxValue, qtIdx);
                    }
                }
            }
            // console.log('=',tmpIdxValue, qtIdx);
            if (qtIdx > 0) link = resData?.download[qtIdx]?.link;
            const ext = resData?.download[qtIdx]?.type.replaceAll('video/','') ?? '';
            link = "javascript:ycommon.downloadMovie(os,'"+link+"','"+ext+"')";
        }
        // const src = resData?.player_embed_url;
        // const iframeHtml = `<button type="button" class="btn btn_play"><img src="/img/ic_play.png" /></button>
        // <a href="${link}" class="btn btn_dl"><img src="/img/ic_download.svg"></a>
        // <iframe src="${src}&title=0&byline=0&portrait=0&controls=0" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen title="Untitled"></iframe>`;
        // $(`.video_area#vimeo${i}`).html(iframeHtml);

        const options = {
            id: num,
            title: false,
            byline: false,
            portrait: false,
            controls: false,
        }
        const player = new Vimeo.Player(elId, options);
        // player.on('play', function() {
        //     console.log('played the video!');
        // });
        player.on('ended', function() {
            $('#playButton'+i).show();
            $('#playButton'+i).removeClass('plaing');
        });
        player.on('pause', function() {
            $('#playButton'+i).show();
            $('#playButton'+i).removeClass('plaing');
        });

        const playButton = `<button type="button" class="btn btn_play" id="playButton${i}"><img src="/img/ic_play.png" /></button>`;
        const pauseButton = `<button type="button" class="btn btn_pause" id="pauseButton${i}"><img src="/img/ic_pause.png" /></button>`;
        const downloadButton = `<a href="${link}" class="btn btn_dl"><img src="/img/ic_download.svg"></a>`;

        $(`.video_area#vimeo${i}`).find('img').hide();
        $(`.video_area#vimeo${i}`).append(playButton + pauseButton + downloadButton);

        $(document).on('click','#playButton'+i,function (){
            let $this = $(this)
            player.play().then(function (){
                $this.addClass('plaing');
                $this.hide();
            });
        });

        $(document).on('click','#pauseButton'+i,function (){
            player.pause().then(function (){
            });
        });
    }, undefined, () => {});
}
function getVimeoVideo () {
    // return;
    let count = $(".video_area").length;
    if(count > 0) {
        let defer = new $.Deferred();
        let next = defer;

        for(let i=0; i<count; i++){
            const num = $(`.video_area#vimeo${i}`).data('vimeo');
            const elId = $(`.video_area#vimeo${i}`).attr('id');

            if(num){
                let action = `/api/videos/${num}`;

                next = ycommon.ajaxJson('get', action, '', undefined, undefined, undefined, () => vimeoVideoRecall(num, i));

                next.then(function(data, v){
                    // console.log("DATA:", i, elId, data);


                    const resData = data?.data?.body;
                    console.log(resData);
                    let link = resData?.download[0]?.link ?? '';
                    if (link == "") link = 'javascript:void(0);';
                    else {
                        let qtIdx = 0;
                        let tmpIdxValue = 0;
                        if (resData?.download.length > 0) {
                            for (let i=0; i<resData?.download.length; i++) {
                                let rendition = resData?.download[i].rendition;
                                rendition = rendition.replaceAll('p','');
                                rendition = Number(rendition);
                                // console.log('rendition',rendition,'tmpIdxValue',tmpIdxValue);
                                if (rendition > tmpIdxValue) {
                                    tmpIdxValue = rendition;
                                    qtIdx = i;
                                    // console.log(tmpIdxValue, qtIdx);
                                }
                            }
                        }
                        // console.log('=',tmpIdxValue, qtIdx);
                        if (qtIdx > 0) link = resData?.download[qtIdx]?.link;
                        const ext = resData?.download[qtIdx]?.type.replaceAll('video/','') ?? '';
                        link = "javascript:ycommon.downloadMovie(os,'"+link+"','"+ext+"')";
                    }
                    // const src = resData?.player_embed_url;
                    // const iframeHtml = `<button type="button" class="btn btn_play"><img src="/img/ic_play.png" /></button>
                    // <a href="${link}" class="btn btn_dl"><img src="/img/ic_download.svg"></a>
                    // <iframe src="${src}&title=0&byline=0&portrait=0&controls=0" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen title="Untitled"></iframe>`;
                    // $(`.video_area#vimeo${i}`).html(iframeHtml);
                    const options = {
                        id: num,
                        title: false,
                        byline: false,
                        portrait: false,
                        controls: false,
                        playsinline: false
                    }
                    const player = new Vimeo.Player(elId, options);
                    // player.on('play', function() {
                    //     console.log('played the video!');
                    // });
                    player.on('ended', function() {
                        $('#playButton'+i).show();
                        $('#playButton'+i).removeClass('plaing');
                        player.setCurrentTime(0);
                    });
                    player.on('pause', function() {
                        $('#playButton'+i).show();
                        $('#playButton'+i).removeClass('plaing');
                    });

                    const playButton = `<button type="button" class="btn btn_play" id="playButton${i}"><img src="/img/ic_play.png" /></button>`;
                    const pauseButton = `<button type="button" class="btn btn_pause" id="pauseButton${i}"><img src="/img/ic_pause.png" /></button>`;
                    const downloadButton = `<a href="${link}" class="btn btn_dl"><img src="/img/ic_download.svg"></a>`;

                    const resData2 = data?.data?.body?.pictures;
                    const src = resData2?.sizes[5]?.link;
                    document.querySelectorAll('.video_area > img').forEach((elem) => {
                        elem.src = src;
                    })

                    document.querySelectorAll('.video_download').forEach((elem) => {
                        elem.innerHTML += `<a href="${link}" class="btn btn_dl thumbnail_download"><img src="/img/ic_download.svg"></a>`;
                    })

                    document.querySelectorAll('.thumbnail_download').forEach((elem) => {
                        elem.addEventListener('click', (e) => {
                            e.stopPropagation();
                        })
                    })

                    $(`.video_area#vimeo${i}`).find('img').hide();
                    $(`.video_area#vimeo${i}`).append(playButton + pauseButton + downloadButton);

                    player.loadVideo(num).then(function () {
                        document.querySelector('iframe').width = '100%';
                        document.querySelector('iframe').height = '100%';

                        document.querySelector('.loading_img').style.display = 'none';
                        document.querySelector('.video_none').style.display = 'block';
                    })

                    $(document).on('click','#playButton'+i,function (){
                        let $this = $(this)
                        player.play().then(function (){
                            $this.addClass('plaing');
                            $this.hide();
                            document.getElementById('pauseButton'+i).style.opacity = '0';
                        });
                    });

                    $(document).on('click','#pauseButton'+i,function (){
                        player.pause().then(function (){
                        });
                    });
                });
            }
        }
    }
}

// 알럿창 (나타났다가 사라짐)
function alertShow(num, text) {
    const target = $(`.alert_wrap.alert${num}`);
    target.find("#alertText").text(text);
    target.addClass("active");
    if (target.hasClass("active")) {
        setTimeout(() => {
            target.removeClass("active");
        }, 2000);
    }
}


var common = (function() {
    // 출석부 관리 캘린더, 이전 달
    $(document).on('click', 'button.calPrev', function(e){
        const ymText = e.currentTarget.dataset.date;
        let year = month = '';
        if (ymText != '') {
            const ymArr = ymText.split("-");
            year = Number(ymArr[0]) ?? 0;
            month = Number(ymArr[1]) ?? 0;
        }

        if(month == 1) {
            year -= 1;
            month = 12;
        } else {
            month -= 1;
        }

        calendarChange(`${year}-${month}`);
    });
    // 출석부 관리 캘린더, 다음 달
    $(document).on('click', 'button.calNext', function(e){
        const ymText = e.currentTarget.dataset.date;
        let year = month = '';
        if (ymText != '') {
            const ymArr = ymText.split("-");
            year = Number(ymArr[0]) ?? 0;
            month = Number(ymArr[1]) ?? 0;
        }

        if(month == 12) {
            year += 1;
            month = 1;
        } else {
            month += 1;
        }

        calendarChange(`${year}-${month}`);
    });
})();

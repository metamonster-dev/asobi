@extends('layout.home')
@section('bodyAttr')
class="body"
@endsection
@section('contents')
<?php
$title = "알림장 상세";
$hd_bg = "1";
$date = substr($row['date2'],0,7);

$test = '/advice?ym='.$date.'&search_user_id='.$row['student'].'&search_text='.$row['student_name'];
?>
@php
    $date = substr($row['date2'],0,7);
    if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='s') {
        $back_link = '/advice/list?ym='.$date;
    } else {
        $back_link = '/advice?ym='.$date.'&search_user_id='.$row['student'].'&search_text='.$row['student_name'];
    }
@endphp
@include('common.headm03')

<article class="sub_pg">
    <div class="container pt-4 pt_lg_50">
        <div class="d-none d-lg-block">
            @include('common.tabs')
        </div>

        <div class="pb-4 mb-3 mb-lg-0 border-bottom d-flex align-items-center justify-content-between">
            <div class="d-flex flex-column">
                <h4 class="tit_h4 mb-3 mb-lg-0 mt-0 mt-lg-3 line1_text line_h1 order-0 order-lg-1">{{ $row['title'] ?? '' }}</h4>
                <div class="d-flex align-items-center text-dark_gray fs_14 fw_300">
                    <p>{{ $row['date'] ?? '' }}</p>
                    <!-- <p class="d-block d-lg-none">{{ $row['date'] ?? '' }}</p>
                    <p class="d-none d-lg-block">{{ $row['date2'] ?? '' }}</p> -->
                </div>
            </div>
            @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='m')
            <!-- ※ 공유, 수정, 삭제 버튼은 교육원일 때만 노출 -->
            <button class="btn p-0 d-none d-lg-block" onclick="UrlCopy()"><img src="/img/ic_share.png"></button>
            <div class="position-relative d-block d-lg-none">
                <button type="button" class="btn p-0 btn_more h-auto"><img src="/img/ic_more.png" style="width: 1.6rem;"></button>

                <ul class="more_cont">
                    <li><button class="btn" onclick="UrlCopy()">공유</button></li>
                    <li><button class="btn" onclick="location.href='/advice/note/write/{{ $id }}'">수정</button></li>
                    <li><button class="btn" onclick="jalert2('삭제하시겠습니까?','삭제하기',function(){location.href='/advice/delete/{{ $id }}';})">삭제</button></li>
                </ul>
            </div>
            @endif
        </div>
        <div class="pt-3 pt-lg-5 px-0 px-lg-5">
            @if(isset($row['file']) && is_array($row['file']) && count($row['file']) > 0)
            <div class="mb-4">
                <ul class="grid03_list">
                    @php $k = 0; $j=0; @endphp
                    @foreach($row['file'] as $l)
                    <li>
                        <div class="att_img">
                            @if(isset($l['file_path']) && $l['file_path'])
                            <a href="javascript:;" onclick="bigImgShow('{{ $l['file_path'] }}', '{{ $j }}')">
                                <div class="area_img rounded overflow-hidden">
                                    <img src="{{ $l['file_path'] }}" class="w-100">
                                </div>
                            </a>
                            <a onclick="javascript:ycommon.downloadImage(os,'/advice/downloadFile/{{ $l['file_id'] }}','{{ $l['file_path'] }}');" class="btn btn_dl" target="_blank"><img src="/img/ic_download.svg"></a>
                                @php $j++; @endphp
                            @elseif(isset($l['vimeo_id']) && $l['vimeo_id'])
                            <div class="area video_area" id="vimeo{{ $k }}" data-vimeo="{{ $l['vimeo_id'] }}">
                                <img src="/img/loading.gif">
                            </div>
                                @php $k = $k + 1; @endphp
                            @else
                            <div class="area">
                                <i class="no_img"></i>
                            </div>
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
            <p class="wh_pre fs_15 line_h1_4">{!! nl2br($row['content']) !!}</p>
        </div>
        <!-- ※ 수정, 삭제 버튼은 교육원일 때만 노출 -->
        <div class="botton_btns d-none d-lg-flex pt_80 pb-4">
            @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='m')
            <button type="button" class="btn btn-primary" onclick="location.href='/advice/note/write/{{ $id }}'">수정</button>
            <button type="button" class="btn btn-gray text-white" onclick="location.href='@if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='s') /advice/list @else {{ $back_link }} @endif'">목록</button>
            <button type="button" class="btn btn-gray text-white" onclick="jalert2('삭제하시겠습니까?','삭제하기',function(){location.href='/advice/delete/{{ $id }}';})">삭제</button>록
            @else
            <button type="button" class="btn btn-gray text-white" onclick="location.href='@if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='s') /advice/list @else {{ $back_link }} @endif'">목록</button>
            @endif
        </div>
        <hr class="line mt-5 mb-3">
        <div class="pt-3">
            <div class="pb-0 pb-lg-4 px-0 px-lg-3 mx-0 mx-lg-3">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center">
                        <img src="/img/ic_comment.png" style="width: 2.5rem;">
                        <p class="text-primary fs_18 ml-2">댓글</p>
                    </div>
                    @if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='m')
                    <!-- ※ 읽음여부는 교육원일 때만 노출 -->
                    <div class="note_read">
                        <p class="text-dark_gray fs_14 fw_300">
                            읽음여부
                            <span class="ml-3">
                                @if(isset($row['readed']) && $row['readed'] == 'Y')
                                O
                                @else
                                X
                                @endif
                            </span>
                        </p>
                    </div>
                    @endif
                </div>
                <form action="" class="cmt_wr">
                    <div class="cmt_wr_box">
                        <textarea name="" id="comment" cols="30" rows="10" placeholder="댓글을 입력해주세요." class="form-control"></textarea>
                        <button type="button" class="btn btn-sm btn-primary wr_btn" onclick="Comment()">등록</button>
                    </div>
                </form>
            </div>
            <!-- 댓글 없을 때 -->
            <!-- <hr class="line2 mb-0"></hr>
            <div class="py-3 border-bottom">
                <div class="py-5">
                    <p class="fs_14 text-gray line_h1_4 text-break">등록된 댓글이 없습니다.</p>
                </div>
            </div> -->
            <!-- 댓글 있을 때 1묶음 -->
            <div id="commetHtml"></div>
        </div>
    </div>
</article>

<!-- 원본 이미지 보기 -->
<div class="modal_bg" id="bigImgModal">
    <div class="modal_wrap md_big_img">
        <div class="img_box">
            <img src="/img/img_icon.png">
        </div>
    </div>
</div>

<script>
    $(window).on("load", function() {
        getVimeoVideo();
    });

    var file_lists = [];
    @if(isset($row['file']) && is_array($row['file']) && count($row['file']) > 0)
        @foreach($row['file'] as $l)
            @if(isset($l['file_path']) && $l['file_path'])
    file_lists.push(encodeURIComponent('{!! $l['file_path'] !!}'));
            @endif
        @endforeach
    @endif

    // 원본 이미지 보기
    function bigImgShow(imgSrc, k) {
        if (os == 'web') {
            let winW = $(window).width();
            if (winW > 767 && imgSrc) {
                $("#bigImgModal").find("img").attr("src", imgSrc);
                $("#bigImgModal").addClass("show");
                $("body").addClass("overflow-hidden");
            }
        } else {
            window.webViewBridge.send('bigImgShow', {files:file_lists, idx: k}, function(res) {
                // console.log(res);
            }, function(err) {
                // console.error(err);
            });
        }
    }

    function UrlCopy(){
        var url = window.location.href;
        const id = {{ $id }};
        if (typeof window.ReactNativeWebView !== 'undefined') {
            window.ReactNativeWebView.postMessage(
                JSON.stringify({targetFunc: "copy",url: url})
            );
        }else {
            var tempInput = $('<input>');
            tempInput.css({
                position: 'absolute',
                left: '-9999px', // 화면 영역 밖으로 이동
            });
            $('body').append(tempInput);
            let action = `/api/share?link=${url}&id=${id}`;
            let data = '';

            ycommon.ajaxJson('get', action, data, undefined, function (res) {
                tempInput.val(res.shortLink).select();
                const copy = document.execCommand('copy');
                tempInput.remove();
                if (copy) {
                    alert("클립보드 복사되었습니다.");
                } else {
                    alert("이 브라우저는 지원하지 않습니다.");
                }
            })
        }
    }

//댓글 리스트
function CommentList() {
let action = `/api/adviceNote/comment/list?user=${userId}&id={{$id}}`;
let data = '';
ycommon.ajaxJson('get', action, data, undefined, function (res) {
    let data = res.list;
    console.log(res);
    // console.log(data);

    let commentListHtml = '';
    let replyListHtml = '';

    data?.map(e => {
        let commentHtml = '';
        if (!e.pid) {
            commentHtml = `
                    <hr class="line2 mb-3" />
                    <div class="py-3">
                        <div class="d-flex align-items-center justify-content-between cmt_tit">
                            <div class="d-flex align-items-center justify-content-start cmt_name">
                                <div class="rect rounded-circle mr-3">
                                    <img src="${e.writer_picture !== null ? e.writer_picture : '/img/profile_default.png'}">
                                </div>
                                <div>
                                    <p class="line1_text fw_600 fs_15">${e.writer}</p>
                                    <p class="fs_14 fw_300 text-light pt-2 d-none d-lg-block">${e.date}</p>
                                </div>
                            </div>
                            ${e.comment !== '댓글이 삭제되었습니다.' && e.writer_id == {{session('auth')['user_id']}} ? `
                            <div class="position-relative">
                                <button type="button" class="btn p-0 btn_more h-auto" onclick="btn_more(event, ${e.id})"><img src="/img/ic_more2.png" style="width: 1.6rem;"></button>
                                <ul id="more_cont${e.id}" class="more_cont">
                                    <li><button class="btn" onclick="btn_update(${e.id})">수정</button></li>
                                    <li><button class="btn" onclick="btn_delete(${e.id})">삭제</button></li>
                                </ul>
                            </div>
                            ` : ''}
                        </div>
                        <p class="fs_14 line_h1_4 py-3 text-break" id="comment_wr${e.id}">${e.comment}</p>
                        <div class="c_commentList d-flex align-items-center justify-content-between justify-content-lg-end pb-3">
                            <p class="fs_14 fw_300 text-light d-block d-lg-none">${e.date}</p>
                            ${e.comment !== '댓글이 삭제되었습니다.' ? `
                            <button type="button" class="btn btn_reply" onclick="reCommentInput(${e.id}, '${e.writer}')"><img src="/img/ic_comment2.png" style="width: 1.4rem;" class="mr-2">답글</button>
                            ` : ''}
                        </div>
                        <div id="update_wr${e.id}" class="recmt_wr update_wr"></div>
                        <div id="recmt_wr${e.id}" class="recmt_wr comment_wr"></div>
                        <div id="replyHtml${e.pid}"></div>
                    </div>
                `;
        }else {
            commentHtml = `<div class="bg-light_gray reply_wr mt-3 py-3">
                    <div class="d-flex align-items-start justify-content-start container-fluid pt-3">
                        <img src="/img/ic_reply.png" style="width: 2rem;">
                        <div class="w-100 ml-3">
                            <div class="d-flex align-items-center justify-content-between cmt_tit">
                                <div class="d-flex align-items-center justify-content-start cmt_name">
                                    <div class="rect rounded-circle mr-3">
                                        <img src="${e.writer_picture !== null ? e.writer_picture : '/img/profile_default.png'}">
                                    </div>
                                    <div>
                                        <p class="line1_text fw_600 fs_15">${e.writer}</p>
                                        <p class="fs_14 fw_300 text-light pt-2 d-none d-lg-block">${e.date}</p>
                                    </div>
                                </div>
                                ${e.comment !== '댓글이 삭제되었습니다.'  && e.writer_id == {{session('auth')['user_id']}} ? `
                                <div class="position-relative">
                                    <button type="button" class="btn p-0 btn_more h-auto" onclick="btn_more(event, ${e.id})"><img src="/img/ic_more2.png" style="width: 1.6rem;"></button>
                                    <ul id="more_cont${e.id}" class="more_cont">
                                        <li><button class="btn" onclick="btn_update(${e.id})">수정</button></li>
                                        <li><button class="btn" onclick="btn_delete(${e.id})">삭제</button></li>
                                    </ul>
                                </div>
                                ` : ''}
                            </div>
                            <p class="fs_14 line_h1_4 py-3 text-break" id="comment_wr${e.id}">${e.comment}</p>
                            <div class="pb-3 d-block d-lg-none">
                                <p class="fs_14 fw_300 text-light">${e.date}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="update_wr${e.id}" class="recmt_wr update_wr mt-3"></div>`;

            $(`#recmt_wr${e.pid}`).html(commentHtml);
        }
        commentListHtml += commentHtml;
    });
    $('#commetHtml').html(commentListHtml);
});
}

//댓글 작성
function Comment() {
let comment = $('#comment').val();
if(comment === ''){
    return false;
}
let action = `/api/adviceNote/comment/write`;
let data = {user: userId ,id: {{$id}}, comment: comment};
ycommon.ajaxJson('post', action, data, undefined, function (res) {
    $('#comment').val('');
    CommentList();
});
}

//대댓글 작성 폼 호출
function reCommentInput(id, writer) {
const inputHtml = `
        <div class="cmt_wr">
            <div class="cmt_wr_info">
                <p class="text-dark_gray"><span class="text-text2">${writer}</span>님에게 답글 쓰기</p>
                <button type="button" class="btn" onclick="hideInputComment()"><img src="/img/ic_x.png"/></button>
            </div>
            <div class="cmt_wr_box">
                <textarea name="" id="recomment" cols="30" rows="10" placeholder="답글을 입력해주세요." class="form-control"></textarea>
                <button type="button" class="btn btn-sm btn-primary wr_btn" onclick="reComment(${id})">등록</button>
            </div>
        </div>
    `;
$('.comment_wr').html('');
$('.update_wr').html('');
$('#recmt_wr'+id).html(inputHtml);
}

//대댓글 작성
function reComment(id) {
let comment = $('#recomment').val();
if(comment === ''){
    return false;
}
let action = `/api/adviceNote/comment/write`;
let data = {user: userId ,id: {{$id}}, comment: comment, pid: id};
ycommon.ajaxJson('post', action, data, undefined, function (res) {
    // console.log(res);
    CommentList();
});
}

//더보기 버튼
function btn_more(event,id) {
event.stopPropagation();
$('.more_cont').removeClass('on');
$('.more_cont').slideUp();
if ($(`#more_cont${id}`).hasClass('on')) {
    event.stopPropagation();
} else {
    $(`#more_cont${id}`).removeClass('on');
    $(`#more_cont${id}`).slideUp();
}
$(`#more_cont${id}`).slideToggle();
$(`#more_cont${id}`).addClass('on');
}

$('.more_cont .btn').on('click', function (e) {
e.preventDefault();
});

//댓글 수정 버튼
function btn_update (id){
let comment = $(`#comment_wr${id}`).text();

const inputHtml = `
        <div class="cmt_wr">
            <div class="cmt_wr_info">
                <p class="text-dark_gray">내 댓글 수정하기</p>
                <button type="button" class="btn" onclick="hideInputComment()"><img src="/img/ic_x.png"/></button>
            </div>
            <div class="cmt_wr_box">
                <textarea name="" id="update_comment${id}" cols="30" rows="10" placeholder="댓글을 입력해주세요." class="form-control">${comment}</textarea>
                <button type="button" class="btn btn-sm btn-primary wr_btn" onclick="updateComment(${id})">수정</button>
            </div>
        </div>
    `;
$('.update_wr').html('');
$('.comment_wr').html('');
$('#update_wr'+id).html(inputHtml);
}

//댓글 수정
function updateComment (id){
let comment = $(`#update_comment${id}`).val();
let action = `/api/adviceNote/comment/write/${id}`;
let data = {user: userId , comment: comment};
ycommon.ajaxJson('post', action, data, undefined, function (res) {
    CommentList();
});
}
//댓글 삭제
function btn_delete (id){
let action = `/api/adviceNote/comment/delete/${id}`;
let data = {user: userId};
ycommon.ajaxJson('post', action, data, undefined, function (res) {
    CommentList();
});
}
function hideInputComment() {
$('.update_wr').html('');
$('.comment_wr').html('');
}
//초기 댓글 리스트 출력
$(window).on("load", function () {
CommentList();
});

document.addEventListener('message', (event) => {
const data = JSON.parse(event.data);
if(data.msg) {
    jalert(data.name, data.msg);
}
});

window.addEventListener('message', (event) => {
    if (event.origin !== undefined && event.origin == "https://player.vimeo.com") {
        return false;
    }
    const data = JSON.parse(event.data);
    if(data.msg) {
        jalert(data.name, data.msg);
    }
});
</script>

@endsection

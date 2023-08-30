@extends('layout.home')
@section('bodyAttr')
class="body"
@endsection
@section('contents')
<?php
$title = "앨범 상세";
$hd_bg = "2";

$date = substr($row['reg_date'],0,7);
$back_link = '/album?ym='.$date;
// $back_link = '/album';
?>
@include('common.headm03')

<article class="sub_pg">
    <div class="container pt-4 pt_lg_50">
        <div class="d-none d-lg-block">
            @include('common.tabs')
        </div>

        <div class="pb-4 mb-3 mb-lg-0 border-bottom d-flex align-items-center justify-content-between">
            <div class="d-flex flex-column">
                <h4 class="tit_h4 mt-3 line1_text line_h1 order-1">{{ $row['title'] }}</h4>
                <div class="d-flex align-items-center text-dark_gray fs_14 fw_300">
                    <p>{{ $row['date'] }}</p>
                </div>
            </div>
            @if(isset(session('auth')['user_type']) && (session('auth')['user_type'] =='m' || session('auth')['user_type'] =='a'))
            <!-- ※ 수정, 삭제 버튼은 교육원, 본사일 때 노출 -->
            <div class="position-relative d-block d-lg-none">
                <button type="button" class="btn p-0 btn_more h-auto"><img src="/img/ic_more.png" style="width: 1.6rem;"></button>
                <ul class="more_cont">
                    <li><button class="btn" onclick="location.href='/album/write/{{ $id }}'">수정</button></li>
                    <li><button class="btn" onclick="jalert2('삭제하시겠습니까?','삭제하기',function(){location.href='/album/delete/{{ $id }}';})">삭제</button></li>
                </ul>
            </div>
            @endif
        </div>
        <div class="pt-3 pt-lg-5 px-0 px-lg-5">
            <div class="mb-5">
                <ul class="grid03_list">
                @if(isset($row['file']) && is_array($row['file']) && count($row['file']) > 0)
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
                            <a onclick="javascript:ycommon.downloadImage(os,'/album/downloadFile/{{ $l['file_id'] }}','{{ $l['file_path'] }}');" class="btn btn_dl"><img src="/img/ic_download.svg"></a>
                                @php $j++; @endphp
                            @elseif(isset($l['video_id']) && $l['video_id'])
                            <div class="area video_area" id="vimeo{{ $k }}" data-vimeo="{{ $l['video_id'] }}">
                                <img src="/img/loading.gif" class="loading_img">
{{--                                <iframe src="https://player.vimeo.com/video/{{ $l['video_id'] }}?title=0&byline=0&portrait=0&controls=0" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen="" title="Untitled" data-ready="true"></iframe>--}}
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
                @else
                    <!-- <li>
                        <div class="att_img">
                            <div class="area">
                                <i class="no_img"></i>
                            </div>
                        </div>
                    </li> -->
                @endif
                </ul>
            </div>
            @if(isset(session('auth')['user_type']) && session('auth')['user_type'] !=='s')
            <!-- ※ 읽은 사람 확인은 학부모일 때 미노출 -->
            <div class="grid01_list mt-5">
                <div class="bg-light_gray p-3 rounded-lg">
                    <p class="m-3 fs_14">읽지 않은 사람 ({{ count($studentReadN) }}명)</p>
                    @if(count($studentReadN) > 0)
                    <div class="m-2 fs_14">
                        @foreach($studentReadN as $k => $l)
                        <span class="d-inline-block m-2">{{ $l['name'] }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="bg-light_gray p-3 rounded-lg">
                    <p class="m-3 fs_14">읽은 사람 ({{ count($studentReadY) }}명)</p>
                    @if(count($studentReadY) > 0)
                    <div class="m-2 fs_14">
                        @foreach($studentReadY as $k => $l)
                        <span class="d-inline-block m-2">{{ $l['name'] }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
        <!-- ※ 수정, 삭제 버튼은 교육원, 본사일 때 노출 -->
        <div class="botton_btns d-none d-lg-flex pt_80 pb-4">
            @if(isset(session('auth')['user_type']) && (session('auth')['user_type'] =='m' || session('auth')['user_type'] =='a'))
            <button type="button" class="btn btn-primary" onclick="location.href='/album/write/{{ $id }}'">수정</button>
            <button type="button" class="btn btn-gray text-white" onclick="location.href='/album'">목록</button>
            <button type="button" class="btn btn-gray text-white" onclick="jalert2('삭제하시겠습니까?','삭제하기',function(){location.href='/album/delete/{{ $id }}';})">삭제</button>
            @else
            <button type="button" class="btn btn-gray text-white" onclick="location.href='/album'">목록</button>
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
                </div>
                <form action="" class="cmt_wr">
                    <div class="cmt_wr_box">
                        <textarea name="" id="comment" cols="30" rows="10" placeholder="댓글을 입력해주세요." class="form-control"></textarea>
                        <button type="button" class="btn btn-sm btn-primary wr_btn" onclick="Comment()">등록</button>
                    </div>
                </form>
            </div>
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

    function test(e) {


        if (typeof window.ReactNativeWebView !== 'undefined') {
            window.ReactNativeWebView.postMessage(
                JSON.stringify({targetFunc: "download_image",imageUrl: 'https://asobi-new-app.s3.ap-northeast-2.amazonaws.com/app/album/3f02324c-214f-4005-bc6d-19c0e373b761.jpg?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAXCTJUW3GJJDYLC5Q%2F20230602%2Fap-northeast-2%2Fs3%2Faws4_request&X-Amz-Date=20230602T025009Z&X-Amz-SignedHeaders=host&X-Amz-Expires=10800&X-Amz-Signature=07298d61016c7d77af6852d1889bc07097d4b894e30bbf4946c5a1fdb03e3e6d'})
            );
        }
        // location.href='/album/downloadFile/'+e;
        // console.log('1',e);

        // if (typeof window.ReactNativeWebView !== 'undefined') {
        //     window.ReactNativeWebView.postMessage(
        //         JSON.stringify({targetFunc: "download_image",imageUrl: 'https://asobi-new-app.s3.ap-northeast-2.amazonaws.com/app/album/3f02324c-214f-4005-bc6d-19c0e373b761.jpg?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAXCTJUW3GJJDYLC5Q%2F20230602%2Fap-northeast-2%2Fs3%2Faws4_request&X-Amz-Date=20230602T025009Z&X-Amz-SignedHeaders=host&X-Amz-Expires=10800&X-Amz-Signature=07298d61016c7d77af6852d1889bc07097d4b894e30bbf4946c5a1fdb03e3e6d'})
        //     );
        // }
        location.href='/album/downloadFile/'+e;
        console.log('1',e);

    }

    //댓글 리스트
    function CommentList() {
        let action = `/api/album/comment/list?user=${userId}&id={{$id}}`;
        let data = '';
        ycommon.ajaxJson('get', action, data, undefined, function (res) {
            let data = res.list;
            // console.log(res);
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
        let action = `/api/album/comment/write`;
        let data = {user: userId , id: {{$id}}, comment: comment};
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
        let action = `/api/album/comment/write`;
        let data = {user: userId , id: {{$id}}, comment: comment, pid: id};
        ycommon.ajaxJson('post', action, data, undefined, function (res) {
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
        let action = `/api/album/comment/write/${id}`;
        console.log(userId, {{ $id }}, comment);
        let data = {user: userId , id: {{$id}}, comment: comment};
        ycommon.ajaxJson('post', action, data, undefined, function (res) {
            CommentList();
        });
    }
    //댓글 삭제
    function btn_delete (id){
        let action = `/api/album/comment/delete/${id}`;
        let data = {user: userId, id: {{$id}}};
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

@extends('layout.home')
@section('bodyAttr')
class="body"
@endsection
@section('contents')
<?php
// $title = "공지사항 상세";
$hd_bg = "3";
//$back_link = '/notice';
?>
@php
    if(isset(session('auth')['user_type']) && session('auth')['user_type'] =='s') $title = "공지사항 상세";
    else $title = "회원 공지 상세";
@endphp
@include('common.headm03')

<article class="sub_pg">
    <div class="container pt-4 pt_lg_50">
        <div class="d-none d-lg-block">
            @include('common.tabs')
        </div>

        <div class="pb-4 mb-3 mb-lg-0 border-bottom d-flex align-items-center justify-content-between">
            <div class="w-100">
                <div class="text-dark_gray fs_13 fw_300 mb-2 line_h1_2 d-flex justify-content-between">
                    <div><span class="d-inline-block d-lg-none text-primary fw_500">[{{ $row['type'] }}공지]</span> {{ $row['date'] }}</div>
                    @if(isset(session('auth')['user_type']) && session('auth')['user_type'] == 'a')
                        <div class="fs_12 fw_300 text-light mr-3" style="text-align: right">전체 조회수: {{ number_format($getAllCountBoardView) }} / 순 조회수: {{ number_format($getFilterCountBoardView) }}</div>
                    @endif
                </div>
                <h4 class="tit_h4 line1_text line_h1">
                    <span class="d-none d-lg-inline-block text-primary mr-2">[{{ $row['type'] }}공지]</span> {{ $row['title'] }}
                </h4>
            </div>

            @if(isset(session('auth')['user_type']) && (in_array(session('auth')['user_type'], ['m', 'h', 'a'])))
                <button class="btn p-0 d-none d-lg-block" onclick="UrlCopy()"><img src="/img/ic_share.png"></button>
            <!--  ※ 수정, 삭제 버튼은 교육원, 본사일 때 노출 -->
            <div class="position-relative d-block d-lg-none">
                <button type="button" class="btn p-0 btn_more h-auto"><img src="/img/ic_more.png" style="width: 1.6rem;"></button>

                <ul class="more_cont">
                    <li><button class="btn" onclick="UrlCopy()">공유</button></li>
                    @if($modifyBtn)
                    <li><button class="btn" onclick="location.href='/notice/write/{{ $id }}'">수정</button></li>
                    @endif
                    @if($deleteBtn)
                    <li><button class="btn" onclick="jalert2('삭제하시겠습니까?','삭제하기',function(){location.href='/notice/delete/{{ $id }}';})">삭제</button></li>
                    @endif
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
                            <a onclick="javascript:ycommon.downloadImage(os,'/notice/downloadFile/{{ $l['file_id'] }}','{{ $l['file_path'] }}');" download="" class="btn btn_dl"><img src="/img/ic_download.svg"></a>
                                @php $j++; @endphp
                            @elseif(isset($l['video_id']) && $l['video_id'])
                            <div class="area video_area" id="vimeo{{ $k }}" data-vimeo="{{ $l['video_id'] }}">
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

            <div id="content" class="editor_wrap fs_15">{!! $row['content'] !!}</div>

            @if(isset(session('auth')['user_type']) && session('auth')['user_type'] !=='s')
            <!-- ※ 읽은 사람 확인은 학부모일 때 미노출 -->
            <div class="bg-light_gray p-3 rounded-lg mt-5">
                <p class="m-3 fs_14">읽지 않은 사람 ({{ count($studentReadN) }}명)</p>
                @if(count($studentReadN) > 0)
                <div class="m-2 fs_14">
                    @foreach($studentReadN as $k => $l)
                    <span class="d-inline-block m-2">{{ $l['name'] }}</span>
                    @endforeach
                </div>
                @endif
            </div>
            <div class="bg-light_gray p-3 rounded-lg mt-4">
                <p class="m-3 fs_14">읽은 사람 ({{ count($studentReadY) }}명)</p>
                @if(count($studentReadY) > 0)
                <div class="m-2 fs_14">
                    @foreach($studentReadY as $k => $l)
                    <span class="d-inline-block m-2">{{ $l['name'] }}</span>
                    @endforeach
                </div>
                @endif
            </div>
            @endif
        </div>

        <!--  ※ 수정, 삭제 버튼은 교육원, 본사일 때 노출 -->
        <div class="botton_btns d-none d-lg-flex pt_80">
            @if(isset(session('auth')['user_type']) && (session('auth')['user_type'] =='m' || session('auth')['user_type'] =='a'))
                @if($modifyBtn)
                <button type="button" class="btn btn-primary" onclick="location.href='/notice/write/{{ $id }}'">수정</button>
                @endif
                <button type="button" class="btn btn-gray text-white" onclick="location.href='{{ $back_link }}'">목록</button>
                @if($deleteBtn)
                <button type="button" class="btn btn-gray text-white" onclick="jalert2('삭제하시겠습니까?','삭제하기',function(){location.href='/notice/delete/{{ $id }}';})">삭제</button>
                @endif
            @else
            <button type="button" class="btn btn-gray text-white" onclick="location.href='{{ $back_link }}'">목록</button>
            @endif
        </div>
    </div>
</article>

<div class="loading_wrap" id="loading" style="display: none">
    <div class="loading_text">
        <i class="loading_circle"></i>
        <span>로딩중</span>
    </div>
</div>

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
        const data = JSON.stringify(event.data);
        if(data.msg) {
            jalert(data.name, data.msg);
        }
    });

    document.querySelectorAll('[onclick*="location.href"]').forEach(function(element) {
        element.addEventListener('click', function(event) {
            $('#loading').show();
        });
    });

    // content 안에 링크 자동으로 a태그 만들어주기
    const content = document.getElementById('content').innerHTML;

    // const contentWithLinks = content.replace(/(http[s]?:\/\/[^\s]+)/g, '<a href="$1" target="_blank">$1</a>');

    const contentWithLinks = content.replace(
        /<a\s+(?:[^>]*?\s+)?href\s*=\s*(['"])(.*?)\1[^>]*>.*?<\/a>|((?<=^|>)[^<]*?(http[s]?:\/\/\S+)[^<]*?(?=<|$))/gi,
        (match, p1, p2, p3, p4) => {
            // 이미 <a> 태그로 감싸져 있는지 확인
            if (p1) {
                // 이미 <a> 태그로 감싸져 있는 경우 변환하지 않고 원래의 링크를 유지
                return match;
            } else {
                // <a> 태그로 감싸지 않은 경우 링크를 <a> 태그로 변환
                const linkText = p3.replace(/http\S+/, ''); // "http" 이후의 문자열 제거

                return `${linkText} <a href="${p4}" target="_blank">${p4}</a>`;
            }
        }
    );

    document.getElementById('content').innerHTML = contentWithLinks;

    function UrlCopy(){
        var url = window.location.href;
        const id = {{ $id }};
        if (typeof window.ReactNativeWebView !== 'undefined') {
            window.ReactNativeWebView.postMessage(
                JSON.stringify({targetFunc: "copy",url: url})
            );

            let action = `/api/share?link=${url}&id=${id}`;
            let data = '';

            ycommon.ajaxJson('get', action, data, undefined, function (res) {
            })

        } else {
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
</script>

@endsection

@extends('layout.home')
@section('bodyAttr')
class="body"
@endsection
@section('contents')
<?php
$title = "상담일지 작성";
$hd_bg = "7";
?>
@include('common.headm02')

<article class="sub_pg">
    <div class="container pt-4 pt_lg_50">
        <div class="d-none d-lg-block">
            @include('common.tabs')
        </div>
        <h1 class="tit_h1 ff_lotte fw_500 d-none d-lg-block mb-4 mb-lg-5">
            <?=$title?>
            <img src="/img/ic_tit.png" class="tit_img">
        </h1>

        <form action="/counsel/writeAction" id="frm" name="frm" method="POST" onsubmit="return frm_form_chk(this);" enctype="multipart/form-data" class="mt-3">
            <input type="hidden" name="mode" value="{{ $mode }}">
            <input type="hidden" name="id" value="{{ $id }}">
            <input type="hidden" name="ymd" value="{{ $ymd }}">
            <div class="grid02_list">
                <div class="ip_wr">
                    <div class="ip_tit d-flex align-items-center justify-content-between">
                        <h5>학생 선택</h5>
                    </div>
                    <div class="position-relative m_select_wrap">
                        <div class="input_wrap">
                            <input type="hidden" name="search_user_id" value="{{ $mode === 'w' ? $search_user_id ?? '' : $row['sidx'] ?? '' }}" >
                            <input type="text" name="search_text" id="search_text" @if($mode == "u") disabled="disabled" @endif value="{{ $row['name'] ?? '' }}" class="form-control bg-white custom-select m_select" autocomplete="off" placeholder="전체">
                            <button class="m_delete" type="button"><img src="/img/ic_delete_sm.png"></button>
                        </div>
                        <ul id="searchList" class="m_select_list none_scroll_bar"></ul>
                    </div>
{{--                    <select name="student" id="student" class="form-control custom-select" >--}}
{{--                        <option selected hidden>선택해주세요.</option>--}}
{{--                    </select>--}}
                </div>

                <div class="ip_wr">
                    <div class="ip_tit d-flex align-items-center justify-content-between">
                        <h5>작성일자</h5>
                    </div>
                    <input type="date" name="date" value="{{ $ymd }}" max="<?php echo date("Y-m-d") ?>" class="form-control text-dark_gray" {{ isset($row['date']) && $row['date'] != '' ? 'disabled' : '' }}>
                </div>
            </div>
            <div class="ip_wr mt-4">
                <div class="ip_tit d-flex align-items-center justify-content-between">
                    <h5>내용</h5>
                    <button type="button" class="btn p-0 h-auto" onclick="boardCopy('content')"><img src="/img/ic_copy.png" style="width: 2rem;"></button>
                </div>
                <textarea id="content" class="form-control" name="content" placeholder="내용을 입력해주세요" rows="5">{{$row['content'] ?? ''}}</textarea>
            </div>

            <div class="cmt_wr note_btns pt-0 pt_lg_50 pb-0 pb-lg-4">
                <button type="submit" class="btn btn-primary">전송</button>
                <button type="button" class="btn btn-gray text-white" onclick="location.href='/counsel'">목록</button>
            </div>
        </form>
    </div>
</article>

<script>
    function frm_form_chk(f) {
        const currentDate = new Date();
        const ymdValue = new Date(f.date.value);

        if (f.search_user_id.value == "undefined") {
            jalert("학생을 선택해주세요.");
            return false;
        }

        if (f.date.value == "") {
            jalert("작성일자를 입력해주세요.");
            return false;
        }

        //if (ymdValue > currentDate) {
        //    jalert('미래 날짜는 선택할 수 없습니다.');
        //    return false;
        //}

        if(f.content.value =="") {
            jalert("내용을 입력해주세요.");
            // oEditor.focus();
            return false;
        }

        return true;
    }

    function StudentList(){
        let action = `/api/counseling/student/list?user=${userId}`;
        let data = '';
        ycommon.ajaxJson('get', action, data, undefined, function (res) {
            // console.log(res);
            let list = res.list;

            let data = list?.reduce(function(acc, item) {
                let found = acc.find(element => element.idx === item.id && element.name === item.name);

                if (!found) {
                    acc.push({idx: item.id, name: item.name});
                }

                return acc;
            }, []);

            // let data = list?.map(function(item) {
            //     return {idx: item.id,name: item.name};
            // });

            // console.log(data);

            // let data = '';
            // list?.map(e => {
            //     let option = '';
            //     option = `<option value="${e.id}">${e.name}</option>`;
            //     data += option;
            // });
            // $('#student').append(data);
            autoSearch(data, "searchList", "search_text", sClick, {!! $search_user_id !!}, xClick);
        });
    }

    function sClick(e) {
        @if($mode == "u")
            return false;
        @endif
        let s = $(e.target).data('idx');
        let f = $("#frm");
        f.find('input[name=search_user_id]').val(s);
        // f.submit();
    }
    function xClick(e) {
        @if($mode == "u")
            return false;
        @endif
        let f = $("#frm");
        f.find('input[name=search_user_id]').val("");
    }

    $(window).on("load", function () {
        StudentList();
    });
</script>
@endsection

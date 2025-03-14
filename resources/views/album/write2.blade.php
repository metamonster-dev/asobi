@extends('layout.home')
@section('bodyAttr')
class="body"
@endsection
@section('contents')
<?php
ini_set('memory_limit', '-1');
$title = "앨범 작성 (테스트 페이지)";
$hd_bg = "2";

$userAgent = $_SERVER['HTTP_USER_AGENT'];

$phpisIOS = false;
if (strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false || strpos($userAgent, 'iPod') !== false) {
    $phpisIOS = true;
} else {
    $phpisIOS = false;
}
$user = \App::make('helper')->getUsertId();

?>
@include('common.headm04')
@include('album.preview')

<article class="sub_pg">
    <div class="container pt-4 pt_lg_50">
        <div class="d-none d-lg-block">
            @include('common.tabs')
        </div>
        <div class="d-none d-lg-flex align-items-center justify-content-between mb-4 mb-lg-5">
            <h1 class="tit_h1 ff_lotte fw_500">
                <?=$title?>
                <img src="/img/ic_tit.png" class="tit_img">
            </h1>
            <div class="d-flex">
                @if($mode == 'w')
                <button type="button" class="btn btn-md border border-primary text-primary px-5 mr-3" onclick="jalert2('임시저장을 하시겠습니까?\n이미지와 동영상은 별도의 스토리지에 저장되며, 이미 저장된 이미지가 있을 수 있습니다.', '임시저장', tmpSave);">임시저장</button>
                @endif
                <button type="button" class="btn btn-md border border-primary text-primary px-5" onclick="getAlbumPreview()">미리보기</button>
            </div>
        </div>

        <form name="adviceForm" id="adviceForm" class="mt-3" method="POST" action="/album/writeAction" onsubmit="return frm_form_chk(this);" enctype="multipart/form-data">
            <input type="hidden" name="mode" value="{{ $mode }}">
            <input type="hidden" name="id" value="{{ $id }}">
            <input type="hidden" name="delete_ids" value="" />
            <input type="hidden" name="tmp_file_ids" value="" />

            <div class="grid02_list">
                <div class="ip_wr">
                    <div class="ip_tit d-flex align-items-center justify-content-between">
                        <h5>제목</h5>
                        <button type="button" class="btn p-0 h-auto" onclick="boardCopy('title')"><img src="/img/ic_copy.png" style="width: 2rem;"></button>
                    </div>
                    <input id="title" name="title" type="text" value="{{ $row['title'] ?? '' }}" class="form-control text-dark_gray" placeholder="제목을 입력해주세요">
                </div>
                <div class="ip_wr" @if ($mode=="u") style="display: none;" @endif>
                    <div class="ip_tit d-flex align-items-center justify-content-between">
                        <h5>작성일자</h5>
                    </div>
                    <input type="date" name="ymd" id="ymd" value="{{ $ymd }}" max="<?php echo date("Y-m-d") ?>" class="form-control text-dark_gray">
                </div>
            </div>
            <div class="form-group ip_wr mt-4 mt-lg-5 mb-0 mb-lg-4">
                <div class="ip_tit d-flex align-items-center">
                    <h5 class="mr-3">사진·동영상</h5>
                    <p class="fs_13 text-light"><span id="uploadCount">0</span>/10</p>
                </div>
                <div class="scroll_wrap none_scroll_bar_lg">
                    <input type="file" accept="image/*" multiple>
                    <br /><br /><br /><br />

                    <div class="input-group-prepend" id="imgUpload">

                        <div class="image-upload2 addBtn mr-3" >
                            <label for="upload_file">
                                <div class="upload-icon2">
                                    <button type="button" class="btn del"></button>
                                </div>
                            </label>
                        </div>


{{--                        <div class="image-upload2 mr-3" data-id="0" id="image-upload-0'">--}}
{{--                            <label id="label_upload_file_0" for="upload_file_0">--}}
{{--                                <div class="upload-icon2">--}}
{{--                                    <button type="button" class="btn del"></button>--}}
{{--                                </div>--}}
{{--                            </label>--}}
{{--                        </div>--}}

{{--                        <input id="upload_file_0" multiple="multiple" name="upload_files[]" class="upload_files" data-id="0" type="file" value="" accept="image/jpg,image/jpeg,video/mp4" />--}}

                    </div>
                </div>
            </div>

{{--            <div id="uploadWrap"></div>--}}

            <div class="d-flex align-items-center justify-content-between mt-3 pt-3 mb-4">
                <div class="ip_wr">
                    <div class="ip_tit mb-0">
                        <h5>학생선택</h5>
                    </div>
                </div>
                <div class="checks_wr">
                    <div class="checks mr-0">
                        <label>
                            <input type="checkbox" id="chkStudentAll">
                            <span class="ic_box"></span>
                            <div class="chk_p">
                                <p>전체선택</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <ul class="grid03_list note_stu_list_chk pb-3">
                @if(count($student) > 0)
                    @foreach($student as $l)
                        @php
                            $isChecked = '';
                            if($mode == 'u'){
                                $studentId = $l['id'];
                                $isChecked = false;
                                if (is_array($row['student'])) {
                                    $isChecked = in_array($studentId, array_column($row['student'], 'idx'));
                                }
                            }
                        @endphp
                        <li>
                            <label>
                                <input type="checkbox" name="student[]" value="{{ $l['id'] }}" class="chkStudent d-none"  {{ $isChecked ? 'checked' : '' }}>
                                <div class="chk_li">
                                    <div class="d-flex align-items-center">
                                        <div class="rect rounded-circle">
                                            <img src="{{ $l['profile_image'] ?? '/img/profile_default.png' }}">
                                        </div>
                                        <p class="fs_16 fw_700 ml-3">{{ $l['name'] }}</p>
                                    </div>
                                    <span class="ic_box"></span>
                                </div>
                            </label>
                        </li>
                    @endforeach
                @else
                    <!-- //학생없을때 표기해주세요. -->
                    <li>
                        <div class="nodata">
                            <p>조회된 학생이 없습니다.</p>
                        </div>
                    </li>
                @endif
            </ul>

            <div class="cmt_wr note_btns pt-0 pt_lg_50 pb-0 pb-lg-4">
                <button type="submit" id="fsubmit" class="btn btn-primary">전송</button>
                <button type="button" class="d-none d-lg-block btn btn-gray text-white" onclick="location.href='/album'">목록</button>
                @if($mode == 'w')
                <button type="button" class="d-block d-lg-none btn btn-gray text-white" onclick="jalert2('임시저장을 하시겠습니까?\n이미지와 동영상은 별도의 스토리지에 저장되며, 이미 저장된 이미지가 있을 수 있습니다.', '임시저장', tmpSave);">임시저장</button>
                @endif
            </div>
        </form>
    </div>
</article>

<div class="loading_wrap" id="loading" style="display: none;">
    <div class="loading_text">
        <i class="loading_circle"></i>
        <span>로딩중</span>
    </div>
</div>

<script>
    var delete_ids = [];
    var tmp_file_ids = [];
    var tmp_file_delete_ids = [];
    var upload_cont = 0;
    var multiform_idx = [];
    var multiform_delete_idx = [];
    let isSetTmp = false;

    @if(isset($row['file']) && is_array($row['file']) && count($row['file']) > 0)
        upload_cont = {{ count($row['file']) }}
    @endif

    // alert(upload_cont)
    var fsubmit = false;

    function frm_form_chk(f) {
        if (fsubmit) {
            return false;
        }
        fsubmit = true;
        $("#fsubmit").prop('disabled',true);

        if (ycommon.getUploadCount(upload_cont-delete_ids.length+tmp_file_ids.length) > 10 ) {
            fsubmit = false;
            $("#fsubmit").prop('disabled',false);
            jalert("사진 및 동영상을 10개 초과할 수 없습니다.");
            return false;
        }

        if (ycommon.getUploadCount(upload_cont-delete_ids.length+tmp_file_ids.length) == 0) {
            fsubmit = false;
            $("#fsubmit").prop('disabled',false);
            jalert("첨부파일이 없습니다!");
            return false;
        }

        // const currentDate = new Date();
        // const ymdValue = new Date(f.ymd.value);

        @if($user == "86293")
            //jalert(currentDate);
            //jalert(ymdValue);
            //return false;
        @endif

        if (delete_ids.length > 0) {
            f.delete_ids.value = delete_ids.join(',');
        }

        if (tmp_file_ids.length > 0) {
            f.tmp_file_ids.value = tmp_file_ids.join(',');
        }

        if (f.title.value == "") {
            fsubmit = false;
            $("#fsubmit").prop('disabled',false);
            jalert("제목을 입력해주세요.");
            return false;
        }

        if (f.ymd.value == "") {
            fsubmit = false;
            $("#fsubmit").prop('disabled',false);
            jalert("작성일자를 입력해주세요.");
            return false;
        }

        //if (ymdValue > currentDate) {
        //    fsubmit = false;
        //    $("#fsubmit").prop('disabled',false);
        //    jalert('미래 날짜는 선택할 수 없습니다.');
        //    return false;
        //}

        @if($mode == "w")
        if ($("input[name='student[]']:checked").length == 0) {
            fsubmit = false;
            $("#fsubmit").prop('disabled',false);
            jalert("학생을 선택해 주세요.");
            return false;
        }
        @else
        if (f.student.value == "") {
            fsubmit = false;
            $("#fsubmit").prop('disabled',false);
            jalert("잘못된 접근입니다.");
            return false;
        }
        @endif

        ycommon.setDeleteUploadFile(multiform_delete_idx);

        ycommon.deleteData('album');
        ycommon.deleteData('file');

        $('#loading').show();

        return true;
    }

    $('.btn_preview').on('click',function(){
        // modalShow('notePreview');
        getAlbumPreview();
    });

    function tmpSave() {
        let multiform_delete_idx2 = ycommon.getMultiformDeleteIdxs(multiform_delete_idx);
        if ($('.upload_files').length > 0 || tmp_file_delete_ids.length > 0) {
            const formData = new FormData();
            formData.append("user", userId);
            formData.append("type", '4');
            formData.append("isSetTmp", isSetTmp);
            if ($('.upload_files').length > 0) {
                for(let i=0; i < $('.upload_files').length; i++) {
                    let del_keys = [];
                    for(let j=0; j< multiform_delete_idx2.length; j++) {
                        let ds = multiform_delete_idx2[j].split('_');
                        if (ds[0] == i) del_keys.push(ds[1]);
                    }
                    if ($('.upload_files').eq(i).val()) {
                        for(let j=0; j<$('.upload_files')[i].files.length; j++) {
                            if (del_keys.indexOf(j+"") === -1) formData.append("upload_files[]", $('.upload_files')[i].files[j]);
                        }
                    }
                }
            }
            if (tmp_file_delete_ids.length > 0) {
                formData.append("delete_files", tmp_file_delete_ids.join(','));
            }

            $('#loading').show();

            let action = `/api/tmpFileSave`;
            ycommon.ajaxJson('post', action, formData, undefined, function () {
                    let title = $('#title').val();
                    let ymd = $('#ymd').val();
                    let studentChk = $('input[name="student[]"]:checked');
                    let student = [];
                    if (studentChk.length > 0) {
                        for (let i=0; i<studentChk.length; i++) {
                            if ($(studentChk[i]).val()) student.push($(studentChk[i]).val());
                        }
                    }
                    ycommon.setData('album',{
                        title: title,
                        ymd: ymd,
                        student: student
                    });

                    $('#loading').hide();
                    jalert("임시저장 되었습니다.");
                }, undefined,
                function (jqXHR, textStatus, errorThrown){
                    $('#loading').hide();
                    jalert("파일 임시저장에 실패하였습니다.");
                    }, 30000, undefined, {processData: false, contentType: false},
            );

            ycommon.setData('file', {
                file: 'Y'
            });
        } else {
            ycommon.deleteData('file');

            let title = $('#title').val();
            let ymd = $('#ymd').val();
            let studentChk = $('input[name="student[]"]:checked');
            let student = [];
            if (studentChk.length > 0) {
                for (let i=0; i<studentChk.length; i++) {
                    if ($(studentChk[i]).val()) student.push($(studentChk[i]).val());
                }
            }
            ycommon.setData('album',{
                title: title,
                ymd: ymd,
                student: student
            });

            jalert("임시저장 되었습니다.");
        }

    }

    function setTmpSave() {
        // ycommon.setData('file', {
        //     file: 'Y'
        // });

        isSetTmp = true;

        // console.log("임시 저장 불러오기!!!");
        let tmpData = ycommon.getData('album');
        if (tmpData.title !== undefined) $('#title').val(tmpData.title);
        if (tmpData.ymd !== undefined) $('#ymd').val(tmpData.ymd);
        if (tmpData.student !== undefined && tmpData.student.length !== undefined) {
            for (let i=0; i<tmpData.student.length; i++) {
                $('input[name="student[]"][value="'+tmpData.student[i]+'"]').prop("checked", true);
            }
        }

        let fileData = ycommon.getData('file');

        if (fileData) {
            let action = `/api/tmpFiles`;
            ycommon.ajaxJson('get', action, {user: userId, type: "4"}, undefined, function (data){
                // console.log(data)
                if (data.count !== undefined && data.count > 0) {
                    let privewUploade = '<div class="image-upload2 on mr-3 videoThumnail" data-id="{i}" id="image-upload-{i}">'+
                        '<label id="label_upload_file_{i}" for="upload_file_{i}">' +
                        '<div class="upload-icon2">' +
                        '<button type="button" class="btn del" data-tmpid="{image_id}"></button>' +
                        '{image}' +
                        '</div>' +
                        '</label>' +
                        '</div>';
                    let previewHtml = '<div class="att_img mb-4" id="imageVideo{i}">' +
                        '<div class="rounded overflow-hidden">' +
                        '{imageVideo}' +
                        '</div>' +
                        '</div>' ;

                    let privewUploadeTmp, previewHtmlTmp;

                    for(let i=0;i<data.list.length; i++) {
                        tmp_file_ids.push(data.list[i].file_id);

                        privewUploadeTmp = privewUploade;
                        privewUploadeTmp = privewUploadeTmp.replaceAll("{i}", data.list[i].file_id);
                        privewUploadeTmp = privewUploadeTmp.replaceAll('{image_id}', data.list[i].file_id);
                        if (data.list[i].vimeo_id == "video") {
                            privewUploadeTmp = privewUploadeTmp.replaceAll('{image}', "<video preload='metadata'><source src='"+data.list[i].file_path+'#t=1'+"' /></video>");
                        } else {
                            privewUploadeTmp = privewUploadeTmp.replaceAll('{image}', "<img src='"+data.list[i].file_path+"' />");
                        }

                        previewHtmlTmp = previewHtml;
                        previewHtmlTmp = previewHtmlTmp.replaceAll("{i}", data.list[i].file_id);
                        if (data.list[i].vimeo_id == "video") {
                            previewHtmlTmp = previewHtmlTmp.replaceAll('{imageVideo}', '<video preload="metadata"><source src="'+data.list[i].file_path+"#t=1"+'" class="w-100"></video>');
                        } else {
                            previewHtmlTmp = previewHtmlTmp.replaceAll('{imageVideo}', '<img src="'+data.list[i].file_path+'" class="w-100">');
                        }

                        $('#imgUpload').append(privewUploadeTmp)
                        $('#imageVideo').append(previewHtmlTmp)

                        const attImgTag = document.querySelector('.att_img video');
                        if (attImgTag) {
                            attImgTag.load();
                            attImgTag.pause();
                        }

                        const videoThumnailTag = document.querySelectorAll('.videoThumnail');

                        videoThumnailTag.forEach((elem) => {
                            let videoTag = elem.querySelector('video');

                            if (videoTag) {
                                videoTag.load();
                                videoTag.pause();
                            }
                        })
                    }
                    setTimeout(function (){
                        ycommon.setUploadCount(tmp_file_ids.length);
                    },100);
                }
            });
        }

    }

    function getAlbumPreview() {
        let title = $('#title').val();
        let ymd = $('#ymd').val();
        let ymdText = (ymd != "") ? ymd.replaceAll("-",".") + " " + ycommon.getYmdLable(ymd) : "";
        let d = new Date(),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear(),
            H = '' + d.getHours(),
            i = '' + d.getMinutes();
        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
        if (H.length < 2) H = '0' + H;
        if (i.length < 2) i = '0' + i;
        // let crDt = [year, month, day].join('.') + " " + [H, i].join(':');

        $('#ymdModal').text(ymdText);
        $('#titleModal').text(title);
        // $('#crDt').text(crDt);
        $('#imageVideo').html();
        modalShow('albumPreview');
    }

    $(document).ready(function() {
        $("#chkStudentAll").on("click", function() {
            if($("#chkStudentAll").is(":checked")) $("input.chkStudent").prop("checked", true);
            else $("input.chkStudent").prop("checked", false);
        });

        var i = 0;
        $(".addBtn").on('click', function(e) {
            // if (ycommon.getUploadCount(upload_cont-delete_ids.length+tmp_file_ids.length) > 10) {
            //     jalert("사진 동영상은 10개까지만 등록 가능합니다.");
            //     return;
            // }

            let addForm = '<div class="image-upload2 mr-3" data-id="'+i+'" id="image-upload-'+i+'">'+
                '<label id="label_upload_file_'+i+'" for="upload_file_'+i+'">' +
                '<div class="upload-icon2">' +
                '<button type="button" class="btn del"></button>' +
                '</div>' +
                '</label>' +
                '</div>';


            addForm += '<input id="upload_file_'+i+'" multiple="multiple" name="upload_files[]" class="upload_files d-none" data-id="'+i+'" type="file" accept="image/jpg,image/jpeg,video/mp4" />';

            $('#imgUpload').append(addForm);
            $('#label_upload_file_'+i).trigger('click');
            i++;
        });

        @if(isset($row['file']) && is_array($row['file']) && count($row['file']) > 0)

        //수정시 썸네일 이미지 처리
        let privewUploade = '<div class="image-upload2 on mr-3" data-id="{i}" id="image-upload-{i}">'+
            '<label id="label_upload_file_{i}" for="upload_file_{i}">' +
            '<div class="upload-icon2">' +
            '<button type="button" class="btn del" data-imgid="{image_id}"></button>' +
            '<img src="{image}" />' +
            '</div>' +
            '</label>' +
            '</div>';
        let previewHtml = '<div class="att_img mb-4" id="imageVideo{i}">' +
            '<div class="rounded overflow-hidden">' +
            '<img src="{image}" class="w-100">' +
            '</div>' +
            '</div>' ;
        let privewUploadeTmp, previewHtmlTmp;
        @foreach($row['file'] as $file)
            privewUploadeTmp = privewUploade;
        privewUploadeTmp = privewUploadeTmp.replaceAll("{i}",'{{$file['file_id']}}');
        privewUploadeTmp = privewUploadeTmp.replaceAll('{image_id}','{{$file['file_id']}}');
        privewUploadeTmp = privewUploadeTmp.replaceAll('{image}','{{$file['file_path']}}');

        previewHtmlTmp = previewHtml;
        previewHtmlTmp = previewHtmlTmp.replaceAll("{i}",'{{$file['file_id']}}');
        previewHtmlTmp = previewHtmlTmp.replaceAll('{image}','{{$file['file_path']}}');

        $('#imgUpload').append(privewUploadeTmp)
        $('#imageVideo').append(previewHtmlTmp)
        @endforeach
        setTimeout(function (){
            ycommon.setUploadCount(upload_cont);
        },100);
        @endif


        $(document).on('change', '.upload_files', function(e) {
            let entireCount = parseInt(document.getElementById('uploadCount').innerText);

            if (entireCount + this.files.length > 10) {
                jalert("사진 동영상은 10개까지만 등록 가능합니다.");
                return;
            }

            const imageMaxSize = 10 * 1024 * 1024; // 10MB
            const videoMaxSize = 10 * 10 * 1024 * 1024 * 1.1; // 110MB

            let breaker = false;
            let videoCount = 0;
            for (var i = 0; i < this.files.length; i++) {

                if (this.files[i].type.startsWith('image/')) {
                    if (this.files[i].size > imageMaxSize) {
                        jalert('파일 크기가 너무 큽니다. 10MB 이하의 파일을 선택하세요.');
                        this.value = '';
                        return;
                    }
                } else if (this.files[i].type.startsWith('video/')) {
                    videoCount++;
                    document.querySelectorAll('video').forEach((elem) => {
                        if (elem) {
                            breaker = true;
                        }
                    })

                    if (breaker) {
                        jalert('동영상은 하나만 첨부할 수 있습니다.');
                        this.value = '';
                        return;
                    }

                    if (this.files[i].size > videoMaxSize) {
                        jalert('파일 크기가 너무 큽니다. 100MB 이하의 파일을 선택하세요.');
                        this.value = '';
                        return;
                    }
                }
            }

            if (videoCount > 1) {
                jalert('동영상은 하나만 첨부할 수 있습니다.');
                this.value = '';
                return;
            }

            // $('#loading').show();


            // document.getElementById('uploadCount').innerText = this.files.length;
            //
            // document.getElementById('uploadWrap').innerHTML = '';
            //
            // for (let fileValue of this.files) {
            //     document.getElementById('uploadWrap').insertAdjacentHTML('beforeend', `<div >${fileValue.name}</div>`);
            // }

            let id = $(this).data('id');
            previewImage(e, id, upload_cont-delete_ids.length+tmp_file_ids.length);
        });

        $(document).on('click', '.image-upload2 .del', function (e){
            let up = $(this).parents('.image-upload2');
            let id = up.data('id');
            up.remove();
            $('#imageVideo'+id).remove();

            let imgId = $(this).data('imgid');
            if (imgId !== undefined) delete_ids.push(imgId);

            let tmpId = $(this).data('tmpid');
            if (tmpId !== undefined) {
                tmp_file_ids = tmp_file_ids.filter((e) => e !== tmpId)
                tmp_file_delete_ids.push(tmpId);
            }

            multiform_delete_idx.push(id);
            ycommon.sortMultiformDeleteIdxs(multiform_delete_idx);

            setTimeout(function (){
                ycommon.setUploadCount(upload_cont-delete_ids.length+tmp_file_ids.length);
            },100);
        });

        @if($mode == 'w')
        let tmpData = ycommon.getData('album');
        // 임시 저장 내용 있을 때 alert 띄워주기
        if (tmpData != null) {
            jalert2('임시 저장된 내용을 불러오시겠습니까?', '불러오기', setTmpSave);
        }
        @endif
    });

    document.querySelector('.back_button').addEventListener('click', function(event) {
        $('#loading').show();
    });


    function previewImage (e, id, upload_cont) {
        const userAgent = navigator.userAgent.toLowerCase();

        let device = '';
        if (userAgent.indexOf("iphone") > -1 || userAgent.indexOf("ipad") > -1 || userAgent.indexOf("ipod") > -1 ) {
            device = 'ios';
        }

        var filesArr = e.target.files;
        // var filesArr = Array.prototype.slice.call(files);

        async function processFiles(filesArr) {
            try {
                for (let i=0; i < filesArr.length; i++) {
                    // alert(filesArr[i].lastModifiedDate + "\n" + filesArr[i].name + "\n" + filesArr[i].size + "\n" + filesArr[i].type);

                    await readFile(i, filesArr[i]); // 각 파일을 처리하는 함수 호출 (비동기 처리)
                }
            } catch (error) {
                alert(JSON.stringify(error));

                // sendErrorToServer(error, filesArr[0]);
            }
        }

        // processFiles(filesArr);

        processFiles(filesArr) // 파일 처리 함수 호출
            .then(() => {
                if (document.getElementById('loading')) {
                    document.getElementById('loading').style.display = 'none';
                    $('#loading').hide();
                }
                // 모든 파일 처리가 완료된 후에 실행할 작업
                // console.log('모든 파일 처리 완료');
            })
            .catch((error) => {
                // 에러 처리
                // console.error('파일 처리 중 에러 발생:', error);
                if (document.getElementById('loading')) {
                    document.getElementById('loading').style.display = 'none';
                    $('#loading').hide();
                }

                // sendErrorToServer(error, filesArr);
            });

        function sendErrorToServer(error, file) {
            const errorData = {
                data: JSON.stringify(error), // 에러 메시지
                userAgent: navigator.userAgent,
                file: {
                    fileName: file.name,
                    fileSize: file.size,
                    fileType: file.type
                }
            };

            // AJAX 요청 보내기
            fetch('/api/jsErrorLog', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(errorData), // 오류 데이터를 JSON 형식으로 전송
            }).then((response) => {
                if (!response.ok) {
                    throw new Error('서버 응답 오류');
                }
                // 서버 응답 처리
            })
                .catch((error) => {
                    console.error('서버로의 오류 보내기 실패:', error);
                });
        }

        function readFile(i, f) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();

                reader.onload = function (e) {
                    let id2 = id;
                    if (i > 0) {
                        id2 = id+"_"+i;
                    } else if (i == 0) {
                        $('#label_upload_file_'+id).attr('for','00');
                    }
                    multiform_idx.push(id2);

                    $("#image-upload-"+id2).addClass('on');

                    const arrayBuffer = e.target.result;// ArrayBuffer를 Blob으로 변환
                    const blob = new Blob([arrayBuffer], { type: f.type });
                    const imageUrl = URL.createObjectURL(blob);

                    let html = '<div class="att_img mb-4" id="imageVideo'+id2+'">' +
                        '<div class="rounded overflow-hidden">' +
                        '<img src="'+imageUrl+'" class="w-100">' +
                        '</div>' +
                        '</div>' ;
                    $("#imageVideo").append(html);

                    if (i == 0) {
                        $("#image-upload-"+id2).find('.del').after('<img src="'+imageUrl+'" />');
                    } else {
                        let addForm = '<div class="image-upload2 mr-3 on" data-id="'+id2+'" id="image-upload-'+id2+'">'+
                            '<label id="label_upload_file_'+id2+'" for="upload_file_'+id2+'">' +
                            '<div class="upload-icon2">' +
                            '<button type="button" class="btn del"></button>' +
                            '<img src="'+imageUrl+'" />' +
                            '</div>' +
                            '</label>' +
                            '</div>';
                        $('#imgUpload').append(addForm);
                    }

                    if (document.getElementById('loading')) {
                        document.getElementById('loading').style.display = 'none';
                        $('#loading').hide();
                    }

                    ycommon.setUploadCount(upload_cont);

                    resolve(); // 작업이 완료되면 resolve 호출
                };

                reader.onerror = function (error) {
                    switch(error.target.error.code){
                        case error.NOT_FOUND_ERR:
                            alert("파일을 찾을 수 없습니다.");
                            break;
                        case error.SECURITY_ERR:
                            alert("파일에 변경이 있습니다.");
                            break;
                        case error.ABORT_ERR:
                            alert("파일 읽기가 중지되었습니다.");
                            break;
                        case error.NOT_READABLE_ERR:
                            alert("파일 읽을 권한이 없습니다.");
                            break;
                        case error.ENCODING_ERR:
                            alert("파일 허용 용량을 초과하였습니다.");
                            break;
                    }

                    if (document.getElementById('loading')) {
                        document.getElementById('loading').style.display = 'none';
                        $('#loading').hide();
                    }

                    reject(error); // 에러 발생 시 reject 호출
                };

                reader.readAsArrayBuffer(f); // 파일 읽기 작업 시작
            });
        }
    }

</script>


@endsection

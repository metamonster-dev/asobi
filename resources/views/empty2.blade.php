<script>
    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);

    filesArr.forEach(function (f, i) {
        var reader = new FileReader();
        reader.onload = function (e) {

            // 썸네일을 보여줄 캔버스 엘리먼트 생성
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
            canvas.width = 160; // 썸네일 너비
            canvas.height = 90; // 썸네일 높이

            $("#image-upload-" + id2).addClass('on');

            let html = '<div class="att_img mb-4" id="imageVideo' + id2 + '">' +
                '<div class="rounded overflow-hidden">' +
                '<video preload="metadata">' +
                '<source src="' + e.target.result + '#t=0.001' + '" class="w-100" type="video/mp4">' +
                '</video>' +
                '</div>' +
                '</div>';
            // console.log(html);

            $("#imageVideo").append(html);

            console.log(document.getElementById('imageVideo'+id2));

            video.addEventListener('loadeddata', function() {
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                var thumbnailDataUrl = canvas.toDataURL();

                // 이미지 엘리먼트를 생성하여 썸네일 추가
                var thumbnailImg = document.createElement('img');
                thumbnailImg.src = thumbnailDataUrl;

                // 이미지 엘리먼트를 비디오 아래에 추가
                var parentDiv = document.getElementById('image-upload-' + id2);
                parentDiv.appendChild(thumbnailImg);
            });

            if (i == 0) {
                $("#image-upload-" + id2).find('.del').after('<video preload="metadata"><source src="' + e.target.result + '#t=0.001' + '" type="video/mp4"/></video>');
            } else {
                let addForm = '<div class="image-upload2 mr-3 on" data-id="' + id2 + '" id="image-upload-' + id2 + '">' +
                    '<label id="label_upload_file_' + id2 + '" for="upload_file_' + id2 + '">' +
                    '<div class="upload-icon2">' +
                    '<button type="button" class="btn del"></button>' +
                    '<video preload="metadata"><source src="' + e.target.result + '#t=0.001' + '" type="video/mp4"/></video>' +
                    '</div>' +
                    '</label>' +
                    '</div>';

                video.addEventListener('loadeddata', function() {
                    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                    var thumbnailDataUrl = canvas.toDataURL();

                    // 이미지 엘리먼트를 생성하여 썸네일 추가
                    var thumbnailImg = document.createElement('img');
                    thumbnailImg.src = thumbnailDataUrl;

                    // 이미지 엘리먼트를 비디오 아래에 추가
                    var parentDiv = document.getElementById('image-upload-' + id2);
                    parentDiv.appendChild(thumbnailImg);
                });

                $('#imgUpload').append(addForm);
            }


            ycommon.setUploadCount(upload_cont);
        }

        reader.readAsDataURL(f);
    });

</script>

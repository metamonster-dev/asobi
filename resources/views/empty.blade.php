{{--<img src="https://via.placeholder.com/150" alt="Description">--}}
{{--<iframe src="https://player.vimeo.com/video/876261885?playsinline=0" frameborder="0" allowfullscreen></iframe>--}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Swiper demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, user-scalable=yes" />

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/pinch-zoom-js@2.3.5/dist/pinch-zoom.umd.min.js"></script>


    <!-- Demo styles -->
    <style>
        html,
        body {
            position: relative;
            height: 100%;
        }

        body {
            background: #eee;
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .swiper {
            width: 100%;
            height: 100%;
            /*visibility: hidden; !* 초기에는 숨김 *!*/
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .fullscreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: #fff;
        }

    </style>
</head>

<body>

{{--<button id="expandButton">전체 화면으로</button>--}}

<!-- Swiper -->
{{--<div class="swiper mySwiper">--}}
{{--    <div class="swiper-wrapper">--}}
{{--        <div class="swiper-slide"><img src="https://via.placeholder.com/150" alt="Description"></div>--}}
{{--        <div class="swiper-slide"><img src="https://via.placeholder.com/150" alt="Description"></div>--}}
{{--        <div class="swiper-slide"><iframe src="https://player.vimeo.com/video/876261885" frameborder="0" allowfullscreen></iframe></div>--}}
{{--    </div>--}}
{{--</div>--}}

<!-- Swiper -->
<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <div class="swiper-zoom-container"></div>
            <img id="test" src="https://swiperjs.com/demos/images/nature-1.jpg" />
        </div>
        <div class="swiper-slide">
            <div class="swiper-zoom-container">
                <img src="https://swiperjs.com/demos/images/nature-2.jpg" />
            </div>
        </div>
        <div class="swiper-slide">
            <div class="swiper-zoom-container">
                <img src="https://swiperjs.com/demos/images/nature-3.jpg" />
            </div>
        </div>
    </div>
    <!-- Add Pagination -->
{{--    <div class="swiper-pagination swiper-pagination-white"></div>--}}
    <!-- Add Navigation -->
{{--    <div class="swiper-button-prev"></div>--}}
{{--    <div class="swiper-button-next"></div>--}}
</div>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
    // var mySwiper = new Swiper('.mySwiper', {
    //     // 여기에 Swiper 구성 옵션을 추가합니다...
    //     on: {
    //         init: function () {
    //             var images = document.querySelectorAll('.swiper-slide img');
    //             images.forEach(function (image) {
    //                 new PinchZoom.default(image);
    //             });
    //         }
    //     }
    // });

    var swiper = new Swiper(".swiper-container", {
        zoom: {
            maxRatio: 5
        },
        // pagination: {
        //     el: ".swiper-pagination"
        // },
        // navigation: {
        //     nextEl: ".swiper-button-next",
        //     prevEl: ".swiper-button-prev"
        // }
    });
    // var originalElem = document.getElementById("test");
    // var elem = document.createElement("img");
    // elem.onload = () => {
    //     originalElem.parentElement
    //         .querySelector(".swiper-zoom-container")
    //         .appendChild(elem);
    //     originalElem.parentElement
    //         .querySelector(".swiper-zoom-container")
    //         .classList.add("zoomed");
    //     originalElem.parentElement
    //         .querySelector(".swiper-zoom-container")
    //         .appendChild(originalElem);
    // };
    // elem.src = "https://loremflickr.com/2000/2000";
</script>
</body>

</html>

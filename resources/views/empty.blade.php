<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Swiper demo</title>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1 user-scalable=no"
    />
    <!-- Link Swiper's CSS -->
    <link
        rel="stylesheet"
        href="https://unpkg.com/swiper@6.2.0/swiper-bundle.css"
    />
    <link rel="stylesheet" href="./src/styles.css" />
</head>
<body>

<style>
    body {
        overflow-y: hidden;
    }
</style>

<!-- Swiper -->
<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <div class="swiper-zoom-container">
                <img id="test" src="https://swiperjs.com/demos/images/nature-1.jpg" />
            </div>
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
<script src="https://unpkg.com/swiper@6.2.0/swiper-bundle.js"></script>

<!-- Initialize Swiper -->
<script>
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
    var originalElem = document.getElementById("test");
    var elem = document.createElement("img");
    elem.onload = () => {
        console.log(1);
        originalElem.parentElement
            .querySelector(".swiper-zoom-container")
            .appendChild(elem);
        originalElem.parentElement
            .querySelector(".swiper-zoom-container")
            .classList.add("zoomed");
        originalElem.parentElement
            .querySelector(".swiper-zoom-container")
            .appendChild(originalElem);
    };
    // elem.src = "https://loremflickr.com/2000/2000";
</script>
</body>
</html>

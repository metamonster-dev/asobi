<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Image and Video Viewer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <style>
        /* CSS 스타일링 */
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            height: 100%;
            overflow-x: scroll;
            scroll-snap-type: x mandatory;
        }

        .item {
            min-width: 100%;
            height: 100%;
            scroll-snap-align: start;
            position: relative;
        }

        img, video {
            max-width: 100%;
            max-height: 100%;
            margin: auto;
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
        }
    </style>
</head>

<body>
<!-- HTML 구조 -->
<div class="container">
    <div class="item">
        <img src="https://via.placeholder.com/150" alt="Image 1">
    </div>
    <div class="item">
        <video controls>
            <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</div>

<!-- JavaScript (스와이프 기능 추가) -->
<script>
    const container = document.querySelector('.container');
    let isDragging = false;
    let startPosition = 0;

    container.addEventListener('mousedown', (e) => {
        isDragging = true;
        startPosition = e.pageX - container.offsetLeft;
    });

    container.addEventListener('mouseup', () => {
        isDragging = false;
    });

    container.addEventListener('mouseleave', () => {
        isDragging = false;
    });

    container.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        e.preventDefault();
        const currentPosition = e.pageX - container.offsetLeft;
        const distance = currentPosition - startPosition;
        container.scrollLeft += distance;
        startPosition = currentPosition;
    });
</script>
</body>

</html>

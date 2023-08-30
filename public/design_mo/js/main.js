// fixed 포지션 변수 설정
// $(window).on('load resize', function () {
//     let wrap_wd_2 = $('.right_wrapper').outerWidth() / 2;
//     $(':root').css('--wrap_wd_2', wrap_wd_2 + 'px');
// });

$('.right_wrapper').on('scroll', function () {
  if ($(this).scrollTop() > 50) {
    $('.h_menu').addClass('scroll');
  } else {
    $('.h_menu').removeClass('scroll');
  }
});



// 더보기 버튼
$('.btn_more').on('click', function (e) {
    e.preventDefault();
    if ($(this).siblings('.more_cont').hasClass('on')) {

    } else {
        $('.more_cont').removeClass('on');
        $('.more_cont').slideUp();
    }
    $(this).siblings('.more_cont').slideToggle();
    $(this).siblings('.more_cont').addClass('on');
});

$('html').click(function (e) {
    const btn = $(e.target).parents('.btn_more');
    if (!btn.hasClass('btn_more')) {
        $('.more_cont').removeClass('on');
        $('.more_cont').slideUp();
    }
});

$('.more_cont .btn').on('click', function (e) {
    e.preventDefault();
});


// 공지사항 필터 on-off
$('.btn_filter').on('click', function () {
    $('.filter_modal').addClass('show');
    $('.filter_modal').removeClass('fade');
});
$('.filter_modal').on('click', function () {
    $('.filter_modal').addClass('fade');
    $('.filter_modal').removeClass('show');
});

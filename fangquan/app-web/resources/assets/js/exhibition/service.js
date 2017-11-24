$(function () {
    require("../../component/exhibition-header");
    // nav
    $('.nav li').click(function () {
        $(this).addClass('active').siblings('li').removeClass('active');
    });

    //滚动条事件
    function floor() {
        left_top = $(window).scrollTop();
        f1 = $('.fl_1').offset().top;
        f2 = $('.fl_2').offset().top;
        f3 = $('.fl_3').offset().top;
        f4 = $('.fl_4').offset().top;
    }

    floor();

    $('.nav .f_1').click(function () {
        $('html,body').stop().animate({
            scrollTop: f1
        }, 500)
    });

    $('.nav .f_2').click(function () {
        $('html,body').stop().animate({
            scrollTop: f2
        }, 500)
    });
    $('.nav .f_3').click(function () {
        $('html,body').stop().animate({
            scrollTop: f3
        }, 500)
    });
    $('.nav .f_4').click(function () {
        $('html,body').stop().animate({
            scrollTop: f4
        }, 500)
    });

    $(window).scroll(function () {
        floor();
        xs = f1 - 580;
        if (left_top >= xs && left_top < (f2 - 360)) {
            le = 0;
        }
        if (left_top >= (f2 - 360) && left_top < (f3 - 360)) {
            le = 1;
        }
        if (left_top >= (f3 - 360) && left_top < (f4 - 360)) {
            le = 2;
        }
        if (left_top >= (f4 - 360)) {
            le = 3;
        }
        setTimeout(function () {
            $('.nav li').eq(le).addClass('active')
                .siblings('li').removeClass('active');
        }, 400)
    });
});
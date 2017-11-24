define([
    'zepto',
    'app/lib/swiper/swiper'
], function ($, Swiper) {
    'use strict';

    // 供应商 & 开发商
    $(".link-type").on("click", function () {
        $(".choose-type").show();
    });
    $('.choose-type a span').on('click', function () {
        var chooseValue = $(this).html();
        $('.link-type span').html(chooseValue);
        $('.keyword').attr('placeholder', chooseValue  + '名');
        $('.choose-type').hide();
    });

    // 轮播图
    var swiper = new Swiper('.carousel .swiper-container', {
        autoplay: 2000,
        speed: 5000,
        loop: true
    });

    //搜索
    $(document).on('click', '.btn', function () {
        var searchContent = $('.keyword').val();
        var type = $('.link-type span').html();
        if (type == '供应商') {
            window.location.href = '/exhibition/provider/index?keyword=' + searchContent;
        } else {
            window.location.href = '/exhibition/developer-project/list?keyword=' + searchContent;
        }

    });
});

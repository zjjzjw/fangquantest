$(function () {
    require("../../../component/exhibition-header");
    var swiper = require('../../../component/swiper');
    var Popup = require('../../../component/popup');
    var temp = require('../../../component/temp');
    var service = require('../../../service/exhibition/flashbackService');

    $loadingPop = new Popup({
        width: 128,
        height: 128,
        contentBg: 'transparent',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#loadingTpl').html()
    });

    $promptPop = new Popup({
        width: 400,
        height: 225,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#promptTpl').html()
    });

    var swiper = new Swiper('.swiper-container', {
        autoplay: 3500,
        speed: 2000,
        loop: true
    });

    $(".swiper-wrapper").mouseenter(function () {//滑过悬停
        swiper.stopAutoplay();
    }).mouseleave(function () {//离开开启
        swiper.startAutoplay();
    });

    var page = 1;
    $(document).on('click', '.look-more', function () {
        var opt = {data: {}};
        var $data_dom = $('.exhibition-list-box');
        page = page + 1;

        service.lookMore({
            data: {page: page},
            beforeSend: function () {
                $loadingPop.showPop(opt);
            },
            sucFn: function (data, status, xhr) {
                $loadingPop.closePop();
                var tempList = temp('list_tpl', {
                    data: data.items
                });
                $data_dom.append(tempList);
                if (data.items.length < 6) {
                    $('.look-more').hide();
                }
            },
            errFn: function (data, status, xhr) {
            }
        });
    });
});
define([
    'zepto',
    'ui.popup',
    'zepto.temp',
    'page.params',
    'app/lib/swiper/swiper',
    'app/service/exhibition/exhibitionService'
], function ($, Popup, temp, params, Swiper, service) {
    'use strict';

    var page = 1;
    var $loadingPop;

    $loadingPop = new Popup({
        width: 60,
        height: 60,
        contentBg: 'transparent',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#loadingTpl').html()
    });

    // nav
    $(".cut").click(function (event) {
        event.preventDefault();
        $(this).parent().toggleClass("active");
        if ($(this).parent().hasClass('active')) {
            $(this).parent().find('.content-box').show();
        } else {
            $(this).parent().find('.content-box').hide();
        }
    });

    // 轮播图
    var swiper = new Swiper('.flashback .swiper-container', {
        autoplay: 3500,
        speed: 2000,
        loop: true,
        observer: true,
        observeParents: true
    });


    //显示更多
    $(document).on('click', '.show-more', function () {
        var $data_dom = $('.show-more-list');
        $loadingPop.showPop();
        page = page + 1;
        service.showMore({
            data: {page: page},
            sucFn: function (data, status, xhr) {
                $loadingPop.closePop();
                var tpl = temp('show_moreTpl', {
                    'data': data
                });
                $data_dom.append(tpl);
                if (data.items.length < 4) {
                    $('.show-more').hide();
                }
            },
            errFn: function (data, xhr, errorType, error) {
            }
        });
    });


    function showError(data) {
        var info = '';
        var messages = [];
        var i = 0;
        for (var key in data) {
            messages.push(++i + "、" + data[key][0]);
        }
        info = messages.join('</br>');
        return info;
    }


});

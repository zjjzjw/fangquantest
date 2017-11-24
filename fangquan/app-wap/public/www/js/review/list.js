define([
    'zepto',
    'ui.popup',
    'zepto.temp',
    'page.params',
    'app/service/review/reviewService'
], function ($, Popup, temp, params, service) {
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


    //显示更多
    $(document).on('click', '.show-more', function () {
        var $data_dom = $('.activity');
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
                if (data.items.length < 10) {
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

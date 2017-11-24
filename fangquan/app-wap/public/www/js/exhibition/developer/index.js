define([
    'zepto',
    'ui.popup',
    'zepto.temp',
    'page.params',
    'app/service/exhibition/developer/developerService'
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
    $(document).on('click', '.more-developer', function () {
        var $data_dom = $('.activity');
        $loadingPop.showPop();
        page = page + 1;
        service.lookMoreD({
            data: {page: page},
            sucFn: function (data, status, xhr) {
                console.log(data);
                $loadingPop.closePop();
                var tpl = temp('developer_tpl', {
                    'data': data
                });
                $data_dom.append(tpl);
                if (data.items.length < 12) {
                    $('.more-developer').hide();
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


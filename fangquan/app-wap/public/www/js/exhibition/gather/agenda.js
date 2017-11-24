define([
    'zepto',
    'ui.popup',
    'page.params',
    'app/service/exhibition/gather/agendaService'
], function ($, Popup, params, service) {
    'use strict';

    var $errorPop,
        $loadingPop;

    $errorPop = new Popup({
        width: 250,
        height: 180,
        content: $('#errorTpl').html()
    });

    $loadingPop = new Popup({
        width: 60,
        height: 60,
        contentBg: 'transparent',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#loadingTpl').html()
    });


    $(".btn").on("click", function () {
        var type = params.type;
        $loadingPop.showPop();
        service.time({
            data: {},
            sucFn: function (data, status, xhr) {
                if (data.success) {
                    //供应商问题
                    if (type == 2) {
                        $loadingPop.closePop();
                        window.location.href = '/exhibition/question/provider-qs';
                    }
                    //开发商问题
                    if (type == 3) {
                        $loadingPop.closePop();
                        window.location.href = '/exhibition/question/developer-qs';
                    }
                } else {
                    $loadingPop.closePop();
                    $errorPop.showPop();
                }
            },
            errFn: function (data, xhr, errorType, error) {
            }
        });
    });

    $('#pop_close').on('click', function () {
        $errorPop.closePop();
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
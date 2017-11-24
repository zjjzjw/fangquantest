define([
    'zepto',
    'zepto.temp',
    'app/service/exhibition/footerService'
], function ($, temp, service) {
    'use strict';
    //开发商更多
    $('.more-developer').click(function () {
        var opt = {data: {}};
        var length = $('.developer-box li').length;
        service.lookMoreD({
            data: {},
            params: {length: length},
            sucFn: function (data, status, xhr) {
                var tempList = temp('developer_tpl', {
                    data: data.items
                });
                $('.developer-box').append(tempList);
                if (!data.items.length) {
                    $('.more-developer').hide();
                }
            },
            errFn: function (data, status, xhr) {
            }
        });
    });
    //供应商更多
    $('.more-provider').click(function () {
        var opt = {data: {}};
        var length = $('.provider-box li').length;
        service.lookMoreP({
            data: {},
            params: {length: length},
            sucFn: function (data, status, xhr) {
                var tempList = temp('provider_tpl', {
                    data: data.items
                });
                $('.provider-box').append(tempList);
                if (!data.items.length) {
                    $('.more-provider').hide();
                }
            },
            errFn: function (data, status, xhr) {
            }
        });
    });
});

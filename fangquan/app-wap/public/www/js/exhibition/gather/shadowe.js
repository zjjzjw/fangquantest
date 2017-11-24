define([
    'zepto',
    'ui.popup',
    'wx'
], function ($, Popup, wx) {
    'use strict';

    $('.out').click(function () {
        WeixinJSBridge.call('closeWindow');
    });
});
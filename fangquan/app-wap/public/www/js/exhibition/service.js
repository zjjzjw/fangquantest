define([
    'zepto',
], function ($, Popup, params, service) {
    'use strict';

    $(".list-content h3").click(function (event) {
        event.preventDefault();
        $(this).parent().toggleClass("active");
        if ($(this).parent().hasClass('active')) {
            $(this).parent().find('.service-contenet').show();
        } else {
            $(this).parent().find('.service-contenet').hide();
        }
    });
});
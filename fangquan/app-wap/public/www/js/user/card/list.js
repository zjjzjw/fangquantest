define(['zepto'], function ($) {
    'use strict';

    var List = function () {
        var self = this;
        self.bindEvent();
    };

    List.prototype.bindEvent = function () {
        var self = this;
        $('.letter a').on('click', function () {
            var s = $(this).html();
            if ($('#' + s).length > 0) {
                $(window).scrollTop($('#' + s).offset().top);
            }
        });
        $('.com-back').attr("href", "/user/list");
    };
    new List();
});

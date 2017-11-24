define(['zepto', 'page.params', 'backbone'], function ($, params, Backbone) {
    'use strict';

    var Progress = function () {
        var self = this;

        self.init();
        self.bindEvent();
    };

    Progress.prototype.bindEvent = function () {
        var self = this;
        $('.show-icon').on('click', function () {
            if ($(this).hasClass('show-more')) {
                $(this).removeClass('show-more');
                $(this).parent().parent().find('.event-box').hide();
            } else {
                $(this).parent().parent().find('.event-box').show();
                $(this).addClass('show-more');
            }
        });
    };


    Progress.prototype.init = function () {
        var self = this;
    };
    new Progress();
});

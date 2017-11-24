define(['zepto', 'page.params', 'backbone'], function ($, params, Backbone) {
    'use strict';

    var List = function () {
        var self = this;

        self.init();
        self.bindEvent();
    };

    List.prototype.bindEvent = function () {
        var self = this;
        $('.show-icon').on('click', function () {
            if ($(this).hasClass('show-more')) {
                $(this).removeClass('show-more');
                $(this).parent().next().hide();
            } else {
                $(this).parent().next().show();
                $(this).addClass('show-more');
            }
        });
    };


    List.prototype.init = function () {
        var self = this;
        $('.com-back').attr("href", "/project/detail/" + params.project_id);
    };
    new List();
});

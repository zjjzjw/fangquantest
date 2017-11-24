define(['zepto'], function ($) {
    'use strict';

    var Contacts = function(){
        var self = this;
        self.bindEvent();
    };
    Contacts.prototype.bindEvent = function(){
        var self = this;
        $('.name').on('click', function () {
            if ($(this).children().hasClass('item-show')) {
                $(this).children().removeClass('item-show');
                $(this).next().hide();
            } else {
                $(this).children().addClass('item-show');
                $(this).next().show();
            }
        });
    };
    new Contacts();
});
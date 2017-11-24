define([
    'zepto'
], function ($) {
    var Signed = function () {
        var self = this;
        self.init();
    };

    Signed.prototype.init = function () {
        var self = this;

        $(document).on('click', '.name', function () {
            if ($(this).children().hasClass('item-show')) {
                $(this).children().removeClass('item-show');
                $(this).next().hide();
            } else {
                $(this).children().addClass('item-show');
                $(this).next().show();
            }
        })
    };

    new Signed();
});
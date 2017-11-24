define([
    'zepto'
], function ($) {
    var Payment = function () {
        var self = this;
        self.init();
    };

    Payment.prototype.init = function () {
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

    new Payment();
});
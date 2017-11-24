define([
    'zepto'
], function ($) {
    var Task = function () {
        var self = this;
        self.init();
    };

    Task.prototype.init = function () {
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

    new Task();
});
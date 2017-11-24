define("ui.navbar", ['zepto'], function($, params) {
    "use strict";

    $.fn.navbar = function (_op) { // jshint ignore:line
        var $panel = $('#panel'),
            $mask = $('#panel_mask'),
            $contentWrapper = $('.content-wrapper'),
            interval = 500;

        function hideNavbar () {
            $panel.removeClass('panel-active');

            setTimeout(function(){  // jshint ignore:line
                $contentWrapper.removeClass('event-inactive');
            }, interval);

            $panel.removeClass('event-inactive');
            $mask.removeClass('panel-mask').addClass('hide-mask');
        }

        return this.each(function () {
            $(this).on('click', function () {
                $contentWrapper.addClass('event-inactive');
                $panel.addClass('event-inactive');

                setTimeout(function(){ // jshint ignore:line
                    $panel.removeClass('event-inactive');
                }, interval);

                $panel.addClass('panel-active');
                $mask.addClass('panel-mask').removeClass('hide-mask');
            });

            $mask.on('click, touchstart.mask, touchmove.mask', function () {
                hideNavbar();
            });

            $(window).on('scroll.navbar', function() {
                hideNavbar();
            });

            $panel.on('touchstart.navbar', function(e){
                if ('a' != e.target.tagName.toLowerCase()) {
                    hideNavbar();
                }
            });
            $panel.on('touchmove.navbar', function () {
                hideNavbar();
            });
        });
    };

    return $.fn.navbar;
});
define(['zepto', 'page.params'], function($, params) {
    'use strict';

    var solve, up, down;
    var $img = $('.diagram-item img'),
        $diagramBox = $('.house-diagram'),
        length = $img.length,
        top = $diagramBox.offset().top,
        height = $diagramBox.height();

    changeImg();

    $(window).on('scroll', function() {
        changeImg();
        addLog();
    });

    function changeImg() {
        if (solve) return;
        for (var i = 0; i < length; i++) {
            var cur = $img.eq(i);
            if (cur.offset().top < parseInt($(window).height()) + parseInt($(window).scrollTop())) {
                if (cur.data('high')) {
                    cur.attr('src', cur.data('high'));
                    cur.data('high', '');
                }
            }
            if (!$img.eq(length - 1).data('high')) solve = true;
        }
    }

    function addLog() {
        if (!up && top < parseInt($(window).height()) + parseInt($(window).scrollTop())) {
            $.trackEvent({
                action: 'TW_HOUSE_Click_Imagetextup',
                page_param: {
                    inventoryId: params.property_id || ''
                }
            });
            up = true;
        }
        if (!down && (top + height) < parseInt($(window).height()) + parseInt($(window).scrollTop())) {
            $.trackEvent({
                action: 'TW_HOUSE_Click_Imagetextdown',
                page_param: {
                    inventoryId: params.property_id || ''
                }
            });
            down = true;
        }
    }

});
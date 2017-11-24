$(function () {
    $('.screen .sl_value .sl_more').hover(function () {
        $(this).find('a').addClass('sl_off');
        $(this).find('.sl_tab_cont').show();
    }, function () {
        $(this).find('a').removeClass('sl_off');
        $(this).find('.sl_tab_cont').hide();
    });
});
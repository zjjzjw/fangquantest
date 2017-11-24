define(['zepto'], function($) {
    $('.more-link').on('click', function() {
        $('.more-link').hide();
        $('.close-link').show();
    });
    $('.close-link').on('click', function() {
        $('.close-link').hide();
        $('.more-link').show();
    });
});
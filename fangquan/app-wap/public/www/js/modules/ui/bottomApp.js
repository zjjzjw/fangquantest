define(['zepto'], function($) {
    var cookieDate = $.getCookie('appClose');
    var cookieDateTop = $.getCookie('appClose-top');
    var date = new Date();
    var now = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();

    if (!cookieDate) {
        $('.app-box').show();
    } else if (cookieDate != now) {
        $('.app-box').show();
    }

    $('.app-close').on('click', function() {
        $('.app-box').remove();
        var date = new Date();
        var now = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
        $.setCookie('appClose', now, 1, '/');
    });

    if (!cookieDateTop) {
        $('.app-box-top').show();
    } else if (cookieDateTop != now) {
        $('.app-box-top').show();
    }

    $('.app-close-top').on('click', function() {
        $('.app-box-top').remove();
        var date = new Date();
        var now = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
        $.setCookie('appClose-top', now, 1, '/');
    });
});
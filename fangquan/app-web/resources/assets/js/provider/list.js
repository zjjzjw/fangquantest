$(function () {
    if (window.innerHeight) {
        var winHeight = window.innerHeight;
    } else if ((document.body) && (document.body.clientHeight)) {
        var winHeight = document.body.clientHeight;
    }
    var obj_height = $('.right-box').height();
    $('.right-box').css('top', (winHeight - obj_height) / 2);

    $(window).resize(function () {
        if (window.innerHeight) {
            var winHeight = window.innerHeight;
        } else if ((document.body) && (document.body.clientHeight)) {
            var winHeight = document.body.clientHeight;
        }
        var obj_height = $('.right-box').height();
        $('.right-box').css('top', (winHeight - obj_height) / 2);
    });
});
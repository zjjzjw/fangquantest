$(function () {

    $('.status').on('click', function () {
        if ($(this).hasClass('expand')) {
            $(this).find('i').html('&#xe613;');
            $(this).removeClass('expand');
            $(this).parent().siblings('ul').show();
        } else {
            $(this).addClass('expand');
            $(this).find('i').html('&#xe623;');
            $(this).parent().siblings('ul').hide();
        }
    });

});
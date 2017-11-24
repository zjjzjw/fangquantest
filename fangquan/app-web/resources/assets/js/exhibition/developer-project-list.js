$(function () {
    require('../../component/exhibition-header');

    $('.first-level').hover(function(){
        $(this).addClass('first-active');
        $(this).next().show();
    },function(){
        $(this).removeClass('first-active');
        $(this).next().hide();
    });
    $('.second-content').hover(function(){
        $(this).prev().addClass('first-active');
        $(this).show();
    },function(){
        $(this).prev().removeClass('first-active');
        $(this).hide();
    });
    $('.second-level').hover(function(){
        $(this).children('a').addClass('second-active');
    },function(){
        $(this).children('a').removeClass('second-active');
    });
});

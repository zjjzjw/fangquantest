$(function () {
    var Popup = require('../../component/popup');
    var Slide = require('../../component/slide');

    $projectTpl = new Popup({
        width: 1200,
        height: 600,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#projectTpl').html()
    });
    $(document).on('click', '.project-box img', function () {
        var opt = {data: {}};
        var toIndex = $(this).data('key');
        $projectTpl.showPop(opt);
        $("body").css({"overflow": "hidden"});
        $('.project-detail').each(function(){
            if($(this).data('index') == toIndex){
                $(this).show();
                var obj = $(this).find('.project-slide');
                $(this).find('.next_a').addClass('next_a_click');
                $(this).find('.prev_a').addClass('prev_a_click');
                $(this).find('.img_ul').addClass('img_ul_pop');
                $(this).find('.img_hd').addClass('img_hd_pop');
                if (obj.find('li').length > 0) {
                    Slide(obj);
                }
            }
        });
        $(document).keydown(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '27') {
                $projectTpl.closePop();
                $('.project-detail').hide();
                $('.project-detail').find('.next_a_click').removeClass('next_a_click');
                $('.project-detail').find('.img_ul_pop').removeClass('img_ul_pop');
                $('.project-detail').find('.img_hd_pop').removeClass('img_hd_pop');
                $('.project-detail').find('.prev_a_click').removeClass('prev_a_click');
            }
        });
    });
    $(document).on('click', '.close-box', function () {
        $projectTpl.closePop();
        $('.project-detail').hide();
        $('.project-detail').find('.next_a_click').removeClass('next_a_click');
        $('.project-detail').find('.img_ul_pop').removeClass('img_ul_pop');
        $('.project-detail').find('.img_hd_pop').removeClass('img_hd_pop');
        $('.project-detail').find('.prev_a_click').removeClass('prev_a_click');
    });
});
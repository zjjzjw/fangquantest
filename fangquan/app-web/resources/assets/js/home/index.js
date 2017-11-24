$(function () {
    var textSlide = require('../../component/text-slide');
    //信息轮播
    var text_li = $('.scroll .scroll-box li').length;
    if (text_li > 1) {
        textSlide({
            element: '.scroll',
            speed: '3000',
            child_element: '.scroll-box',
            during:'1000'
        });
        $(".scroll .scroll-box li:eq(0)").appendTo($(".scroll .scroll-box"))

    }

    $(document).on('click', '.btn', function () {
        searchContent = $('.keyword').val();
        window.location.href = '/developer/developer-project/list?keyword=' + searchContent;
    });

    // 回车事件
    $('#keyword').focus(function () {
        $('#keyword').keypress(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                var key_word = $('#keyword').val();
                if (key_word != '') {
                    window.location.href = "/developer/developer-project/list?keyword=" + key_word;
                }
            }
        });
    });

    // //信息轮播
    // var index =0;
    // var timer = setInterval(function(){
    //     index = (index == 2) ? 0 : index + 1;
    //     $(".scroll-item").hide().eq(index).show();
    // }, 2000);
});


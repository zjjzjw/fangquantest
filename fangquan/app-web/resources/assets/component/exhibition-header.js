$(function () {
    //展示列表
    $('.exhibitor-list').hover(function () {
        $('.list-box').show();
    }, function () {
        $('.list-box').hide();
    });
    $('.list-box').hover(function () {
        $('.list-box').show();
    }, function () {
        $('.list-box').hide();
    });

    $('.link-type').on('click', function () {
        $('.choose-type').show();
    });

    $('.choose-type a span').on('click', function () {
        var chooseValue = $(this).html();
        $('.link-type span').html(chooseValue);
        $('.choose-type').hide();
    });
    //搜索
    $(document).on('click', '.btn', function () {
        searchContent = $('.keyword').val();
        var type = $('.link-type span').html();
        if (type == '供应商') {
            window.location.href = '/exhibition/provider/list?keyword=' + searchContent;
        } else {
            window.location.href = '/exhibition/developer-project-list?keyword=' + searchContent;
        }

    });

    // 回车事件
    $('#keyword').focus(function () {
        $('#keyword').keypress(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                var key_word = $('#keyword').val();
                var link_type = $('.link-type span').html();
                if (key_word != '') {
                    if (link_type == '供应商') {
                        window.location.href = "/exhibition/provider/list?keyword=" + key_word;
                    } else {
                        window.location.href = "/exhibition/developer-project-list?keyword=" + key_word;
                    }
                }
            }
        });
    });
});
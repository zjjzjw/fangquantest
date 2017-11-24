$(function () {
    var Popup = require('./../../../component/popup');
    var temp = require('./../../../component/temp');
    var service = require('./../../../service/content-publish/categoryService');

    var data_id;
    $confirmPop = new Popup({
        width: 400,
        height: 225,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#confirmTpl').html()
    });
    $promptPop = new Popup({
        width: 400,
        height: 225,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#promptTpl').html()
    });
    //显示下层
    $(document).on('click', '.to-all', function () {
        var id = $(this).data('id');
        $(this).parent().parent().addClass('focus-item');
        $(this).parent().parent().find('ul').remove();
        service.getNextContentCategory({
            data: {id: id},
            sucFn: function (data, status, xhr) {
                var html = temp('categoryTpl', {result:data});
                $('.focus-item').append(html);
                $('.focus-item').find('span:first').addClass('close-all').removeClass('to-all').html("-");
                if($('.focus-item').find('ul').find('li').length>0){
                    $('.focus-item').find('ul').show();
                }else{
                    $('.focus-item').find('ul').remove();
                }
                $('.focus-item').removeClass('focus-item');
            },
            errFn: function (data, status, xhr) {
            }
        });
    });
    $(document).on('click','.close-all',function(){
        $(this).addClass('to-all').removeClass('close-all').html('+');
         $(this).parent().parent().find('ul').remove();
    });

    //删除
    $(document).on('click', '#dialog_cancel', function () {
        $confirmPop.closePop();
    });
    $(document).on('click', '#dialog_confirm', function () {
        var opt = {data: {}};
        service.delete({
            data: {id: data_id},
            sucFn: function (data, status, xhr) {
                $confirmPop.closePop();
                window.location.reload();
            },
            errFn: function (data, status, xhr) {
                $confirmPop.closePop();
                $('.text').html(showError(data));
                $promptPop.showPop(opt);
            }
        });
    });

    $(document).on('click', '#pop_close', function () {
        $promptPop.closePop();
    });

    $(document).on('click', '.delete', function () {
        $(".hint-content").find("p").html("确定要删除吗？");
        data_id = $(this).data('id');
        var opt = {data: {}};
        $confirmPop.showPop(opt);
        return false;
    });

    function showError(data) {
        var info = '';
        var messages = [];
        var i = 0;
        for (var key in data) {
            messages.push(++i + "、" + data[key][0]);
        }
        info = messages.join('</br>');
        return info;
    }
});
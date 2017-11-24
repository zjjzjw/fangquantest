$(function () {
    var Popup = require('./../../component/popup');
    var temp = require('./../../component/temp');
    var service = require('../../service/product/productService');

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

    //筛选
    $('.choose-type').on('click', function () {
        $('.article-id .form-error').hide();
        $('.choose-type-box').show();
    });
    $(document).on('click', '.first-wrap', function () {
        var checked_names = $('input[name="category_type"]:checked').val();
        $('.first-wrap').css("background-color", "#fafafa");
        $('.first-wrap').children("ul").hide();
        $(this).css("background-color", "#fff");
        $(this).css("border-right", "none").siblings().css("border-right", "1px solid #d9d9d9");
        $(this).children("ul").show();
        $('.choose-type').val(checked_names);
        $('#choose_type').val();
    });
    $(document).on('click', 'input[name="category_type"]', function () {
        $('.choose-type-box').hide();
        var type_id = $(this).data('type-id');
        $('#choose_type').val(type_id);
    });

    $('.choose-type-box').hover(function () {
        $('.choose-type-box').show();
    }, function () {
        $('.choose-type-box').hide();
    });

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

    $('.delete').on('click', function () {
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
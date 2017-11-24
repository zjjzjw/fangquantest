$(function () {
    var Popup = require('../../component/popup');
    var temp = require('../../component/temp');
    var service = require('../../service/attribute/attributeService');

    $successPop = new Popup({
        width: 200,
        height: 150,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#successTpl').html()
    });
    $loadingPop = new Popup({
        width: 128,
        height: 128,
        contentBg: 'transparent',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#loadingTpl').html()
    });

    $promptPop = new Popup({
        width: 400,
        height: 225,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#promptTpl').html()
    });

    $.validate({
        form: '#form',
        validateOnBlur: false,
        onSuccess: function ($form) {
            moreValidate();
            return false;
        }
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

    //添加属性
    $(document).on('click', '.add-attribute', function () {
        var $attribute_values = $.params.attribute_values;
        var tpl = temp('attribute_valuesTpl', {
            '$attribute_values': $attribute_values
        });
        $('aside').append(tpl);
    });

    $(document).on('click', '.reduce-attribute', function () {
        $(this).parent().parent('.attribute').remove();
    });

    function moreValidate() {
        if (parseInt($.params.id) == 0) {
            $('.error-tip-imageId').hide();
            var opt = {data: {}};
            service.store({
                data: $('#form').serialize(),
                params: $.params,
                beforeSend: function () {
                    $loadingPop.showPop(opt);
                },
                sucFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $successPop.showPop(opt);
                    setTimeout(skipUpdate, 2000);
                    function skipUpdate() {
                        $successPop.closePop();
                        window.location.href = '/category/attribute/index';
                    }
                },
                errFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $('.text').html(showError(data));
                    $promptPop.showPop(opt);
                }
            });
        } else {
            $('.error-tip-imageId').hide();
            var opt = {data: {}};
            service.update({
                data: $('#form').serialize(),
                params: $.params,
                beforeSend: function () {
                    $loadingPop.showPop(opt);
                },
                sucFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $successPop.showPop(opt);
                    setTimeout(skipUpdate, 2000);
                    function skipUpdate() {
                        $successPop.closePop();
                        window.location.href = '/category/attribute/index';
                    }
                },
                errFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $('.text').html(showError(data));
                    $promptPop.showPop(opt);
                }
            });
        }
    }

    $(document).on('click', '#pop_close', function () {
        $promptPop.closePop();
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
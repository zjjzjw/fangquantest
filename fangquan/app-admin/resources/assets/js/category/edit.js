$(function () {
    var Popup = require('../../component/popup');
    var temp = require('../../component/temp');
    var fileupload = require('../../component/fileupload');
    var service = require('../../service/category/categoryService');

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

    //添加属性
    $(document).on('click', '.add-attributes', function () {
        var $attributes = $.params.attributes;
        var tpl = temp('attributesTpl', {
            'attributes': $attributes
        });
        $('.category_attributes').append(tpl);
    });

    $(document).on('click', '.reduce-attributes', function () {
        $(this).parent('p').remove();
    });

    //添加产品字段
    $(document).on('click', '.add-params', function () {
        var tpl = temp('category_paramsTpl');
        $('.category_params').append(tpl);
    });

    $(document).on('click', '.reduce-params', function () {
        $(this).parent('p').remove();
    });

    var attributes_id = new Array();
    var category_attributes_array = new Array();
    $(document).on('change', 'select[name="category_attributes[]"]', function (e) {
        $('.error-message').empty();

        $.each($('select[name="category_attributes[]"]'), function (k, v) {
            category_attributes_array[k] = $('select[name="category_attributes[]"]').eq(k).val();
        });

        category_attributes_array = $.grep(category_attributes_array.sort(), function (n) {
            return $.trim(n).length > 0;
        });

        for (var i = 0; i < category_attributes_array.length; i++) {
            if (category_attributes_array[i] == category_attributes_array[i + 1]) {
                $('.error-message').html('不能选择同样的属性');
                e.target[0].selected = 'true';
            }
        }
    });
    function moreValidate() {
        var error_picture = $('.picture-box-image_id .show-item').length;
        if (error_picture < 1) {
            $('.error-tip-picture').show();
        } else if (parseInt($.params.id) == 0) {
            $('.error-tip-picture').hide();
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
                        window.location.href = '/category/category/index';
                    }
                },
                errFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $('.text').html(showError(data));
                    $promptPop.showPop(opt);
                }
            });
        } else {
            $('.error-tip-picture').hide();
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
                        window.location.href = '/category/category/index';
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


    //上传Icon
    fileupload({
        acceptFileTypes: ['plain', 'jp*g', 'png', 'gif', 'bmp'],
        dom: $('#addPicture-image_id'),
        start: function (e, data) {
            var opt = {data: {}};
            $loadingPop.showPop(opt);
        },
        always: function (e, data, Errors) {
        },
        progress: function (e, data) {
            var loaded = e.delegatedEvent['loaded'];
            var total = e.delegatedEvent['total'];

            $('.upload-progress').html((Number(loaded / total * 100)).toFixed(2) + '%');
        },
        callback: function (result, data) {
            $loadingPop.closePop();
            var tempFiles = temp('files_tpl', {
                data: data,
                result: result,
                name: 'image_id',
                single: true
            });

            $('.upload-progress').html('');
            $('.add-image_id').before(tempFiles);
            $('.add-image_id').css('border-color', '#d9d9d9');
            $('.add-image_id').hide();

            //图片删除
            $('.picture-box-image_id .show-item').on('click', '.delete', function () {
                $(this).parent('.show-item').remove();
                $('.add-image_id').show();
            });
        }
    });

    //删除
    $('.picture-box-image_id .show-item').on('click', '.delete', function () {
        $(this).parent('.show-item').remove();
        $('.add-image_id').show();
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
$(function () {
    var Popup = require('../../component/popup');
    var temp = require('../../component/temp');
    var Search = require('../../component/search');
    var fileupload = require('../../component/fileupload');
    var service = require('../../service/product/productService');

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
        $(this).children("ul").show();
        $('.choose-type').val(checked_names);
        $('#choose_type').val();
    });
    $(document).on('click', 'input[name="category_type"]', function () {
        $('.choose-type-box').hide();
        var type_id = $(this).data('type-id');
        $('#choose_type').val(type_id);

        var opt = {data: {}};
        $('.attributes-box').empty();
        if (type_id) {
            service.attribute({
                data: {'id': type_id},
                params: $.params,
                beforeSend: function () {
                    $loadingPop.showPop(opt);
                },
                sucFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    var tpl = temp('attributesTpl', {
                        'attributes': data
                    });
                    $('input[name="price_unit"]').val(data.price);
                    $('.attributes-box').html(tpl);
                },
                errFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $('.text').html(showError(data));
                    $promptPop.showPop(opt);
                }
            });
        }
    });

    $('.choose-type-box').hover(function () {
        $('.choose-type-box').show();
    }, function () {
        $('.choose-type-box').hide();
    });

    var product_param_val = $('input[name="product_param_val"]');
    var product_param_value = $('input[name="product_param_value[]"]');

    $(document).on('keyup', product_param_val, function (e) {
        var id = e.target.dataset.id;
        var name = e.target.dataset.name;
        var value = e.target.value;
        $('.product_param_value' + id).val(id + ',' + name + ',' + value)
    });

    var retail_price = 0,
        engineering_price = 0;

    $(document).on('blur', '.retail-price', function () {
        retail_price = $('.retail-price').val().length;
        engineering_price = $('.engineering-price').val().length;
        price();
    });

    $(document).on('blur', '.engineering-price', function () {
        retail_price = $('.retail-price').val().length;
        engineering_price = $('.engineering-price').val().length;
        price();
    });

    function price() {
        if (retail_price == 0 && engineering_price == 0) {
            $('.retail-price').attr('data-validation', 'number');
            $('.engineering-price').attr('data-validation', 'number');
        } else if (retail_price == 0) {
            $('.retail-price').removeAttr('data-validation', 'number');
            $('.engineering-price').attr('data-validation', 'number');
        } else if (engineering_price == 0) {
            $('.retail-price').attr('data-validation', 'number');
            $('.engineering-price').removeAttr('data-validation', 'number');
        }
    }

    $("#brand_id").keydown(function () {
        if (event.keyCode == 8) {
            $('input[name="brand_id"]').val(0);
        }
    });

    function moreValidate() {
        var error_logo = $('.picture-box-logo .show-item').length;
        var error_product_pictures = $('.picture-box-product_pictures .show-item').length;
        var error_brand = $('input[name="brand_id"]').val();
        retail_price = $('.retail-price').val().length;
        engineering_price = $('.engineering-price').val().length;
        price();
        if (error_brand == 0) {
            $('.error-tip-brand_name').show();
        } else if (error_logo < 1) {
            $('.error-tip-brand_name').hide();
            $('.error-tip-logo').show();
        } else if (error_product_pictures < 1) {
            $('.error-tip-logo').hide();
            $('.error-tip-product_picture').show();
        } else if (parseInt($.params.id) == 0) {
            $('.error-tip-product_picture').hide();
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
                        window.location.href = '/product/index';
                    }
                },
                errFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $('.text').html(showError(data));
                    $promptPop.showPop(opt);
                }
            });
        } else {
            $('.error-tip-product_picture').hide();
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
                        window.location.href = '/product/index';
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


    //上传缩略图
    fileupload({
        acceptFileTypes: ['plain', 'jp*g', 'png', 'gif', 'bmp'],
        dom: $('#addPicture-logo'),
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
                name: 'logo',
                single: true
            });

            $('.add-logo').before(tempFiles);
            $('.add-logo').css('border-color', '#d9d9d9');
            $('.add-logo').hide();

            //图片删除
            $('.picture-box-logo .show-item').on('click', '.delete', function () {
                $(this).parent('.show-item').remove();
                $('.add-logo').show();
            });
        }
    });

    //删除
    $('.picture-box-logo .show-item').on('click', '.delete', function () {
        $(this).parent('.show-item').remove();
        $('.add-logo').show();
    });


    //上传详情页
    fileupload({
        acceptFileTypes: ['plain', 'jp*g', 'png', 'gif', 'bmp'],
        dom: $('#addPicture-product_pictures'),
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
                name: 'product_pictures',
                single: false
            });

            $('.upload-progress').html('');
            $('.add-product_pictures').before(tempFiles);
            $('.add-product_pictures').css('border-color', '#d9d9d9');

            //图片删除
            $('.picture-box-product_pictures .show-item').on('click', '.delete', function () {
                $(this).parent('.show-item').remove();
                $('.add-product_pictures').show();
            });
        }
    });

    //删除
    $('.picture-box-product_pictures .show-item').on('click', '.delete', function () {
        $(this).parent('.show-item').remove();
        $('.add-product_pictures').show();
    });

    //品牌下拉联想
    var autoComplete = new Search({
        keyword: '#brand_id',
        resources: service.getBrandByKeyword
    });

    autoComplete.on('search_box_selected', function (data, event) {
        $("input[name='brand_id']").val(data.item.id);
        renderInfo.call(this, data, event);
    });

    autoComplete.on('search_box_focus', function (data, event) {
        renderInfo.call(this, data, event);
    });

    function renderInfo(data, event) {
        var item = data.item.name;
    }

    //动态参数增加
    $(document).on("click", ".add-parameter", function () {
        var tpl = temp('dynamicTpl', {});
        $('.dynamic-parameter').append(tpl);
    });
    //动态参数删除
    $(document).on("click", ".move-parameter", function () {
        $(this).parent().remove();
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
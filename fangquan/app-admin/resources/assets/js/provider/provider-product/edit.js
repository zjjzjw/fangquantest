$(function () {
    var Popup = require('../../../component/popup');
    var temp = require('../../../component/temp');
    var fileupload = require('../../../component/fileupload');
    var service = require('../../../service/provider/providerProductService');
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
    var $parameter = [];
    //产品属性数据
    var $product_attribute = [];
    $product_attribute.data = $.params.product_category;
    $product_attribute.id = $('select[name="product_category_id"]').find('option:selected').val();
    if ($product_attribute.id) {
        $.each($product_attribute.data, function (k, v) {
            if (v.id == $product_attribute.id) {
                if ($product_attribute.data[k]['attrib']) {
                    $product_attribute.parameter = $product_attribute.data[k]['attrib'];
                    $parameter = $product_attribute.parameter;
                }
                var tpl = temp('attributeList', {
                    'parameter': $parameter,
                });
                $('.attribute-box').html(tpl);
            }
        });
    } else {
        $product_attribute.parameter = [];
    }
    //改变分类——属性变化
    $('select[name="product_category_id"]').change(function () {
        var id = $(this).find('option:selected').val();
        $.each($product_attribute.data, function (k, v) {
            if (v.id == id) {
                if ($product_attribute.data[k]['attrib']) {
                    $product_attribute.parameter = $product_attribute.data[k]['attrib'];
                    $parameter = $product_attribute.parameter;
                }
                var tpl = temp('attributeList', {
                    'parameter': $parameter
                });
                $('.attribute-box').html(tpl);
            }
        });
    });
    function moreValidate() {
        //获得添加的内容
        var attrib_val = [];
        var inpt_attrib = $('input[name="attrib[value][]"]');
        for (var i = 0; i < inpt_attrib.length; i++) {
            attrib_val[i] = inpt_attrib[i].value;
        }
        //替换数据
        var id = $('select[name="product_category_id"]').find('option:selected').val();
        $.each($product_attribute.data, function (k, v) {
            if (v.id == id) {
                var product_attribute_nodes = [];
                if ($product_attribute.data[k]['attrib']) {
                    for (var kn in $product_attribute.data[k]['attrib']) {
                        $.each($product_attribute.data[k]['attrib'][kn]['nodes'], function (kv, vv) {
                            product_attribute_nodes.push($product_attribute.data[k]['attrib'][kn]['nodes'][kv]);
                        });
                    }
                    for (var j = 0; j < attrib_val.length; j++) {
                        product_attribute_nodes[j].value = attrib_val[j];
                    }
                    var attrib = JSON.stringify($parameter);
                    $('input[name="attrib"]').val(attrib);
                }
            }
        });
        var provider_product_images = $('.picture-box-provider_product_images .show-item').length;
        if (provider_product_images < 1) {
            $('.error-tip-provider_product').show();
        } else if (parseInt($.params.id) == 0) {
            $('.error-tip-provider_product').hide();
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
                        window.location.href = '/provider/' + $.params.provider_id + '/provider-product/index';
                    }
                },
                errFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $('.text').html(showError(data));
                    $promptPop.showPop(opt);
                }
            });
        } else {
            $('.error-tip-provider_product').hide();
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
                        window.location.href = '/provider/' + $.params.provider_id + '/provider-product/index';
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
        dom: $('#addPicture-provider_product_images'),
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
                name: 'provider_product_images',
                single: false
            });
            $('.add-provider_product_images').before(tempFiles);
            $('.add-provider_product_images').css('border-color', '#d9d9d9');
            //图片删除
            $('.picture-box-provider_product_images .show-item').on('click', '.delete', function () {
                $(this).parent('.show-item').remove();
                $('.add-provider_product_images').show();
            });
        }
    });
    //删除
    $('.picture-box-provider_product_images .show-item').on('click', '.delete', function () {
        $(this).parent('.show-item').remove();
        $('.add-provider_product_images').show();
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
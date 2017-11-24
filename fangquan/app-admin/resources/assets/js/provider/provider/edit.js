$(function () {
    var Popup = require('../../../component/popup');
    var temp = require('../../../component/temp');
    var fileupload = require('../../../component/fileupload');
    var service = require('../../../service/provider/providerService');
    var Area = require('../../../component/area');
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
    $productPop = new Popup({
        width: 940,
        height: 670,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#productTpl').html()
    });
    //主营产品
    $('.type-click').click(function () {
        var opt = {data: {}};
        $productPop.showPop(opt);
        $('body').css({'overflow': 'hidden'});
    });

    $('.cancel-top').click(function () {
        $productPop.closePop();
        $('body').css({'overflow': 'auto'});
    });
    //全选
    $(".all").click(function () {
        if ($(this).prop('checked')) {
            $(this).next().next().find('input').prop("checked", true);
        } else {
            $(this).next().next().find('input').prop("checked", false);
        }
    });
    //各选
    $(".type-detail").click(function () {
        if ($(this).parent().parent().parent().find('.all').prop('checked')) {
            $(this).parent().parent().parent().find('.all').prop("checked", false);
        }
    });
    //产品勾选值获取
    $('#select-confirm').click(function () {
        obj = $('.type-detail');
        check_id = [];
        check_text = [];
        for (k in obj) {
            if (obj[k].checked) {
                check_id.push($(obj[k]).data('id'));
                check_text.push(obj[k].value);
            }
        }
        $('.type-click').text(check_text);
        $productPop.closePop();
        $('.product_category_ids').val(check_id);
    });
    $(document).on('click', '.dialog_wrap .list .type-detail', function () {
        obj = document.getElementsByName("select");
        var isSelect = 0;
        for (k in obj) {
            if (obj[k].checked) {
                isSelect += 1;
            }
        }
        if (isSelect > 5) {
            $(this).prop("checked", false);
            $('.dialog-footer .error').show();
        } else {
            $('.dialog-footer .error').hide();
        }
    });
    $(document).on('click', '#pop_close', function () {
        $promptPop.closePop();
    });

    function statInputNum(textArea, numItem) {
        var curLength;
        curLength = textArea.val().length;
        numItem.text(curLength);
        textArea.on('input propertychange', function () {
            var _value = $(this).val().replace(/\n/gi, "");
            numItem.text(_value.length);
        });
    }

    // 文本域限制文字数量
    var textarea = $("#summary"),
        textArea = textarea.find("textarea"),
        totalNum = textarea.find(".area");
    statInputNum(textArea, totalNum);

    $.validate({
        form: '#form',
        validateOnBlur: false,
        onSuccess: function ($form) {
            moreValidate();
            return false;
        }
    });

    //保存验证
    function moreValidate() {
        if (parseInt($.params.id) == 0) {
            $('.error-tips').html("");
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
                        window.location.href = '/provider/' + 'provider/edit/' + data.id;
                    }
                },
                errFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $('.text').html(showError(data));
                    $promptPop.showPop(opt);
                }
            });
        } else {
            $('.error-tips').html("");
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
                        window.location.href = '/provider/' + 'provider/edit/' + data.id;
                    }
                },
                errFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $('.text').html(showError(data));
                    $promptPop.showPop(opt);
                }
            });
        }
    };
    //logo上传
    fileupload({
        acceptFileTypes: ['plain', 'jp*g', 'png', 'gif', 'bmp'],
        dom: $('#addPicture-logo'),
        callback: function (result, data) {
            var tempFiles = temp('files_tpl', {
                data: data,
                result: result,
                name: 'logo',
                single: true
            });
            $('.add-logo').before(tempFiles);
            $('.add-logo').css('border-color', '#d9d9d9');
            $('.add-logo').hide();
            //删除
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

    //营业执照上传
    fileupload({
        acceptFileTypes: ['plain', 'jp*g', 'png', 'gif', 'bmp'],
        dom: $('#addPicture-license'),
        callback: function (result, data) {
            result.origin_url = result.origin_url + '?imageView2/2/w/200';
            var tempFiles = temp('files_tpl', {data: data, result: result, name: 'license', single: true});
            $('.add-license').before(tempFiles);
            $('.add-license').css('border-color', '#d9d9d9');
            $('.add-license').hide();
            //删除
            $('.picture-box-license .show-item').on('click', '.delete', function () {
                $(this).parent('.show-item').remove();
                $('.add-license').show();
            });
        }
    });
    //删除
    $('.picture-box-license .show-item').on('click', '.delete', function () {
        $(this).parent('.show-item').remove();
        $('.add-license').show();
    });

    //工厂照片
    fileupload({
        acceptFileTypes: ['plain', 'jp*g', 'png', 'gif', 'bmp'],
        dom: $('#addPicture-provider_factory_image_ids'),
        callback: function (result, data) {
            result.origin_url = result.origin_url + '?imageView2/2/w/200';
            var tempFiles = temp('files_tpl', {
                data: data,
                result: result,
                name: 'provider_factory_image_ids',
                single: false
            });
            $('.add-provider_factory_image_ids').before(tempFiles);
            $('.add-provider_factory_image_ids').css('border-color', '#d9d9d9');

            //删除
            $('.picture-box-provider_factory_image_ids .show-item').on('click', '.delete', function () {
                $(this).parent('.show-item').remove();
                $('.add-provider_factory_image_ids').show();
            });
        }
    });
    //删除
    $('.picture-box-provider_factory_image_ids .show-item').on('click', '.delete', function () {
        $(this).parent('.show-item').remove();
        $('.add-provider_factory_image_ids').show();
    });

    //设备照片
    fileupload({
        acceptFileTypes: ['plain', 'jp*g', 'png', 'gif', 'bmp'],
        dom: $('#addPicture-provider_device_image_ids'),
        callback: function (result, data) {
            result.origin_url = result.origin_url + '?imageView2/2/w/200';
            var tempFiles = temp('files_tpl', {
                data: data,
                result: result,
                name: 'provider_device_image_ids',
                single: false
            });
            $('.add-provider_device_image_ids').before(tempFiles);
            $('.add-provider_device_image_ids').css('border-color', '#d9d9d9');

            //删除
            $('.picture-box-provider_device_image_ids .show-item').on('click', '.delete', function () {
                $(this).parent('.show-item').remove();
                $('.add-provider_device_image_ids').show();
            });
        }
    });

    //删除
    $('.picture-box-provider_device_image_ids .show-item').on('click', '.delete', function () {
        $(this).parent('.show-item').remove();
        $('.add-provider_device_image_ids').show();
    });

    //企业部门架构图-上传图片
    fileupload({
        acceptFileTypes: ['plain', 'jp*g', 'png', 'gif', 'bmp'],
        dom: $('#addPicture-structure'),
        callback: function (result, data) {
            result.origin_url = result.origin_url + '?imageView2/2/w/200';
            var tempFiles = temp('files_tpl', {
                data: data,
                result: result,
                name: 'structure',
                single: true
            });
            $('.add-structure').before(tempFiles);
            $('.add-structure').css('border-color', '#d9d9d9');
            $('.add-structure').hide();

            //删除
            $('.picture-box-structure .show-item').on('click', '.delete', function () {
                $(this).parent('.show-item').remove();
                $('.add-structure').show();
            });
        }
    });

    //删除
    $('.picture-box-structure .show-item').on('click', '.delete', function () {
        $(this).parent('.show-item').remove();
        $('.add-structure').show();
    });

    //企业分支机构架构图-上传图片
    fileupload({
        acceptFileTypes: ['plain', 'jp*g', 'png', 'gif', 'bmp'],
        dom: $('#addPicture-sub_structure'),
        callback: function (result, data) {
            result.origin_url = result.origin_url + '?imageView2/2/w/200';
            var tempFiles = temp('files_tpl', {
                data: data,
                result: result,
                name: 'sub_structure',
                single: true
            });
            $('.add-sub_structure').before(tempFiles);
            $('.add-sub_structure').css('border-color', '#d9d9d9');
            $('.add-sub_structure').hide();

            //删除
            $('.picture-box-sub_structure .show-item').on('click', '.delete', function () {
                $(this).parent('.show-item').remove();
                $('.add-sub_structure').show();
            });
        }
    });

    //删除
    $('.picture-box-sub_structure .show-item').on('click', '.delete', function () {
        $(this).parent('.show-item').remove();
        $('.add-sub_structure').show();
    });

    //经营地址
    var area = new Area({'idNames': ['province_id', 'city_id'], 'data': $.params.areas});
    area.selectedId($.params.province_id, $.params.city_id);
    //生产地址
    var produce_area = new Area({'idNames': ['produce_province_id', 'produce_city_id'], 'data': $.params.areas});
    produce_area.selectedId($.params.produce_province_id, $.params.produce_city_id);

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
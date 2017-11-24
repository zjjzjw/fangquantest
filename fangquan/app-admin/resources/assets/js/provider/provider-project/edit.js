$(function () {
    var Popup = require('../../../component/popup');
    var temp = require('../../../component/temp');
    var Area = require('../../../component/area');
    var fileupload = require('../../../component/fileupload');
    var service = require('../../../service/provider/providerProjectService');
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

    //地址删选
    var area = new Area({'idNames': ['province_id', 'city_id'], 'data': $.params.areas});
    area.selectedId($.params.province_id, $.params.city_id);

    //时间筛选
    var myDate = new Date();
    $('.date').datetimepicker({
        timepicker: false,
        format: 'Y-m-d H:i:s',
        formatTime: 'H:i:s',
        formatDate: 'Y/m/d',
        closeOnDateSelect: true,
        scrollInput: false,
        lang: 'zh',
        maxDate: myDate.toLocaleString()//当前日期
    });

    $.validate({
        form: '#form',
        validateOnBlur: false,
        onSuccess: function ($form) {
            moreValidate();
            return false;
        }
    });

    function moreValidate() {
        var provider_project_pictures = $('.picture-box-provider_project_pictures .show-item').length;
        if (provider_project_pictures < 1) {
            $('.error-tip-imageId').show();
        } else if (parseInt($.params.id) == 0) {
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
                        window.location.href = '/provider/' + $.params.provider_id + '/provider-project/index';
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
                        window.location.href = '/provider/' + $.params.provider_id + '/provider-project/index';
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
        dom: $('#addPicture-provider_project_pictures'),
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
                name: 'provider_project_pictures',
                single: false
            });

            $('.add-provider_project_pictures').before(tempFiles);
            $('.add-provider_project_pictures').css('border-color', '#d9d9d9');

            //图片删除
            $('.picture-box-provider_project_pictures .show-item').on('click', '.delete', function () {
                $(this).parent('.show-item').remove();
                $('.add-provider_project_pictures').show();
            });
        }
    });

    //删除
    $('.picture-box-provider_project_pictures .show-item').on('click', '.delete', function () {
        $(this).parent('.show-item').remove();
        $('.add-provider_project_pictures').show();
    });

    //供应产品-添加
    $(document).on('click', '.add-product', function () {
        var html = temp('provider_product_tpl', {});
        $('.suppl-products').append(html);
        $.validate({
            form: '#form',
            validateOnBlur: false,
            onSuccess: function ($form) {
                moreValidate();
                return false;
            }
        });
    });

    $(document).on('click', '.del-product', function () {
        $(this).parent('.product-value').remove();
    });

    $(document).on('keyup', 'input[name="provider_project_products[num][]"]', function () {
        var pattern = /\D/g;
        var str = $(this).val();
        var date = str.replace(pattern, '');
        $(this).val(date);
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
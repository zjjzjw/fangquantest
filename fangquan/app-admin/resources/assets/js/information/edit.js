$(function () {
    var Popup = require('../../component/popup');
    var temp = require('../../component/temp');
    var Search = require('../../component/search');
    var fileupload = require('../../component/fileupload');
    var service = require('../../service/information/informationService');

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


    var ue = UE.getEditor('container');
    ue.ready(function () {
        ue.execCommand('serverparam', '_token', '');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
    });


    //发布时间
    $('.date').datetimepicker({
        timepicker: false,
        format: 'Y-m-d H:i:s',
        formatTime: 'H:i:s',
        formatDate: 'Y/m/d',
        closeOnDateSelect: true,
        scrollInput: false,
        lang: 'zh'
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
        //关键词判断
        var information_themes = [];
        $('input[name="information_themes[]"]:checked').each(function () {
            information_themes.push($(this).val());
        });
        $('#information_themes').val(information_themes);

        //是否发布
        var is_publish = $('input[name="is_publish"]:checked').length;
        var status = $('input[name="status"]:checked').length;
        //正文判断
        var iframe_box = ue.getContent();

        if (is_publish < 1) {
            $('.error-tip-is_publish').show();
        } else if (status < 1) {
            $('.error-tip-status').show();
            $('.error-tip-is_publish').hide();
        } else if (information_themes == '') {
            $('.error-tip-category').show();
            $('.error-tip-status').hide();
        } else if (iframe_box == "") {
            $('.error-tip-category').hide();
            $('.error-tip-content').show();

        } else if (parseInt($.params.id) == 0) {
            $('.error-tip-content').hide();
            var opt = {data: {}};
            service.store({
                data: $('#form').serialize(),
                params: $.params,
                beforeSend: function () {
                    $loadingPop.showPop(opt)
                },
                sucFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $successPop.showPop(opt);
                    setTimeout(skipStore, 2000);

                    function skipStore() {
                        $successPop.closePop();
                        window.location.href = '/information/index';
                    }
                },
                errFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $('.text').html(showError(data));
                    $promptPop.showPop(opt);
                }
            });
        } else {
            $('.error-tip-category').hide();
            $('.error-tip-content').hide();
            var opt = {data: {}};
            service.update({
                data: $('#form').serialize(),
                params: $.params,
                beforeSend: function () {
                    $loadingPop.showPop(opt)
                },
                sucFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $successPop.showPop(opt);
                    setTimeout(skipUpdate, 2000);

                    function skipUpdate() {
                        $successPop.closePop();
                        window.location.href = '/information/edit/' + data.id;
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

    //图片转换
    $('.conversion').click(function () {
        var data_id;
        var opt = {data: {}};
        data_id = $(this).data('id');
        service.processImage({
            data: {id: data_id},
            beforeSend: function () {
                $loadingPop.showPop(opt)
            },
            sucFn: function (data, status, xhr) {
                $loadingPop.closePop();
                $successPop.showPop(opt);
                setTimeout(skipUpdate, 2000);

                function skipUpdate() {
                    $successPop.closePop();
                    window.location.href = '/information/edit/' + data.id;
                }
            },
            errFn: function (data, status, xhr) {
                $loadingPop.closePop();
                $('.text').html(showError(data));
                $promptPop.showPop(opt);
            }
        });
    });

    //上传缩略图
    fileupload({
        acceptFileTypes: ['plain', 'jp*g', 'png', 'gif', 'bmp'],
        dom: $('#addPicture-thumbnail'),
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
                name: 'thumbnail',
                single: true
            });

            $('.add-thumbnail').before(tempFiles);
            $('.add-thumbnail').css('border-color', '#d9d9d9');

            $('.add-thumbnail').hide();

            //图片删除
            $('.picture-box-thumbnail .show-item').on('click', '.delete', function () {
                $(this).parent('.show-item').remove();
                $('.add-thumbnail').show();
            });
        }
    });
    //图片删除
    $('.picture-box-thumbnail .show-item').on('click', '.delete', function () {
        $(this).parent('.show-item').remove();
        $('.add-thumbnail').show();
    });

    $(document).on('click', '#pop_close', function () {
        $promptPop.closePop();
    });

    //关联品牌增加
    $(document).on("click", ".add-brand", function () {
        var $information_brand = $.params.information_brand;
        var tpl = temp('brandTpl', {});
        $('.product-brand').append(tpl);
    });

    //产品品牌下拉联想
    var autoComplete = new Search({
        keyword: '#keyword',
        resources: service.getBrandByKeyword
    });


    autoComplete.on('search_box_selected', function (data, event) {
        renderInfo.call(this, data, event);
    });

    autoComplete.on('search_box_focus', function (data, event) {
        renderInfo.call(this, data, event);
    });

    function renderInfo(data, event) {
        var item = data.item;
    }

    $(document).on("click", ".brand-input", function () {
        var that = this;
        var autoComplete = new Search({
            keyword: '.brand-input',
            resources: service.getBrandByKeyword
        });

        autoComplete.on('search_box_selected', function (data, event) {
            renderInfo.call(this, data, event);
        });

        autoComplete.on('search_box_focus', function (data, event) {
            renderInfo.call(this, data, event);
        });

        function renderInfo(data, event) {
            var item = data.item;
            $(that).parent().find('#brand_id').val(item.id);

        }
    });

    //关联品牌删除
    $(document).on("click", ".close-brand", function () {
        $(this).parent().remove();
    });

    //产品型号下拉联想
    var autoComplete = new Search({
        keyword: '#model-keyword',
        resources: service.getProductByKeyword
    });


    autoComplete.on('search_box_selected', function (data, event) {
        $("input[name='product_id']").val(data.item.id);
        renderInfo.call(this, data, event);
    });

    autoComplete.on('search_box_focus', function (data, event) {
        renderInfo.call(this, data, event);
    });

    function renderInfo(data, event) {
        var item = data.item.name;
    }

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
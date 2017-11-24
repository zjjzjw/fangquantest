$(function () {
    var Popup = require('../../../component/popup');
    var temp = require('../../../component/temp');
    var fileupload = require('../../../component/fileupload');
    var service = require('../../../service/product/productCategoryService');
    var index;
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
    //添加产品参数
    $productAttributePop = new Popup({
        width: 600,
        height: 450,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#productAttributeTpl').html()
    });
    //编辑产品参数
    $editParamPop = new Popup({
        width: 280,
        height: 210,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#editTpl').html()
    });
    //产品属性
    $(document).on('click', '.product-attribute', function (event) {
        var opt = {data: {}};
        $productAttributePop.showPop(opt);
        $('.category-name').val('');
        $('.param-list').html('');
        $('.param-name').val('');
        $('body').css({'overflow': 'hidden'});
    });
    $('.cancel-top').click(function () {
        $productAttributePop.closePop();
        $('body').css({'overflow': 'auto'});
    });
    $('.cancel').click(function () {
        $productAttributePop.closePop();
        $('body').css({'overflow': 'auto'});
    });

    $(document).on('click', '.add-btn', function () {
        var paramName = $('.param-name').val();
        index = $('.product-attribute-list').find('p').length;
        var paramItem = '<li>' +
            '<span>' + paramName + '</span>' +
            '<em class="delete">x</em><i class="iconfont edit-icon">&#xe626;</i>' +
            '<input type="hidden" name="product[category-param' + index + '][param-name][]" value=" ' + $('.param-name').val() + '">' +
            '<input type="hidden" name="product[category-param' + index + '][param-key][]" value="' + generateUUID() + '">' +
            '</li>';
        if (paramName != '') {
            $(paramItem).appendTo(".param-list");
            $('.param-name').val('');
        } else {
            $('.add-btn').show();
        }
    });
    $(document).on('click', '.param-list .delete', function () {
        $(this).parent().remove();
    });

    $(document).on('click', '.add-param-btn', function () {
        if ($('.category-name').val() == '') {
            $('.error-tip').html('请填写分类名称！');
        } else if ($('.param-list li').length < 1) {
            $('.error-tip').html('请添加参数！');
        } else {
            var addHtml = $('.param-list').html();
            var addParamHtml = '<p class="' + $('.category-name').val() + '"><span>'
                + $('.category-name').val() + '</span>' +
                '<em class="delete-parent">:&nbsp;&nbsp;x</em>' +
                '<i data-index="' + index + '" class="iconfont edit-icon">&#xe626;</i>' +
                '<i data-index="' + index + '" class="iconfont add-icon">&#xe602;</i></p>' +
                '<input type="hidden" name="" value="">' +
                '<input type="hidden" name="product[category-param-name][]" value="' + $('.category-name').val() + '" >' +
                '<input type="hidden" name="product[category-param-key][]" value="' + generateUUID() + '">';
            $(addParamHtml).appendTo(".product-attribute-list");
            $(addHtml).appendTo(".product-attribute-list");
            $productAttributePop.closePop();
        }
    });


    $(document).on('click', '.product-attribute-list .delete-parent', function () {
        var sameCategory = $(this).parent().attr('class');
        $(this).parent().next().next().remove();
        $(this).parent().next().remove();
        $(this).parent().remove();
        $("li").each(function () {
            if ($(this).attr('class') == sameCategory) {
                $(this).remove();
            }
        });
    });

    $(document).on('click', '.product-attribute-list .delete', function () {
        $(this).parent().remove();
    });

    //编辑参数
    $(document).on('click', '.product-attribute-list .edit-icon', function () {
        $('.error-tip').html("");
        $('.change-title').html("修改");
        var opt = {data: {}};
        $editParamPop.showPop(opt);
        var editName = $(this).parent().attr('class');
        $(this).parent().addClass("edit-param");
        var changeVlue = $(this).parent().find('span').html();
        $('.change-name').val(changeVlue);
        if ($(this).parent('p').length > 0) {
            $('.change-name').addClass('change-parent-type');
            $('.change-type').val(changeVlue);
        }
    });

    //添加参数
    $(document).on('click', '.product-attribute-list .add-icon', function () {
        $('.error-tip').html("");
        $('.change-name').val('');
        index = $(this).data('index');
        var opt = {data: {}};
        var appendClassName = $(this).parent().attr('class');
        $editParamPop.showPop(opt);
        $('.change-title').html("添加");
        $('.change-name').addClass("add-name");
        $('.class-name').val(appendClassName);
    });

    $(document).on('click', '.comfirm-edit-btn', function () {
        var editParam = $('.change-name').val();
        var addAppendClass = $('.class-name').val();
        if ($('.change-name').hasClass("add-name")) {
            var addParam = $('.add-name').val();
            var addClassName = $('.class-name').val();
            if (addParam != '') {
                $editParamPop.closePop();
                var addParamItem = '<li class="' + addAppendClass +
                    '"><span>' + addParam + '</span>' +
                    '<em class="delete">x</em><i class="iconfont edit-icon">&#xe626;</i>' +
                    '<input type="hidden" name="product[category-param' + index + '][param-name][]" value=" ' + addParam + '">' +
                    '<input type="hidden" name="product[category-param' + index + '][param-key][]" value="' + generateUUID() + '">' +
                    '</li>';

                $("p").each(function () {
                    if ($(this).attr('class') == addClassName) {
                        $(this).next().next().after(addParamItem);
                    }
                });
                $('.change-name').removeClass("add-name");
            } else {
                $('.error-tip').html("添加内容不能为空！");
            }
        } else {
            if (editParam != '') {
                $editParamPop.closePop();
                var oldParentType = $('.change-type').val();
                if ($('.change-name').hasClass('change-parent-type')) {
                    $("li").each(function () {
                        if ($(this).hasClass(oldParentType)) {
                            $(this).addClass(editParam);
                            $(this).removeClass(oldParentType);
                        }
                    });
                }
                $('.edit-param span').html(editParam);
                $('.edit-param').removeClass(oldParentType);
                $('.edit-param input').first().val(editParam);
                $('.edit-param').removeClass("edit-param");
            } else {
                $('.error-tip').html("修改内容不能为空！");
            }
        }
    });
    $(document).on('click', '.edit-cancel-btn', function () {
        $editParamPop.closePop();
    });

    $(document).on('click', '#pop_close', function () {
        $promptPop.closePop();
    });
    //保存验证
    $(document).on('click', '.save', function () {
        var nameVal = $('.name').val(),
            sortVal = $('input[name="sort"]').val();
        if (nameVal == "") {
            $('.error-tips').html("请输入分类名称");
        } else if (sortVal == '') {
            $('.error-tips').html("请输入排序");
        } else if (parseInt($.params.id) == 0) {
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
                        window.location.href = '/product/product-category/index';
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
                        window.location.href = '/product/product-category/index';
                    }
                },
                errFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $('.text').html(showError(data));
                    $promptPop.showPop(opt);
                }
            });
        }
    });

    //上传logo
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

            $('.upload-progress').html('');
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

    function generateUUID() {
        var d = new Date().getTime();
        var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            var r = (d + Math.random() * 16) % 16 | 0;
            d = Math.floor(d / 16);
            return (c == 'x' ? r : (r & 0x3 | 0x8)).toString(16);
        });
        return uuid;
    }
});
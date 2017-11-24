define([
    'zepto',
    'zepto.temp',
    'page.params',
    'backbone',
    'validate',
    'ui.popup',
    'app/service/project/aimService'
], function ($, temp, params, Backbone, mvalidate, Popup, service) {
    'use strict';

    var Edit = function () {
        var self = this;
        //权限
        self.limitPop = new Popup({
            width: 250,
            height: 150,
            content: $('#limitTpl').html()
        });
        self.loadingPop = new Popup({
            content: $('#loadingTpl').html()
        });
        self.bindEvent();
    };

    Edit.prototype.bindEvent = function () {
        var self = this;
        $('.add-product').on('click', function () {
            $('.edit-content').hide();
            $('.add-box').show();
            //$('.default-value').prop('selected', true);
            $('.product-number').val('');
            $('.product-price').val('');

        });

        $('.add-product-btn').on('click', function () {
            $('.edit-content').hide();
            $('.add-box').show();
            //$('.default-value').prop('checked', true);
            $('.product-number').val('');
            $('.product-price').val('');
        });

        $('.close-back').on('click',function(){
            $('.add-box').hide();
            $('.edit-content').show();
        });

        $('.add-save-btn').on('click', function () {
            var product_id = $('option:checked').val(),
                product_name = $('option:checked').data('name'),
                product_number = $('.product-number').val(),
                product_price = $('.product-price').val(),
                reg = /^[0-9]+(.[0-9]{1,3})?$/;
                console.log(product_number);
                console.log(product_price);
            if (product_id == "") {
                $('.id-description').html("请选择产品");
            }
            else if (!reg.test(product_number)) {
                $('.id-description').html("");
                $('.number-description').html("请输入数量，格式为整数");
            } else if (!reg.test(product_price)) {
                $('.id-description').html("");
                $('.number-description').html("");
                $('.price-description').html("请输入价格，格式为整数");
            } else {
                var result = {
                    product_id: product_id,
                    name: product_name,
                    num: product_number,
                    price: product_price
                };
                var html = temp('product_tpl', {result: result});
                $('.add-box .error-tip').html("");
                $('.add-box').hide();
                $('.edit-content').show();
                $('.product-detail').hide();
                $('.product-list-box').show();
                $('.product-list-box-items').append(html);
                $('#productname-description').html('');

                if ($('.box-item').length >= 6) {
                    $('.add-product-btn').hide();
                } else {
                    $('.add-product-btn').show();
                }
            }
        });

        $(document).on('click', '.del-parameter-btn', function () {
            $(this).parent().parent('.box-item').remove();
            if ($('.box-item').length < 1) {
                $('.product-detail').show();
                $('.product-list-box').hide();
            } else {
                $('.add-product-btn').show();
            }
        });
        $('#form_creat').mvalidate({
            type: 2,
            onKeyup: true,
            sendForm: false,
            firstInvalidFocus: true,
            valid: function (event, options) {
                self.loadingPop.showPop();
                service.storeProjectAim(
                    {
                        data: $('#form_creat').serialize(),
                        sucFn: function (data, status, xhr) {
                            self.loadingPop.closePop();
                            window.location.href = '/project/' + params.project_id + '/aim/list';
                        },
                        errFn: function (data, xhr, errorType, error) {
                            var message = showError(data);
                            $('.hint-content').empty().html(message);
                            self.loadingPop.closePop();
                            self.limitPop.showPop();
                        }
                    }
                );

                event.preventDefault();
            },
            invalid: function (event, status, options) {
                //点击提交按钮时,表单未通过验证触发函数
            },
            eachField: function (event, status, options) {
                //点击提交按钮时,表单每个输入域触发这个函数 this 执向当前表单输入域，是jquery对象
            },
            eachValidField: function (val) {
            },
            eachInvalidField: function (event, status, options) {
            },
            conditional: {
                confirmlength: function () {
                    if ($('.box-item').length > 0) {
                        return true;
                    }
                }
            },
            descriptions: {
                name: {
                    required: '请输入目标名称',
                    valid: '',
                },
                pain: {
                    required: '请输入痛点分析',
                    valid: '',
                },
                productname: {
                    conditional: '产品必选, 最多6个',
                    valid: '',
                }
            }
        });
        $('.limit-close').on('click', function () {
            self.limitPop.closePop();
            $('.hint-content').empty();
        });
    };
    new Edit();
    //权限信息数据处理
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

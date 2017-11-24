define([
    'zepto',
    'zepto.temp',
    'page.params',
    'ui.popup',
    'validate',
    'app/service/contractService'
], function ($, temp, params, Popup, mvalidate, service) {
    var Edit = function () {
        var self = this;
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
            $('.product-number').val('');
            $('.product-price').val('');

        });

        $('.add-product-btn').on('click', function () {
            $('.edit-content').hide();
            $('.add-box').show();
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

            if (product_id == "") {
                $('.id-description').html("请选择产品");
            }
            else if (!reg.test(product_number)) {
                $('.id-description').html("");
                $('.number-description').html("请输入数量，格式为整数");
            } else if (!reg.test(product_price)) {
                $('.id-description').html("");
                $('.number-description').html("");
                $('.price-description').html("请输入产品单价，格式为整数");
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
                //点击提交按钮时，表单通过验证触发函数
                self.loadingPop.showPop();
                service.storeContract({
                    data: $('#form_creat').serialize(),
                    sucFn: function (data, status, xhr) {
                        self.loadingPop.closePop();
                        window.location.href = '/contract/individual/list';
                    },
                    errFn: function (xhr, errorType, error) {
                        var message = showError(xhr);
                        $('.hint-content').empty().html(message);
                        self.loadingPop.closePop();
                        self.limitPop.showPop();
                    }
                });
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
                contractnumber: {
                    required: '请输入合同编号',
                    valid: '',
                },
                contractname: {
                    required: '请输入合同名称',
                    valid: '',
                },
                signed: {
                    required: '请选择合同签订日期',
                    valid: '',
                },
                customer: {
                    required: '请选择客户名称',
                    valid: '',
                },
                contractamount: {
                    required: '请输入合同金额',
                    pattern: '请输入整数',
                    valid: '',
                },
                downpayment: {
                    required: '请输入首付款',
                    pattern: '请输入整数',
                    valid: '',
                },
                receivedpaymentst: {
                    required: '请选择预计回款日期',
                    valid: '',
                },
                partner: {
                    required: '请输入尾款金额',
                    pattern: '请输入整数',
                    valid: '',
                },
                tailamount: {
                    required: '请选择尾款到账日期',
                    valid: '',
                },
                deliverydate: {
                    required: '请选择产品交付日期',
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

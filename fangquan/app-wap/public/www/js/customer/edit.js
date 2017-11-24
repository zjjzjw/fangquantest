define([
    'zepto',
    'page.params',
    'backbone',
    'ui.popup',
    'validate',
    'app/component/area',
    'app/service/customerService'
], function ($, params, Backbone, Popup, mvalidate, Area, service) {
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
        self.init();
        self.bindEvent();
    };

    Edit.prototype.bindEvent = function () {
        var self = this;

        //表单验证
        $('#form_creat').mvalidate({
            type: 2,
            onKeyup: true,
            sendForm: false,
            firstInvalidFocus: true,
            valid: function (event, options) {
                //点击提交按钮时, 表单通过验证触发函数
                self.loadingPop.showPop();
                service.storeCustomer(
                    {
                        data: $('#form_creat').serialize(),
                        sucFn: function (data, status, xhr) {
                            self.loadingPop.closePop();
                            //跳转到我的项目列表
                            window.location.href = '/customer/individual/list';
                        },
                        errFn: function (xhr, errorType, error) {
                            var message = showError(xhr);
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
            descriptions: {
                company: {
                    required: '请输入客户名称',
                    valid: '',
                },
                province: {
                    required: '请输入总部所在地',
                    valid: '',
                },
                city: {
                    required: '请输入项目所在地',
                    valid: '',
                },
                contacts: {
                    required: '请输入联系人',
                    valid: '',
                },
                station: {
                    required: '请输入职位',
                    valid: '',
                },
                telephone: {
                    required: '请输入联系方式',
                    pattern: '手机格式不正确',
                    valid: '',
                },
                num: {
                    required: '请输入项目数量',
                    pattern: '请输入整数',
                    valid: '',
                },
                project_num: {
                    required: '请输入建设中项目数量',
                    pattern: '请输入整数',
                    valid: '',
                },
                potential: {
                    required: '请输入潜量',
                    pattern: '请输入整数',
                    valid: '',
                },
                record: {
                    required: '请输入开发记录',
                    pattern: '请输入整数',
                    valid: '',
                },
                brand: {
                    required: '请输入品牌',
                    pattern: '请输入整数',
                    valid: '',
                },
                time: {
                    required: '请输入签约时间',
                    valid: '',
                },
                level: {
                    required: '请选择客户等级',
                    valid: '',
                }
            }
        });
        $('.limit-close').on('click', function () {
            self.limitPop.closePop();
            $('.hint-content').empty();
        });
    };

    Edit.prototype.init = function () {

        var self = this;
        //输出数据
        var area = new Area({idNames: ['#province_id', '#city_id'], data: params.areas});
        area.selectedId(params.province_id, params.city_id);
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

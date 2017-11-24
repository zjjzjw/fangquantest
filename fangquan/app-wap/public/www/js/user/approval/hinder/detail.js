define(['zepto', 'validate', 'app/service/project/aimService'], function ($, mvalidate, service) {
        var Detail = function () {
            var self = this;
            self.init();
            self.bindEvent();
        };

        Detail.prototype.bindEvent = function () {
            var self = this;

            $('#form_creat').mvalidate({
                type: 2,
                onKeyup: true,
                sendForm: false,
                firstInvalidFocus: true,
                valid: function (event, options) {
                    service.aimHinderAudit(
                        {
                            data: $('#form_creat').serialize(),
                            sucFn: function (data, status, xhr) {
                                window.location.href = '/user/approval/hinder/list';
                            },
                            errFn: function (xhr, errorType, error) {
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
                    result: {
                        required: '请选择审核结果',
                        valid: '',
                    }
                }
            });
        };
        Detail.prototype.init = function () {
            var self = this;
        };
        new Detail();
    }
);

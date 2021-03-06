define([
    'zepto',
    'validate'
], function ($, mvalidate, service) {
    var Login = function () {
        var self = this;
        self.bindEvent();
    };
    Login.prototype.bindEvent = function () {
        var self = this;
        $('#form').mvalidate({
            type: 2,
            onKeyup: true,
            sendForm: true,
            firstInvalidFocus: true,
            valid: function (event, options) {
                //点击提交按钮时，表单通过验证触发函数
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
                phone: {
                    required: '请输入手机号',
                    pattern: '手机号码格式不正确',
                    valid: '',
                },
                password: {
                    required: '请输入密码',
                    pattern: '密码不正确',
                    valid: '',
                }
            }
        })
    };
    new Login();
});

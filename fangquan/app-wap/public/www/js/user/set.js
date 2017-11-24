define(['zepto', 'backbone', 'validate', 'app/service/userService'
], function ($, Backbone, mvalidate, service) {
    'use strict';

    var Edit = function () {
        var self = this;
        self.bindEvent();
    };

    Edit.prototype.bindEvent = function () {
        var self = this;
        $('.change-password').on('click', function () {
            $('.set-box').hide();
            $('.title').html('修改密码');
            $('.password-box').show();
            $('.suc-tip').hide();
        });
        $('.about-us').on('click', function () {
            $('.set-box').hide();
            $('.title').html('关于');
            $('.about-box').show();
        });
        $('#form_creat').mvalidate({
            type: 2,
            onKeyup: true,
            sendForm: false,
            firstInvalidFocus: true,
            valid: function (event, options) {
                $('.hint-content').empty();
                service.modifyPassword(
                    {
                        data: $('#form_creat').serialize(),
                        sucFn: function (data, status, xhr) {
                            $('#form_creat').hide();
                            $('.suc-tip').show();
                            setTimeout(function () {
                                window.location.href = '/auth/login';
                            }, 2000);
                        },
                        errFn: function (data, xhr, errorType, error) {
                            var message = showError(data);
                            $('.hint-content').empty().html(message);
                        }
                    }
                );
                event.preventDefault();
            },
            invalid: function (event, status, options) {
                $('.hint-content').empty();
            },
            eachField: function (event, status, options) {
                //点击提交按钮时,表单每个输入域触发这个函数 this 执向当前表单输入域，是jquery对象
            },
            eachValidField: function (val) {
            },
            eachInvalidField: function (event, status, options) {
            },
            descriptions: {
                oldPassword: {
                    required: '请输入旧密码',
                    pattern: '请输入6－12位密码，包含数字或字母',
                    valid: '',
                },
                newPassword: {
                    required: '请输入新密码',
                    pattern: '请输入6－12位密码，包含数字或字母',
                    valid: '',
                }

            }
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

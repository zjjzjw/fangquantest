define([
    'zepto',
    'ui.popup',
    'validate',
    'app/service/userService',
    'page.params'
], function ($, Popup, mvalidate, service, params) {
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
        $('#form_creat').mvalidate({
            type: 2,
            onKeyup: true,
            sendForm: false,
            firstInvalidFocus: true,
            valid: function (event, options) {
                //点击提交按钮时，表单通过验证触发函数
                self.loadingPop.showPop();
                service.signTaskStore({
                    data: $('#form_creat').serialize(),
                    sucFn: function (data, status, xhr) {
                        self.loadingPop.closePop();
                        window.location.href = '/user/sign-task/list/' + params.user_id;
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
            descriptions: {
                time: {
                    required: '请选择签单任务时间',
                    valid: '',
                },
                amount: {
                    required: '请输入签单任务金额',
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
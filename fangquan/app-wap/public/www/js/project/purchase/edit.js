define(['zepto', 'page.params', 'backbone', 'ui.popup', 'validate', 'app/service/project/purchaseService'
], function ($, params, Backbone, Popup, mvalidate, service) {
    'use strict';

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
                self.loadingPop.showPop();
                service.storeProjectPurchase(
                    {
                        data: $('#form_creat').serialize(),
                        sucFn: function (data, status, xhr) {
                            self.loadingPop.closePop();
                            window.location.href = '/project/' + params.project_id + '/flow/list';
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
                name: {
                    required: '请输入名称',
                    valid: '',
                },
                member: {
                    required: '请输入人员',
                    valid: '',
                },
                time: {
                    required: '请输入时间',
                    valid: '',
                },
                event: {
                    required: '请输入事件',
                    valid: '',
                }
            }
        });
        $('.limit-close').on('click',function(){
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

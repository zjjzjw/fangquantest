define(['zepto', 'backbone', 'ui.popup', 'app/service/userService'
], function ($, Backbone, Popup, service) {
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

        $('.save-btn').on('click', function () {
            if ($('.text').val() === "") {
                $('.error-tip').html("请输入反馈内容");
            } else {
                $('.error-tip').html('');
                self.loadingPop.showPop();
                service.storeUserFeedback({
                    data: $('#opinion').serialize(),
                    sucFn: function () {
                        self.loadingPop.closePop();
                        window.location.href = '/user/list';
                    },
                    errFn: function (data) {
                        var message = showError(data);
                        $('.hint-content').empty().html(message);
                        self.loadingPop.closePop();
                        self.limitPop.showPop();
                    }
                });
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

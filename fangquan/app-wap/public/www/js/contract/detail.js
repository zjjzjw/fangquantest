define(['zepto', 'page.params', 'backbone', 'ui.popup', 'app/service/contractService'
], function ($, params, Backbone, Popup, service) {
    'use strict';

    var Detail = function () {
        var self = this;
        //删除
        self.deletePop = new Popup({
            width: 270,
            height: 180,
            content: $('#deleteTpl').html()
        });
        self.limitPop = new Popup({
            width: 250,
            height: 150,
            content: $('#limitTpl').html()
        });
        self.init();
        self.bindEvent();
    };

    Detail.prototype.bindEvent = function () {
        var self = this;
        $('.delete-btn').on('click', function () {
            self.deletePop.showPop();
        });
        $('.close-btn').on('click', function () {
            self.deletePop.closePop();
        });
        $('.edit-box .btn-cancel').on('click', function () {
            self.deletePop.closePop();
        });
        $('.edit-box .btn-ok').on('click', function () {
            service.contractDetailDelete(
                {
                    data: {id: params.id},
                    sucFn: function () {
                        window.location.href = '/contract/list/';
                    },
                    errFn: function (data) {
                        var message = showError(data);
                        self.deletePop.closePop();
                        $('.hint-content').empty().html(message);
                        self.limitPop.showPop();
                    }
                }
            );
        });
        $('.limit-close').on('click',function(){
            self.limitPop.closePop();
            $('.hint-content').empty();
        });
    };
    Detail.prototype.init = function () {
        var self = this;
        $('.com-back').attr("href", "/contract/list");
    };
    new Detail();
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

define(['zepto', 'page.params', 'backbone', 'ui.popup', 'app/service/cardService'
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
        self.init();
        self.bindEvent();
    };

    Detail.prototype.bindEvent = function () {
        var self = this;
        $('.delete-btn').on('click', function () {
            self.deletePop.showPop();
        });

        $('.edit-box .close-btn').on('click', function () {
            self.deletePop.closePop();
        });
        //名片详情删除
        $('.edit-box .btn-ok').on('click', function () {
            service.cardDelete(
                {
                    data: {
                        id: params.id
                    },
                    sucFn: function () {
                        window.location.href = '/user/card/list';
                    },
                    errFn: function () {
                    }
                }
            );
        });

        $('.edit-box .btn-cancel').on('click', function () {
            self.deletePop.closePop();
        });
    };


    Detail.prototype.init = function () {
        var self = this;
        $('.com-back').attr("href", "/user/card/list");
    };
    new Detail();
});

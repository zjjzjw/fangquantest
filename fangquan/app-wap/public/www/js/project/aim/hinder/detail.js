define(['zepto', 'page.params', 'backbone', 'ui.popup','app/service/project/aimService'
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
        $('.close-btn').on('click', function () {
            self.deletePop.closePop();
        });

        //目标障碍删除
        $('.edit-box .btn-ok').on('click', function () {
            service.aimHinderDelete(
                {
                    data: { aim_id: params.aim_id,
                            id: params.id},
                    sucFn: function () {
                        window.location.href = '/project/' + params.project_id + '/aim/' + params.aim_id + '/hinder/list';
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
    };
    new Detail();
});

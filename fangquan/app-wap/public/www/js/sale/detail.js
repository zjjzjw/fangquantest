define(['zepto', 'page.params', 'backbone', 'ui.popup', 'app/service/saleService'
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
        $('.assign-lines').on('click', function () {
            $('.principal-content').show();
            $('.detail-content').hide();
        });

        $('.assign-back').on('click', function () {
            $('.principal-content').hide();
            $('.detail-content').show();
        });

        $('.name').on('click', function () {
            if ($(this).children().hasClass('item-show')) {
                $(this).children().removeClass('item-show');
                $(this).next().hide();
            } else {
                $(this).children().addClass('item-show');
                $(this).next().show();
            }
        });

        $('.principal-btn').on('click', function () {
            service.saleAssignUser(
                {
                    data: $('#assign_form').serialize(),
                    sucFn: function (data, status, xhr) {
                        window.location.reload();
                    },
                    errFn: function (xhr, errorType, error) {
                        var message = showError(xhr);
                        self.deletePop.closePop();
                        $('.hint-content').empty().html(message);
                        self.limitPop.showPop();
                    }
                }
            );
        });


        $('.claim-btn').on('click', function () {
            service.saleClaim(
                {
                    data: $('#claim_form').serialize(),
                    sucFn: function (data, status, xhr) {
                        window.location.reload();
                    },
                    errFn: function (xhr, errorType, error) {
                    }
                }
            );
        });
        //销售线索详情删除
        $('.edit-box .btn-ok').on('click', function () {
            service.saleDetailDelete(
                {
                    data: {id: params.id},
                    sucFn: function () {
                        window.location.href = '/sale/list';
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
        $('.limit-close').on('click', function () {
            self.limitPop.closePop();
            $('.hint-content').empty();
        });
    };


    Detail.prototype.init = function () {
        var self = this;

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

define([
    'zepto',
    'ui.popup',
    'app/service/saleService'
], function ($, Popup, service) {
    var Detail = function () {
        var self = this;
        self.limitPop = new Popup({
            width: 250,
            height: 150,
            content: $('#limitTpl').html()
        });
        self.init();
    };

    Detail.prototype.init = function () {
        var self = this;
        $('.adopt').on('click', function () {
            var id = $("input[name='id']").val();
            service.saleAudit({
                data: {id: id, status: 3},
                sucFn: function () {
                    window.location.href = '/user/approval/sale/list/';
                },
                errFn: function (data) {
                    var message = showError(data);
                    $('.hint-content').empty().html(message);
                    self.limitPop.showPop();
                }
            })
        });

        $('.reject').on('click', function () {
            var id = $("input[name='id']").val();
            service.saleAudit({
                data: {id: id, status: 1},
                sucFn: function () {
                    window.location.href = '/user/approval/sale/list/';
                },
                errFn: function (data) {
                    var message = showError(data);
                    $('.hint-content').empty().html(message);
                    self.limitPop.showPop();
                }
            })
        });

        $('.limit-close').on('click', function () {
            self.limitPop.closePop();
            $('.hint-content').empty();
        });
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
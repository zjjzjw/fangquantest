define(['zepto', 'page.params', 'backbone', 'ui.popup', 'app/service/project/structureService'
], function ($, params, Backbone, Popup, service) {
    'use strict';


    var Flow = function () {
        var self = this;
        //编辑 or 删除
        self.editPop = new Popup({
            width: 270,
            height: 230,
            contentBg: '#e9e9e9',
            maskOpacity: '.3',
            content: $('#editTpl').html()
        });
        //权限
        self.limitPop = new Popup({
            width: 250,
            height: 150,
            content: $('#limitTpl').html()
        });
        self.init();
        self.bindEvent();
    };

    Flow.prototype.bindEvent = function () {
        var self = this;
        $('.func-btn').on('click', function (e) {
            var $target = $(e.currentTarget);
            var id = $target.data('id');
            var parent_id = $target.data('parent_id');
            var addUri = '/project/' + params.project_id + '/structure/edit/' + id + '/0';
            var detailUri = '/project/' + params.project_id + '/structure/detail/' + id;
            $('.add').attr('href', addUri);
            $('.detail').attr('href', detailUri);
            $('.delete').attr('data-nodeid', id);
            self.editPop.showPop();
        });

        $('.close-btn').on('click', function () {
            self.editPop.closePop();
        });
        //组织架构节点删除
        $('.delete').on('click', function () {
            var targetId = $(this).attr('data-nodeid');
            service.structureDetailDelete(
                {
                    data: {id: targetId},
                    sucFn: function () {
                        window.location.href = '/project/' + params.project_id + '/structure/flow/';
                    },
                    errFn: function (data) {
                        var message = showError(data);
                        self.editPop.closePop();
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
    Flow.prototype.init = function () {

        var self = this;
        $("#org").structure({
            chartElement: '#chart',
        });
        $('.com-back').attr("href", "/project/detail/" + params.project_id);
    };
    new Flow();
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

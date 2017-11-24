define([
    'zepto',
    'page.params',
    'zepto.sp',
    'app/exhibition/developer-project/ui/ui.commonlist'
], function ($, params, sp, commonlist) {
    'use strict';

    var List = function () {

        var self = this;
        self.pageInfo = params.pageInfo;//分页
        self.status = [0, 0, 0, 0];
        self.mask = $('.mask');
        self.init();
        self.bindEvent();
    };

    List.prototype.bindEvent = function () {
        var self = this;
        //分页
        sp.subscribe('waterfall_succ', function (data) {
            var qs = location.search,
                reg = /page=(\d+)/,
                result,
                page = data.current_page;

            if (!qs) {
                result = qs + '?page=' + self.pageInfo.current_page;
            } else if (reg.exec(qs) === null) {
                result = qs + '&page=' + self.pageInfo.current_page;
            } else {
                result = qs.replace(reg, 'page=' + self.pageInfo.current_page);
            }
        });
        self.waterfall = commonlist();
    };

    List.prototype.init = function () {
        var self = this;

    };
    new List();
});
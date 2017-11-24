define([
    'zepto',
    'page.params'
], function ($, params) {
    var CommonList = function () {
        var self = this;
        self.init();
    };
    CommonList.prototype.init = function () {
        var self = this;
        $('.com-back').attr("href", "/project/" + params.project_id + "/analyse/detail");
    };
    new CommonList();
});

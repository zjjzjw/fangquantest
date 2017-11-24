define([
    'zepto', 'page.params'
], function ($, params) {
    var Main = function () {
        var self = this;
        self.init();
    };
    Main.prototype.init = function () {
        var self = this;
        $('.com-back').attr("href", "/project/detail/" + params.project_id);
    };
    new Main();
});
define(['zepto', 'page.params', 'backbone',
    'ui.autocomplete', 'zepto.sp',
    'app/service/saleService',
    'app/sale/ui/ui.commonlist'], function ($, params, Backbone,
                                            autocomplete, sp,
                                            service, commonlist) {
    'use strict';


    var List = function () {
        var self = this;
        self.pageInfo = params.pageInfo;//分页
        self.$searchIpt = $('.search-btn');//搜索
        self.SearchlistUrl = params.listUrl;

        self.$pageHeader = $('.page-header');
        self.$autoWrap = $('#auto_wrap');
        self.auto = new autocomplete({
            resources: service.getSaleListByKeyword
        });
        self.status = [0, 0, 0, 0];
        self.mask = $('.mask');

        self.init();
        self.bindEvent();
    };

    List.prototype.bindEvent = function () {
        var self = this;
        //所有&我的切换
        $('.choose-title').on('click', function () {
            $('.pull-down').removeClass('pull-down').addClass('arrow-up');
            $('.choose-items').show();
        });
        //筛选
        $('.parentup').on('click', function () {
            if ($(this).hasClass('high')) {
                $('.parentup').removeClass('high');
                $('.g-touchicon-l').addClass('revolve');
                $('#dialog').hide();
                $('.optionlist').hide();
            } else {
                $('.parentup').removeClass('high');
                $('.g-touchicon-l').addClass('revolve');
                $(this).addClass('high');
                $(this).next().removeClass('revolve');
                $(this).next().next().show();
                $('#dialog').show();
                $('.optionlist').show();
                //区分筛选条件
                var type = $(this).data('type');
                $('.menunav-info').eq(type).show().siblings().hide();
                $('.close-info').on('click',function(){
                    $('#closeInfo').show();
                });
                $('.principal').on('click',function(){
                    $('#principal').show();
                });
                $('.phase').on('click',function(){
                    $('#phase').show();
                });
            }
        });
        //点击灰色区域隐藏浮层
        $('#dialog').on('click', function () {
            $('.parentup').removeClass('high');
            $('.g-touchicon-l').addClass('revolve');
            $('.optionlist').hide();
            $(this).hide();
        });

        //所在地一级二级处理
        $('.region-item a').on('click', function () {
            var province_id;
            if ($(this).attr("href") == '#') {
                province_id = $(this).data('id');
                $('.city-info').hide();
                $('#blockinfo-' + province_id).show();
                return false;
            }
            return true;
        });
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
        //搜索自动匹配
        self.$searchIpt.on('click', function (e) {
            $('.page').css('background-color', '#fff');
            $('.all-box').hide();
            e.preventDefault();
            self.$autoWrap.prevAll().hide();
            self.$autoWrap.show();
            self.$pageHeader.hide();
            self.auto.setInputVal(self.$searchIpt.text() == '');
            self.waterfall && self.waterfall.stop().hideMoreBtn();
            self.status.indexOf(1) != -1 ? self.mask.hide() : '';
            self.auto.focus();
        });

        sp.subscribe('search_canceled', function () {
            self.$autoWrap.prevAll().show();
            $('#common_list_tpl').hide();
            self.$pageHeader.show();
            self.$autoWrap.hide(100);
            $('.all-box').show();
            self.waterfall && self.waterfall.start().hideMoreBtn();
            self.status.indexOf(1) != -1 ? self.mask.show() : '';

        });

        sp.subscribe('autocomplete_entered', function (data) {
            self.auto.clearAutoIpt();
            var href = window.location.href;
            //得到url
            var url = $.utils.replaceQueryString(href, {'keyword': data});
            window.location.href = url;
        });


        $('#search_btn').on('click', function () {
            var keyWord = $('#auto_ipt').val();
            var href = window.location.href;
            //得到url
            var url = $.utils.replaceQueryString(href, {'keyword': keyWord});
            window.location.href = url;
        });

        sp.subscribe('value_changed', function (data) {
            self.auto.clearAutoIpt();
            var url = '/sale/detail/' + data.id;
            window.location.href = url;
        });
        $('.com-back').attr("href", "/home");
    };
    new List();
});

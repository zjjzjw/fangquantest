define(['zepto', 'page.params',
        'backbone',
        'ui.autocomplete', 'zepto.sp',
        'app/service/project/aimService',
        'app/user/approval/sale/ui/ui.commonlist'
    ], function ($, params, Backbone,
                 autocomplete, sp,
                 service, commonlist) {

        var List = function () {
            var self = this;
            self.pageInfo = params.pageInfo;//分页

            self.$searchIpt = $('.search-btn');//搜索
            self.SearchlistUrl = params.listUrl;

            self.$pageHeader = $('.page-header');
            self.$autoWrap = $('#auto_wrap');

            self.status = [0, 0, 0, 0];
            self.mask = $('.mask');

            self.init();
            self.bindEvent();
        };

        List.prototype.bindEvent = function () {
            var self = this;

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
                    $(this).find('.g-touchicon-l').removeClass('revolve');
                    $('#dialog').show();
                    $('.optionlist').show();
                    //区分筛选条件
                    var type = $(this).data('type');
                    $('.menunav-info').eq(type).show().siblings().hide();
                }
            });
            //点击灰色区域隐藏浮层
            $('#dialog').on('click', function () {
                $('.parentup').removeClass('high');
                $('.g-touchicon-l').addClass('revolve');
                $('.optionlist').hide();
                $(this).hide();
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
        };
        new List();
    }
);

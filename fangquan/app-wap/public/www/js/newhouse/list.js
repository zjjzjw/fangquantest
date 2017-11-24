define(['zepto', 'page.params', 'backbone',
    'ui.autocomplete','ui.iscroll','zepto.sp',
    'app/service/commissionService',
    'ui.commonlist'], function($, params, Backbone,
        autocomplete,Iscroll,sp,
        service,commonlist) {
    'use strict';
    var Search = function(){
        var self = this;
        self.filterSections = $('.list-filter > a');
        self.mask = $('.mask');
        self.filter_list = $('.filter-detail > div');
        self.filter_cur = 0;
        self.filter_pre = 0;
        self.block_cur = 0;
        self.block_pre = 0;
        self.arrow = $('.filter-arrow');
        self.areas = $('.area-left');
        self.areasLinks = $('.area-left a');
        self.blocks = $('.block');
        self.myIscroll = [];
        self.iscrollPos = [];
        self.contentBox = $('.property-list');
        self.$searchIpt = $('#search_house');
        self.$autoWrap = $('#auto_wrap');
        self.$pageHeader = $('.page-header');
        self.pageInfo = params.pageInfo;
        self.$cancle = $('#search_house_cancle');
        self.status = [0, 0, 0, 0];
        self.SearchlistUrl = params.listUrl;
        self.nearby = $('#area-right-0');

        self.auto = new autocomplete({
            resources: service.getCommunityList
        });

        self.init();
        self.bindEvent();

    };

    Search.prototype.bindEvent = function(){
        var self = this,
            filtertTopPos = $('.list-filter').offset().top; // cache the top

        $(window).on('resize', function() {
            self.setArrowPos(self.arrow, self.filter_cur);
        });

        self.filterSections.on('click', function(e) {
            var visibleTopPos = document.body.scrollTop;

            if (filtertTopPos > visibleTopPos) {
                window.scrollTo(0, filtertTopPos);
            }

            self.filter_cur = self.filterSections.indexOf(this);
            if (self.filter_cur !== 0 || (self.filter_cur === 0 && self.block_cur === 0)) {
                self.arrow.removeClass('arr-gray-bg');
            } else {
                self.arrow.addClass('arr-gray-bg');
            }

            if (self.filter_pre == self.filter_cur) {
                if (self.status[self.filter_cur]) {
                    self.filter_list.eq(self.filter_cur).hide();
                    self.status[self.filter_cur] = 0;
                    $('i', self.filterSections.eq(self.filter_cur)).removeClass('filter-icon-rotate');
                    self.arrow.hide();
                } else {
                    self.filter_list.eq(self.filter_cur).show();
                    self.status[self.filter_cur] = 1;
                    $('i', self.filterSections.eq(self.filter_cur)).addClass('filter-icon-rotate');

                    self.setArrowPos(self.arrow, self.filter_cur);
                    self.arrow.show();
                }
            } else {
                self.filter_list.eq(self.filter_pre).hide();
                self.status[self.filter_pre] = 0;
                $('i', self.filterSections.eq(self.filter_pre)).removeClass('filter-icon-rotate');

                self.filter_list.eq(self.filter_cur).show();
                self.status[self.filter_cur] = 1;
                $('i', self.filterSections.eq(self.filter_cur)).addClass('filter-icon-rotate');

                self.setArrowPos(self.arrow, self.filter_cur);
                self.arrow.show();
            }

            if (self.filter_cur === 0) {
                if (self.myIscroll[0] === undefined) {
                    self.createIscroll(0, '#wrapper-0');
                    self.createIscroll(1, '#wrapper-1');

                    self.setPosition(0, self.getPosY(0, 'cur-bg'));
                    self.setPosition(1, self.getPosY(1, 'cur-item'));
                }
            } else {
                if (self.myIscroll[self.filter_cur + 1] === undefined) {
                    self.createIscroll(self.filter_cur + 1, '#wrapper-' + (self.filter_cur + 1));
                    self.setPosition(self.filter_cur + 1, self.getPosY(self.filter_cur + 1, 'cur-item'));
                }
            }

            self.filter_pre = self.filter_cur;
            self.isShowPanel();
        });

        self.areas.on('click', function(e) {
            e = e ? e : window.event;
            var target = e.srcElement ? e.srcElement : e.target;
            self.block_cur = self.areasLinks.indexOf(target);

            if (self.block_cur == 0) {
                self.arrow.removeClass('arr-gray-bg');
            } else {
                self.arrow.addClass('arr-gray-bg');
            }

            if (self.block_pre == self.block_cur) {
                return;
            }

            self.blocks.eq(self.block_pre).hide();
            self.areasLinks.eq(self.block_pre).removeClass('cur-bg');
            self.blocks.eq(self.block_cur).show();
            self.areasLinks.eq(self.block_cur).addClass('cur-bg');

            self.myIscroll[1].refresh();

            self.block_pre = self.block_cur;
        });

        sp.subscribe('waterfall_succ', function(data) {
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
            //history.replaceState(null, '', result);
        });

        self.mask.on('touchstart', function() {
            self.status[self.filter_cur] = 0;
            self.filter_list.eq(self.filter_cur).hide();
            $('i', self.filterSections.eq(self.filter_cur)).removeClass('filter-icon-rotate');

            self.arrow.hide();
            self.mask.hide();
        });
        self.waterfall = commonlist();
        self.nearby.on('click', function(e) {
                e.preventDefault();
                var $tipOutter, $errTip, lat, lng;
                /*if (!self.isNearbyAvailable) {
                    return;
                }*/
                self.getGeolocation(function(_geoInfo) {
                    /*if(_geoInfo == 'PERMISSION_DENIED') {
                        self.isNearbyAvailable = false;
                    }*/
                    if (!_geoInfo || (_geoInfo == 'PERMISSION_DENIED') || (_geoInfo == 'POSITION_UNAVAILABLE') || (_geoInfo == 'TIMEOUT')) {
                        $tipOutter = $('section.tip-outter');
                        $errTip = $('div.err-tip');
                        //浏览器不支持定位功能 | 用户拒绝获取位置信息|获取位置信息超时，后续点击附近按键不会再有响应，除非刷新页面
                        $tipOutter.addClass('tip-outter-show');
                        $errTip.addClass('tip-show');
                        setTimeout(function() {
                            $tipOutter.removeClass('tip-outter-show');
                            $errTip.removeClass('tip-show');
                        }, 1500);
                        return;
                    }
                    lat = _geoInfo.latitude;
                    lng = _geoInfo.longitude;

                    location.href = $(e.target).attr('data-url') + "&lng=" + lng + "&lat=" + lat;
                    return;
                });
            });
    };
    Search.prototype.init = function() {
        var self = this;
        $('a', self.areas).each(function(index) {
                if ($(this).hasClass('cur-bg')) {
                    self.block_pre = index;
                    self.block_cur = index;
                    return false;
                }
            });
        /* autocomplete */
            self.$searchIpt.on('click', function(e) {
                $('.page').css('background-color','#fff');
                e.preventDefault();
                self.$autoWrap.prevAll().hide();
                self.$autoWrap.show();
                self.$pageHeader.hide();
                self.auto.setInputVal(self.$searchIpt.text() == '');
                self.waterfall && self.waterfall.stop().hideMoreBtn();
                self.status.indexOf(1) != -1 ? self.mask.hide() : '';
                self.auto.focus();
            });

            sp.subscribe('search_canceled', function() {
                self.$autoWrap.prevAll().show();
                $('#common_list_tpl').hide();
                self.$pageHeader.show();
                self.$autoWrap.hide(100);
                self.waterfall && self.waterfall.start().hideMoreBtn();
                self.status.indexOf(1) != -1 ? self.mask.show() : '';
            });

            sp.subscribe('value_changed', function(data) {
                self.auto.clearAutoIpt();
                window.location.href = self.SearchlistUrl + '?loupan_id=' + data.id + '&loupan_id_name=' + data.name;
            });

            sp.subscribe('autocomplete_entered', function(data) {
                self.auto.clearAutoIpt();
                window.location.href = self.SearchlistUrl + '?keyword=' + data;
            });

            self.$cancle.on('click', function() {
                window.location.href = self.SearchlistUrl;
            });
    };
    Search.prototype.createIscroll = function(index, id) {
        var self = this;
        if (self.myIscroll[index] == undefined) {
            self.myIscroll[index] = new Iscroll({
                $ele: id
            });
        }
    };
    Search.prototype.getPosY = function(index, className) {
        var self = this;

        if (self.iscrollPos[index] === undefined) {
            var target = $('.' + className, '#wrapper-' + index);
            return target.length ? target.position().top : 0;
        }
        return 0;
    };
    Search.prototype.setPosition = function(index, posY) {
        var self = this;

        var dis = Math.abs(posY) - 244;
        dis > 0 ? self.myIscroll[index].scroll(-dis) : '';
    };
    Search.prototype.setArrowPos = function(ele, n) {
        var pos = $(window).width() / 8 * (2 * n + 1) - ele.width() / 2;
        ele.css('left', pos / 10 + 'rem');
    };
    Search.prototype.getGeolocation = function(callBack) {
        //判断浏览器是否支持定位功能
        if (!window.navigator.geolocation) {
            callBack(0);
            return;
        }
        var _posParams = {
            maximumAge: 30000,
            timeout: 10000
        };
        navigator.geolocation.getCurrentPosition(getPosSuc, getPosErr, _posParams);

        function getPosSuc(pos) {
            callBack(pos.coords);
        }

        function getPosErr(error) {
            switch (error.code) {
                case error.TIMEOUT:
                    callBack('TIMEOUT'); //连接超时，请重试
                    break;
                case error.PERMISSION_DENIED:
                    callBack('PERMISSION_DENIED'); //您拒绝了使用位置共享服务，查询已取消
                    break;

                case error.POSITION_UNAVAILABLE:
                    callBack('POSITION_UNAVAILABLE'); //暂时无法为您所在的星球提供位置服务
                    break;
            }
        }
    };
    Search.prototype.isShowPanel = function() {
            var self = this;
            for (var i = 0; i < self.status.length; i++) {
                if (self.status[i]) {
                    self.mask.show();
                    self.contentBox.addClass('event-inactive');
                    /*self.mask.on('touchstart', function(e){
                       e.preventDefault();
                    });*/
                    return;
                }
            }

            self.mask.hide();
            self.contentBox.removeClass('event-inactive');
        };
    //懒加载
    $('.lazy').lazyload({
        effect: "fadeIn"
    });
     $.trackEvent({
                    action: 'PC_CLICK'
                });
     new Search();
});
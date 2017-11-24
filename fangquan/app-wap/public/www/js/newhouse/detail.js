/* jshint undef: false, unused: false, camelcase: false, expr: true, eqeqeq: false */
define(['zepto', 'zepto.temp', 'zepto.sp', 'page.params', 'ui.swipe','ui.popup','app/service/userService'],
    function($, temp, sp, params, swipe, Popup, service) {
        'use strict';

        var Page = function(op) {
            var self = this;

            self._op = $.extend({}, {
                loupanImages: params.loupanImages || [],
                HouseImages: params.HouseImages || [],
                property_id: params.property_id,
                lng: params.lng,
                lat: params.lat,
            }, op);

            self.scrollTop = 0;
            // swipe
            self.$swipeBox = $('#swipe_box');
            self.$canvasBox = $('#canvas_box');
            self.$swipeImgTpl = $('#swipe_img_tpl');
            self.popSwipe = null; // 页面弹出的swipe
            self.imagesCount = Number(self._op.loupanImages.length);
            //map
            self.$map = $('#map');
            self.$mapImg = $('#map>img');
            //订阅
            self.descPop = new Popup({
                width: 270,
                height: 240,
                content: $('#subscriptTpl').html()
            });
            //订阅成功
            self.successPop = new Popup({
                width: 270,
                height: 240,
                content: $('#successTpl').html()
            });

            self.isLogin = false;
            self.isCollect = params.isCollect;
            self.init();
            self.initSlider();
        };

        Page.prototype.init = function() {
            var self = this,
                tipEle = $('#errorInfo'),
                reg = /^1\d{10}$/,
                phoneEle = $('.tel-num'),
                sendBtn = $(".send-code-num"),
                timer = null;
            var subParams = {};
            var loginType = "";
            //订阅
            $('.subscribe-btn').click(function (e) {
                var $target = $(e.currentTarget);
                self.subParams = {
                    'loupan_id': $target.data('id'),
                    'subscribe_type': $target.data('type'),
                    'title': $target.data('title'),
                    'subTitle':$target.data('subtitle')
                };
                $('.reg-title').text(self.subParams.title);
                $('.tips').text(self.subParams.subTitle);

                if(self.isLogin) {
                    self.subscribeNotice();
                } else {
                    service.islogin({
                        sucFn: function() {
                            self.isLogin = true;
                            self.subscribeNotice();
                        },
                         errFn: function(){
                            self.isLogin = false;
                            loginType = "subscribe";
                            self.loginFn();
                        }
                    });
                }
                
            });

            //收藏
            $('.collect-box').click(function() {
                if(self.isLogin) {
                    self.isCollect ? self.cancleCollectLoupan() : self.collectLoupan();
                } else {
                    service.islogin({
                        sucFn: function() {
                            self.isLogin = true;
                            self.isCollect ? self.cancleCollectLoupan() : self.collectLoupan();
                        },
                         errFn: function(){
                            self.isLogin = false;
                            loginType = "collect";
                            self.loginFn();
                        }
                    });
                }
            });

            //获取验证码可用
            phoneEle.keyup(function() {
                 tipEle.html('');
                 var val = $(this).val();
                 if (val.length === 11) {
                     $('.send-code-num').addClass('add-color');
                 }else{
                    $('.send-code-num').removeClass('add-color');
                 }
             });
            //下发短信验证码
            sendBtn.on('click', function() {
                var telEle = $('.tel-num').val();
                if(telEle === ''){
                    tipEle.html("手机号码不能为空");
                }else if(!reg.test(telEle)) {
                    tipEle.html("请输入正确手机号");
                }else{
                    service.code({
                        data: {
                            phone: $('.tel-num').val()
                        },
                        sucFn: function() {
                            timerDown();
                        },
                        errFn: function(oData) {
                            tipEle.html(oData.msg);
                        }
                    });
                }
            });
            //短信验证码倒计时
            function timerDown() {
                tipEle.html('');
                $('.add').addClass("menceng");
                $('.send-code-num').css("color","#919192");
                var num = 60,
                    str;
                str = num + 's后重发';
                sendBtn.html(str);
                timer = setInterval(function () {
                    num--;
                    str = num + 's后重发';
                    sendBtn.html(str);
                    if (num <= 0) {
                        timer && clearInterval(timer);
                        $('.send-code-num').css("color","#f15f00");
                        sendBtn.html('获取验证码');
                        $('.add').removeClass("menceng");
                    }
                }, 1000);
            }
            $('.close-subscript').on('click',function(){
                self.descPop.closePop();
                tipEle.html('');
                $('#code-num').val('');
                timer && clearInterval(timer);
                sendBtn.html("发送验证码");
                $('.add').removeClass("menceng");
            });


            $('#box-btn').on('click', function(){
                service.login({
                    data: {
                        'phone': $('.tel-num').val(),
                        'phone_code': $('#code-num').val()
                    },
                    successCb: function(oData){
                        self.isLogin = true;
                        switch(loginType) {
                            case "subscribe":
                                self.subscribeNotice();
                                break;
                            case "collect":
                                self.isCollect ? self.cancleCollectLoupan() : self.collectLoupan();
                                break;
                            default:
                                break;
                        } 
                    },
                    errorCb: function(oData){
                        self.isLogin = false;
                        tipEle.html(oData.msg);
                    }
                });
            });
            $('.suc-btn').on('click',function(){
                self.successPop.closePop();
            })

            // 更多信息
            $('.look-more').on('click', function(e) {
                $.trackEvent({
                    action: 'TW_NEWHOUSE_MOREINFO'
                });
                $('.look-more').hide();
                $('.more-info').show();
            });

            //户型展开收起
            if($('.house-type-box li').length > 0){
                var typeNum = document.getElementById("house_type").getElementsByTagName("li").length;
                $('.look-more-type').on('click', function(){
                    $('.hx-item').show();
                    $('.look-more-type').hide();
                    $('.arrow-up').show();
                });
                $('.arrow-up').on('click',function(){
                    for(var i=0;i<typeNum;i++){
                        if(i > 2){
                            $('.hx-item').eq(i).hide();
                        }
                    }
                    $('.arrow-up').hide();
                    $('.look-more-type').show();
                });
            }

            //最新动态展开
            var $commDesc = $('.comm-desc em');
            var $openCommDesc = $('.open-comm-desc');
            var commDescStr = [];
            self.commDescStr = $commDesc.text();
            if($('.comm-desc em').length > 0){
                if(document.body.clientWidth<375){
                if (self.commDescStr.length > 41) {
                    $commDesc.text(self.commDescStr.substring(0, 36) + '...');
                }
            }else if(document.body.clientWidth<414){
                if (self.commDescStr.length > 46) {
                    $commDesc.text(self.commDescStr.substring(0, 42) + '...');
                }
            }else{
                if (self.commDescStr.length > 51) {
                    $commDesc.text(self.commDescStr.substring(0, 48) + '...');
                }
            }
            }
            $openCommDesc.show();
            $openCommDesc.click(function() {
                $commDesc.text(self.commDescStr);
                $openCommDesc.hide();
            });

            $('.tel-box').on('click', function(){
                $.trackEvent({
                    action: 'TW_NEWHOUSE_400PHONE'
                });
            });
            $('.sale-item').on('click', function(){
                $.trackEvent({
                    action: 'TW_NEWHOUSE_HOTHOUSE'
                });
            });
            $('.phone-link').on('click', function(){
                $.trackEvent({
                    action: 'TW_NEWHOUSE_BOPHONE'
                });
            });
            $('.down-link').on('click', function(){
                $.trackEvent({
                    action: 'TW_NEWHOUSE_BODOWLOAD'
                });
            });
            //订阅log
            $('.privilege-btn').on('click', function(){
                $.trackEvent({
                    action: 'TW_NEWHOUSE_PRIVILEGE'
                });
            });
            $('.look-btn').on('click', function(){
                $.trackEvent({
                    action: 'TW_NEWHOUSE_SEEHOUSE'
                });
            });
            $('.price-change').on('click', function(){
                $.trackEvent({
                    action: 'TW_NEWHOUSE_CHANGEPRICE'
                });
            });
            $('.dongtai-btn').on('click', function(){
                $.trackEvent({
                    action: 'TW_NEWHOUSE_NEWS'
                });
            });
            $('.bottom-btn').on('click', function(){
                $.trackEvent({
                    action: 'TW_NEWHOUSE_LOWPRICE'
                });
            });
            $('.server-bianjia').on('click', function(){
                $.trackEvent({
                    action: 'TW_NEWHOUSE_ACHANGEPRICE'
                });
            });
            $('.server-dijia').on('click', function(){
                $.trackEvent({
                    action: 'TW_NEWHOUSE_ALOWPRICE'
                });
            });
            $('.server-yuyue').on('click', function(){
                $.trackEvent({
                    action: 'TW_NEWHOUSE_LOWPRICE'
                });
            });

            // resize
            $(window).resize(function(e) {
                if ($('#canvas_box').css('display') != 'none') {
                    self.hidePage();
                }
                self.popSwipe = null;
            });
        };

        Page.prototype.loginFn = function(data){
            this.descPop.showPop();
            $('#code-num').val('');
            $('.send-code-num').html('获取验证码');
        }

        Page.prototype.subscribeNotice = function() {
            var self = this;

            service.subscribe({
                data: {
                    'phone': $('.tel-num').val(),
                    'phone_code': $('#code-num').val(),
                    'loupan_id' : params.loupanId,
                    'subscribe_type': self.subParams.subscribe_type,
                },
                sucFn: function(oData) {
                    $('.suc-title').text(self.subParams.subTitle);
                    self.descPop.closePop();
                    self.successPop.showPop();
                },
                errFn: function(oData) {
                    $('#errorInfo').html(oData.msg);
                }
            });
        }
        //收藏
        Page.prototype.collectLoupan = function() {
            var self = this;

            service.collect({
                id: params.loupanId,
                data: {
                    'new_house_id': params.loupanId
                },
                success: function() {
                    self.isCollect = !self.isCollect;
                    $('.collect-box span').text(self.isCollect ? "已收藏" : "收藏");
                    $('.collect-box .collect-icon').html(self.isCollect ? "&#xe60f;" : "&#xe643;");
                    self.descPop.closePop();

                    $.trackEvent({
                        action: 'TW_NEWHOUSE_COLLECT'
                    });
                },
                error: function() {
                    $('#errorInfo').html(oData.msg);
                }
            });
        }

        //取消收藏
        Page.prototype.cancleCollectLoupan = function() {
            var self = this;

            service.cancleCollect({
                id: params.loupanId,
                data: {
                    'new_house_id': params.loupanId
                },
                success: function() {
                    self.isCollect = !self.isCollect;
                    $('.collect-box span').text(self.isCollect ? "已收藏" : "收藏");
                    $('.collect-box .collect-icon').html(self.isCollect ? "&#xe60f;" : "&#xe643;");
                    self.descPop.closePop();
                },
                error: function() {
                    $('#errorInfo').html(oData.msg);
                }
            });
        }

        Page.prototype.initSlider = function() {
            var self = this;
            if (self._op.loupanImages.length > 0) {
                self.$swipeBox.show();
                self.suitablePic();
                self.loupanImages = self.getUrls(self._op.loupanImages);

                // 初始化 页面的 swipe
                var tepl = temp('swipe_img_tpl', {
                    'loupanImages': self.loupanImages,
                });

                var expandTepl = temp('swipe_expand_img_tpl', {
                    'loupanImages': self.loupanImages,
                })

                // 初始化swipe
                sp.subscribe('swipe_setup', function(data) {
                    self.changeSwipe(data);
                });

                sp.subscribe('swipe_moveend', function(data) {
                    self.changeSwipe(data);
                });

                sp.subscribe('swipe_movestart', function(data) {
                    //self.changeSwipe(data);
                });

                sp.subscribe('swipe_slideto', function(data) {
                    self.changeSwipe(data);
                });

                self.$swipeBox.html(tepl);
                self.$canvasBox.html(expandTepl);
                // cache item
                self.pageItem = self.$swipeBox.find('img');
                self.popItem = self.$canvasBox.find('img');
                // 初始化页面的slider
                self.pageSwipe = swipe(self.$swipeBox[0], {
                    continuous: self.imagesCount > 2 ? true : false
                });
                self.$swipeNav = self.$swipeBox.find('i'); // 获得所有的nav

                self.$swipeBox.on('click', ['.item'], function() {
                    var cIndex = self.pageSwipe.getPos();

                    self.hidePage();
                    self.$canvasBox.show();
                    if (self.popSwipe == null) { // jshint ignore:line
                        self.popSwipe = swipe(self.$canvasBox[0], {
                            startSlide: cIndex || 0,
                            continuous: self.imagesCount > 2 ? true : false
                        });
                        self.$canvasNav = self.$canvasBox.find('i');
                    } else {
                        self.popSwipe.slide(cIndex);
                    }
                });

                self.$canvasBox.on('click', function(e) {
                        $(this).hide();
                        self.showPage();
                });
            }
        };

        Page.prototype.hidePage = function() {
            this.scrollTop = $(window).scrollTop();
            $('.page').css({
                height: document.body.clientHeight, // document.body.clientHeight
                overflow: 'hidden'
            });
        };

        Page.prototype.showPage = function() {
            $('.page').css({
                height: 'auto'
            });
            $(window).scrollTop(this.scrollTop);

        };

        Page.prototype.getUrls = function(arr) {
            var self = this;
            var rArr = [];

            for (var i = 0, l = arr.length; i < l; i++) {
                arr[i].url = arr[i].url + '-' + self.pWidth + 'x' + self.pHeight;
                rArr.push(arr[i]);
            }

            return rArr;
        };

        Page.prototype.dealError = function(data) {
            if (data.redirect) {
                window.location.href = data.redirect;
            }
        };

        Page.prototype.changeSwipe = function(data) {
            var self = this,
                i = data.index,
                item, itemNext, itemPrev,
                dSrc, dNextSrc, dPrevSrc;

            if ($(data.wrap).is('#swipe_box')) {
                item = self.pageItem.eq(i);
                itemNext = self.pageItem.eq(i + 1);
                itemPrev = self.pageItem.eq(i - 1);
                var $span = self.$swipeBox.find('.image-type-index span');
                $span.eq(0).text(Number(data.index + 1) + '/' + self.loupanImages.length);


            } else if ($(data.wrap).is('#canvas_box')) {
                item = self.popItem.eq(i);
                itemNext = self.popItem.eq(i + 1);
                itemPrev = self.popItem.eq(i - 1);
                var $popSpan = self.$canvasBox.find('.image-type-index-pop span');
                var $imageTypeSpan = self.$canvasBox.find('.image-type-wrap span');
                var image = self.loupanImages[data.index];
                $popSpan.text(Number(data.index + 1) + '/' + self.loupanImages.length);
                $imageTypeSpan.text(image.name);
            }

            dSrc = item.data('swipe');
            dNextSrc = itemNext.data('swipe');
            dPrevSrc = itemPrev.data('swipe');

            if (dSrc) {
                item.attr('src', dSrc);
                item.data('swipe', '');
            }

            if (dNextSrc) {
                itemNext.attr('src', dNextSrc);
                itemNext.data('swipe', '');
            }

            if (dPrevSrc) {
                itemPrev.attr('src', dPrevSrc);
                itemPrev.data('swipe', '');
            }

        };

        Page.prototype.suitablePic = function() {
            var w = $('body').width();
            var r = window.devicePixelRatio;
            var self = this;
            w = w * r;

           if (w <= 750) {
                self.pWidth = 720;
                self.pHeight = 540;
            } else {
                self.pWidth = 1000;
                self.pHeight = 750;
            }
        };
        new Page();
    });
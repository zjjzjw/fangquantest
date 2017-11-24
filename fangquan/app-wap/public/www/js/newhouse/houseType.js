define(['zepto', 'zepto.temp', 'zepto.sp', 'page.params', 'ui.swipe'],
    function($, temp, sp, params, swipe) {
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
            self.$swipeImgTpl = $('#swipe_img_tpl');logServer
            self.popSwipe = null; // 页面弹出的swipe
            self.imagesCount = Number(self._op.loupanImages.length);

            self.init();
            self.initSlider();
        };

        Page.prototype.init = function() {
            var self = this;

            // resize
            $(window).resize(function(e) {
                if ($('#canvas_box').css('display') != 'none') {
                    self.hidePage();
                }
                self.popSwipe = null;
            });
        };

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
/**
 * Created by cuizhuochen on 1/8/15.
 */
define('ui.commonlist', ['zepto', 'ui.waterfall', 'app/service/commissionService', 'zepto.temp', 'page.params', 'app/modules/ui/ui.lazyload'],
    function ($, Waterfall, service, temp, params) {
        'use strict';

        var contentWrap, pageInfo, waterfallInstance = null;

        contentWrap = $('.property-list');

        function init() {
            pageInfo = params.pageInfo;
            if (pageInfo) {
                waterfallInstance = new Waterfall({
                    resources: service.getpageList,
                    onLoad: function (data) {
                        if (data && !data.code) {
                            var propertyStr = $(temp('common_list_tpl', {'names': data.items}));
                            propertyStr.find('img').lazyload({
                                effect: "fadeIn"
                            });
                            contentWrap.append(propertyStr);
                        }
                    },
                    continueWhile: function (data) {
                        return data.current_page < data.last_page ? false : true;
                    },
                    data: pageInfo,
                    wrap: '.property-list',
                    eventDom: $(window)
                });
            }

            return waterfallInstance;
        }

        (function bindEvent() {
            contentWrap.on('click', '.list-item', function (e) {
                e.preventDefault();
                var href = $('a', e.currentTarget).attr('href');
                location.href = href;
            });

            //懒加载
            $('.property-list .lazy').lazyload({
                effect: "fadeIn"
            });
        })();

        return init;
    });

/**
 * Created by cuizhuochen on 15-8-14.
 */
define(['zepto', 'ui.waterfall', 'app/service/brokerService', 'zepto.temp', 'page.params', 'app/modules/ui/ui.lazyload'],
    function($, Waterfall, service, temp, params) {
        'use strict';

        var contentWrap, pageInfo = params.params,
            waterfallInstance = null;

        contentWrap = $('.broker-list');

        function init() {
            if (pageInfo.page) {
                waterfallInstance = new Waterfall({
                    resources: service.getBrokerList,
                    onLoad: function(data) {
                        if (data.brokers && data.brokers.length) {
                            var brokerStr = $(temp('broker_list_tpl', {
                                'names': data
                            }));
                            brokerStr.find('img').lazyload({
                                effect: "fadeIn"
                            });
                            contentWrap.append(brokerStr);
                        }
                    },
                    continueWhile: function(data) {
                        return (data.brokers && data.brokers.length) ? true : false;
                    },
                    data: pageInfo,
                    wrap: '.broker-list',
                    eventDom: $(window)
                });
            }
            bindEvent();
        }

        function bindEvent() {
            contentWrap.on('click', '.list-item', function(e) {
                e.preventDefault();
                var href = $('a', e.currentTarget).attr('href');
                location.href = href;
            });

            //懒加载
            $('.broker-list .lazy').lazyload({
                effect: "fadeIn"
            });
        };

        init();
    });
/**
 * Created by cuizhuochen on 1/8/15.
 */
define(['zepto', 'ui.waterfall', 'app/service/contractService', 'zepto.temp', 'page.params', 'app/modules/ui/ui.lazyload'],
    function ($, Waterfall, service, temp, params) {
        'use strict';
        var contentWrap, pageInfo, waterfallInstance = null;
        contentWrap = $('.common-list');


        function init() {
            pageInfo = params.pageInfo;
            if (pageInfo) {
                waterfallInstance = new Waterfall({
                    resources: service.getContractPageList,
                    onLoad: function (data) {
                        if (data && !data.code) {
                            var propertyStr = $(temp('common_list_tpl', {'names': data.items}));
                            contentWrap.append(propertyStr);
                        }
                    },
                    continueWhile: function (data) {
                        return true;
                    },
                    data: pageInfo,
                    wrap: '.common-list',
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

        })();

        return init;
    });

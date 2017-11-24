/* jshint camelcase: false */
define(['zepto', 'zepto.temp', 'app/service/brokerService', 'ui.waterfall', 'page.params'],
function($, temp, service, Waterfall, param) {
    'use strict';

    ({
        pager: param.pager,
        info: param.info,

        init: function(){
            var self = this;
            self.pager && self.getBrokerRecommendProp();
        },

        getBrokerRecommendProp: function(){
            var self = this;

            if(self.pager.last_page > self.pager.current_page){
                new Waterfall({
                    resources: service.getBrokerRecommendProp,
                    onLoad: function(data) {
                        if(data.inventories.length > 0){
                            var $recommendList = $('.recommend-list'),
                                recInventories = data.inventories;

                            var recommendStr = temp('recommend_prop_tpl', {
                                'recInventories': recInventories,
                                'info': self.info,
                                'sandbox': param.sandbox,
                                'pager': self.pager
                            });
                            $recommendList.append(recommendStr);
                        }
                    },
                    data: {
                        page: self.pager.current_page,
                        per_page: self.pager.per_page,
                        broker_id: self.info.broker_id,
                        city_jianpin: self.info.city_jianpin
                    },
                    wrap: '.recommend-list',
                    eventDom: $(window)
                });
            }
        }
    }).init();
});
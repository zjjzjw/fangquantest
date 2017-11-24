/* jshint camelcase: false */
define(['zepto', 'zepto.temp', 'app/service/brokerService', 'ui.waterfall', 'page.params'],
    function($, temp, service, Waterfall, param) {
    'use strict';

    ({
        pager: param.pager,
        info: param.info,

        init: function(){
            this.info && this.getBrokerDynamic();
        },

        getBrokerDynamic: function(){
            var self = this;
            var _lastDate = self.info.last_date;
            if(self.pager.last_page > self.pager.current_page){
                new Waterfall({
                    resources: service.getBrokerDynamic,
                    onLoad: function(data) {
                        if(data.dynamics.length > 0){
                            var $dynamicList = $('.state-list'),
                                dynamics = data.dynamics,
                                firstDate = dynamics[0].date;

                            var dateTemp = dynamics[dynamics.length-1].date;

                            if(self.isSameDate(_lastDate, firstDate)) {  //li
                                var lastDynamic = dynamics.shift();

                                var lastDynamicStr = temp('last_dynamic_tpl', {
                                    'dynamic': lastDynamic.dynamic
                                });
                                var dynamicStr = temp('dynamic_tpl', {
                                    'dynamics': dynamics
                                });
                                $('li', $dynamicList).last().append(lastDynamicStr);
                                $dynamicList.append(dynamicStr);
                            } else { //ul
                                var dynamicsStr = temp('dynamic_tpl', {
                                    'dynamics': dynamics
                                });
                                $dynamicList.append(dynamicsStr);
                            }
                            _lastDate = dateTemp;
                        }
                    },
                    data: {
                        page: self.pager.current_page,
                        per_page: self.pager.per_page,
                        broker_id: self.info.broker_id,
                        city_jianpin: self.info.city_jianpin
                    },
                    wrap: '.state-list',
                    eventDom: $(window)
                });
            }
        },

        isSameDate: function(date1, date2){
            return JSON.stringify(date1) == JSON.stringify(date2);
        }
    }).init();
});
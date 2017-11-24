/**
 * Created by cuizhuochen on 1/23/15.
 */
define(['zepto', 'app/service/utilService', 'page.params', 'app/lib/cookies'], function($, sendtrack, params){
    'use strict';

    $.trackEvent = function (op) {
        sendtrack(initParameters(op));
    };

    function initParameters(op){
        var client_geo;
        if(window.localStorage){
            client_geo = window.localStorage.geo ? {geo: window.localStorage.geo} : {}; // jshint ignore:line
        }

        var _op = $.extend({},{
            /* jshint ignore:start */
            payload: 'web_visit',
            client_time: Math.round(new Date().getTime()/1000),
            referer: document.referrer,
            url: location.href,

            uid: '',
            guid: '',
            ccid: '',
            page_param: {},
            client_param: $.extend({},client_geo)
            /* jshint ignore:end */
        }, params.logParams, params.pageParams, op);

        _op.page_param = JSON.stringify(_op.page_param);
        _op.client_param = JSON.stringify(_op.client_param);

        if(op && op.action) {
            _op.payload = 'web_action_log';
        }

        return _op;
    }

});
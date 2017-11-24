define(['zepto', 'ajax', 'page.params'], function ($, ajax, params) {
    'use strict';

    // 搜索列表
    function getSearchList (options) {
        var d = options.data;
        ajax({
            type: 'GET',
            url: '/sale/list/keyword/search',
            data: {
                keywords: d.keyword
            },
            dataType: 'json',
            success: options.sucFn,
            error: options.errFn
        });
    }
    //分页
    function getPageList (options) {
        var d = options.data;
        ajax({
            type: 'GET',
            url: '/sale/list',
            data: options.data,
            dataType: 'json',
            success: options.sucFn,
            error: options.errFn
        });
    }

    return {
        getSearchList: getSearchList,
        getPageList: getPageList
    };
});

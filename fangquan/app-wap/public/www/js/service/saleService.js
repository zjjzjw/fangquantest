/**
 * Created by maciej on 2017/3/16.
 */
define(['zepto', 'ajax', 'page.params'], function ($, ajax, params) {

    function getSalePageList(opts) {
        var url = '/api/sale/list';
        if (params.listType == 'sale.individual.list') {
            url = '/api/sale/individual/list';
        }
        ajax({
            type: 'GET',
            url: url,
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    function getSaleListByKeyword(opts) {
        $.extend(opts.data, {type: params.listType});
        ajax({
            type: 'GET',
            url: '/api/sale/list/keyword',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    function saleStore(opts) {
        ajax({
            type: 'POST',
            url: '/api/sale/store',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    function saleAssignUser(opts) {
        ajax({
            type: 'POST',
            url: '/api/sale/assign/user',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    function saleClaim(opts) {
        ajax({
            type: 'POST',
            url: '/api/sale/claim',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    //销售线索详情删除
    function saleDetailDelete(opts) {
        var params = opts.data;
        ajax({
            type: 'POST',
            url: '/api/sale/delete/' + params.id,
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    function saleAudit(opts) {
        ajax({
            type: 'POST',
            url: '/api/sale/audit',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    function getCardListByKeyword(opts) {
        //扩展参数
        ajax({
            type: 'GET',
            url: '/api/card/list/keyword',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    return {
        getSalePageList: getSalePageList,
        getSaleListByKeyword: getSaleListByKeyword,
        saleStore: saleStore,
        saleAssignUser: saleAssignUser,
        saleClaim: saleClaim,
        saleDetailDelete: saleDetailDelete,
        saleAudit: saleAudit,
        getCardListByKeyword: getCardListByKeyword
    };

});
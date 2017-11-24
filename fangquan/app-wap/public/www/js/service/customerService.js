define(['zepto', 'ajax', 'page.params'], function ($, ajax, params) {

    function getCustomerPageList(opts) {
        var url = '/api/customer/list';
        if (params.listType == 'customer.individual.list') {
            url = '/api/customer/individual/list';
        } else if (params.listType == 'customer.partner.list') {
            url = '/api/customer/partner/list';
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

    function getCustomerListByKeyword(opts) {
        //扩展参数
        $.extend(opts.data, {type: params.listType});
        ajax({
            type: 'GET',
            url: '/api/customer/list/keyword',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    function storeCustomer(opts) {
        ajax({
            type: 'POST',
            url: '/api/customer/store',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    //项目详情删除
    function customerDetailDelete(opts) {
        var params = opts.data;
        ajax({
            type: 'POST',
            url: '/api/customer/delete/' + params.id,
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    //组织架构
    function storeCustomerStructure(opts) {
        ajax({
            type: 'POST',
            url: '/api/project/structure/store',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    function structureDetailDelete(opts) {
        var params = opts.data;
        ajax({
            type: 'POST',
            url: '/api/project/structure/delete/' + params.id,
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }
    function getCardListByKeyword(opts) {
        //扩展参数
        $.extend(opts.data, {type: params.listType});
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
        getCustomerPageList: getCustomerPageList,
        getCustomerListByKeyword: getCustomerListByKeyword,
        storeCustomer: storeCustomer,
        customerDetailDelete: customerDetailDelete,
        storeCustomerStructure: storeCustomerStructure,
        structureDetailDelete: structureDetailDelete,
        getCardListByKeyword: getCardListByKeyword
    };
});
define(['zepto', 'ajax', 'page.params'], function ($, ajax, params) {

    function getContractPageList(opts) {
        var url = '/api/contract/list';
        if (params.listType == 'contract.individual.list') {
            url = '/api/contract/individual/list';
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

    function getContractListByKeyword(opts) {
        //扩展参数
        $.extend(opts.data, {type: params.listType});
        ajax({
            type: 'GET',
            url: '/api/contract/list/keyword',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    function storeContract(opts) {
        ajax({
            type: 'POST',
            url: '/api/contract/store',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    //项目详情删除
    function contractDetailDelete(opts) {
        var params = opts.data;
        ajax({
            type: 'GET',
            url: '/api/contract/delete/' + params.id,
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    function storeContractPayment(opts) {
        ajax({
            type: 'POST',
            url: '/api/contract/payment/store',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }


    function contractPaymentDelete(opts) {
        var params = opts.data;
        ajax({
            type: 'POST',
            url: '/api/contract/payment/delete/' + params.id,
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    return {
        getContractPageList: getContractPageList,
        getContractListByKeyword: getContractListByKeyword,
        storeContract: storeContract,
        contractDetailDelete: contractDetailDelete,
        storeContractPayment: storeContractPayment,
        contractPaymentDelete: contractPaymentDelete
    };
});
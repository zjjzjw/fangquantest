define(['zepto', 'ajax'], function ($, ajax) {

    function storeProjectPurchase(opts) {
        ajax({
            type: 'POST',
            url: '/api/project/purchase/store',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }
    //采购流程详情删除
    function purchaseDeatilDelete(opts) {
        var params = opts.data;
        ajax({
            type: 'POST',
            url: '/api/project/purchase/delete/'+ params.id,
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    return {
        storeProjectPurchase: storeProjectPurchase,
        purchaseDeatilDelete: purchaseDeatilDelete
    };
});
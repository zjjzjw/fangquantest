module.exports = (function () {

    //产品收藏
    var _collect = function collect(opts) {
        $.http({
            type: 'POST',
            url: '/api/personal/collection/collection-product/store/0',
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    //产品取消收藏
    var _cancel = function cancel(opts) {
        $.http({
            type: 'POST',
            url: '/api/personal/collection/collection-product/delete/0',
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    return {
        collect: _collect,
        cancel: _cancel
    };
})();
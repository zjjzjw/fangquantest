module.exports = (function () {

    //方案收藏
    var _collect = function collect(opts) {
        $.http({
            type: 'POST',
            url: '/api/personal/collection/collection-scheme/store/0',
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    //方案取消收藏
    var _cancel = function cancel(opts) {
        $.http({
            type: 'POST',
            url: '/api/personal/collection/collection-scheme/delete/0',
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
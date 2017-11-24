module.exports = (function () {

    var _contact = function login(opts) {
        $.http({
            type: 'GET',
            url: '/api/provider/provider-contact',
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    //项目收藏
    var _collect = function collect(opts) {
        $.http({
            type: 'POST',
            url: '/api/personal/collection/collection-provider/store/0',
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    //项目取消收藏
    var _cancel = function cancel(opts) {
        $.http({
            type: 'POST',
            url: '/api/personal/collection/collection-provider/delete/0',
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    return {
        contact: _contact,
        collect: _collect,
        cancel: _cancel
    };
})();
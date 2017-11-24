module.exports = (function () {

    var _contact = function login(opts) {
        $.http({
            type: 'GET',
            url: '/api/developer/developer-project-contact',
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
            url: '/api/developer/developer-project/collect',
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
            url: '/api/developer/developer-project/cancel',
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
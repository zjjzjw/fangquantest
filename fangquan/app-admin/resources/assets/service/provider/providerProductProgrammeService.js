module.exports = (function () {

    var _store = function store(opts) {
        $.http({
            type: 'POST',
            url: '/api/provider/provider-product-programme/store/' + opts.params.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    var _update = function update(opts) {
        $.http({
            type: 'POST',
            url: '/api/provider/provider-product-programme/update/' + opts.params.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    var _delete = function (opts) {
        $.http({
            type: 'POST',
            dataType: 'json',
            url: '/api/provider/provider-product-programme/delete/' + opts.data.id,
            data: opts.data,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    var _reject = function update(opts) {
        $.http({
            type: 'POST',
            url: '/api/provider/provider-product-programme/reject/' + opts.params.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    var _audit = function (opts) {
        $.http({
            type: 'POST',
            dataType: 'json',
            url: '/api/provider/provider-product-programme/audit/' + opts.params.id,
            data: opts.data,
            success: opts.sucFn,
            error: opts.errFn
        });
    };


    return {
        store: _store,
        update: _update,
        delete: _delete,
        reject:_reject,
        audit:_audit
    };
})();

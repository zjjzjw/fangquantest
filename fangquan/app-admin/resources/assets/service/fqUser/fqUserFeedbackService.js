module.exports = (function () {

    var _reject = function reject(opts) {
        $.http({
            type: 'POST',
            url: '/api/fq-user/fq-user-feedback/reject/' + opts.params.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    var _audit = function audit(opts) {
        $.http({
            type: 'POST',
            url: '/api/fq-user/fq-user-feedback/audit/' + opts.params.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    var _delete = function update(opts) {
        $.http({
            type: 'POST',
            url: '/api/fq-user/fq-user-feedback/delete/' + opts.data.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    return {
        reject: _reject,
        audit: _audit,
        delete: _delete
    };
})();
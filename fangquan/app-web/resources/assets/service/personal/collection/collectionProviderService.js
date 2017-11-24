module.exports = (function () {

    var _delete = function (opts) {
        $.http({
            type: 'POST',
            url: '/api/personal/collection/collection-provider/delete/' + opts.data.provider_id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    return {
        delete: _delete
    };
})();
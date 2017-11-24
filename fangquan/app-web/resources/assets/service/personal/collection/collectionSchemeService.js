module.exports = (function () {

    var _delete = function (opts) {
        $.http({
            type: 'POST',
            url: '/api/personal/collection/collection-scheme/delete/' + opts.data.product_programme_id,
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
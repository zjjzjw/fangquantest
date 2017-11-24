module.exports = (function () {

    var _lookMore = function store(opts) {
        $.http({
            type: 'POST',
            url: '/api/review/list/look-more/',
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    return {
        lookMore: _lookMore
    };
})();
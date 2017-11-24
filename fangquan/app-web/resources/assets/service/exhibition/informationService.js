module.exports = (function () {

    var _lookMore = function store(opts) {
        $.http({
            type: 'GET',
            url: '/api/content/content/get-content/' + opts.data.page,
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
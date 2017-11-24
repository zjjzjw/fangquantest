module.exports = (function () {

    var _resetPassword = function store(opts) {
        $.http({
            type: 'POST',
            url: '/api/auth/register',
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    return {
        resetPassword: _resetPassword,
    };
})();
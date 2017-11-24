module.exports = (function () {

    var _login = function store(opts) {
        $.http({
            type: 'POST',
            url: '/api/auth/login',
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    return {
        login: _login,
    };
})();
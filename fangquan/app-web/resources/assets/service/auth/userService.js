module.exports = (function () {

    var _login = function login(opts) {
        $.http({
            type: 'POST',
            url: '/api/account/login',
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
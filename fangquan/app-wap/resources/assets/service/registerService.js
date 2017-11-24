module.exports = (function () {

    var _register = function store(opts) {
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
        register: _register,
    };
})();
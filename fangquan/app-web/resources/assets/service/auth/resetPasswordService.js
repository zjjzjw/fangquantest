module.exports = (function () {

    var _resetPassword = function resetPassword(opts) {
        $.http({
            type: 'POST',
            url: '/api/account/retrieve-password-by-phone',
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    var _verifyCode = function verifyCode(opts) {
        $.http({
            type: 'POST',
            url: '/api/account/verify-code',
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    return {
        resetPassword: _resetPassword,
        verifyCode: _verifyCode
    };
})();
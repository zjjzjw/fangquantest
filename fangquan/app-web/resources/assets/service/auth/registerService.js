module.exports = (function () {

    var _mobileRegister = function mobileRegister(opts) {
        $.http({
            type: 'POST',
            url: '/api/account/mobile-register',
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
        mobileRegister: _mobileRegister,
        verifyCode: _verifyCode
    };
})();
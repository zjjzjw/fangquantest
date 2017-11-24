module.exports = (function () {
    // 修改昵称
    var _modifyNickname = function modifyNickname(opts) {
        $.http({
            type: 'POST',
            url: '/api/account/modify-nickname',
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };
    // 修改密码
    var _modifyPassword = function modifyPassword(opts) {
        $.http({
            type: 'POST',
            url: '/api/account/modify-password',
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };
    // 绑定手机号-获取验证码
    var _verifyCode = function verifyCode(opts) {
        $.http({
            type: 'POST',
            url: '/api/account/verify-code',
            data: opts.data,
            beforeSend: opts.beforeSend,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    };
    // 绑定手机号
    var _bindPhone = function bindPhone(opts) {
        $.http({
            type: 'POST',
            url: '/api/account/bind-phone',
            data: opts.data,
            beforeSend: opts.beforeSend,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    return {
        modifyNickname: _modifyNickname,
        modifyPassword: _modifyPassword,
        verifyCode: _verifyCode,
        bindPhone: _bindPhone
    };
})();
module.exports = (function () {

    var _setRead = function setRead(opts) {
        $.http({
            type: 'POST',
            url: '/api/msg/set-read/' + opts.data.msg_id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    return {
        setRead: _setRead,
    };
})();
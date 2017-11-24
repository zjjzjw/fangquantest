define(['zepto', 'ajax', 'page.params'], function ($, ajax, params) {


    function _time(opts) {
        ajax({
            type: 'POST',
            url: '/api/exhibition/user-answer/time',
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    return {
        time: _time
    };
});
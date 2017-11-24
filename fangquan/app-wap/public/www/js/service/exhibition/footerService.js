define(['zepto', 'ajax', 'page.params'], function ($, ajax, params) {


    function _lookMoreD(opts) {
        ajax({
            type: 'GET',
            url: '/exhibition/developer-list',
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    }
    function _lookMoreP(opts) {
        ajax({
            type: 'GET',
            url: '/exhibition/provider-list',
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    return {
        lookMoreD: _lookMoreD,
        lookMoreP:_lookMoreP
    };
});
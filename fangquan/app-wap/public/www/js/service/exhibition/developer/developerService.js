define(['zepto', 'ajax', 'page.params'], function ($, ajax, params) {


    function _lookMoreD(opts) {
        ajax({
            type: 'GET',
            url: '/api/exhibition/developer/list-more/'+ opts.data.page,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    }
    return {
        lookMoreD: _lookMoreD
    };
});
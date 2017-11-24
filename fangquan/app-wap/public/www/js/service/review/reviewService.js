define([
    'zepto',
    'ajax',
    'page.params'
], function ($, ajax, params) {

    function _showMore(opts) {
        ajax({
            type: 'GET',
            url: '/api/review/list/' + opts.data.page,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    return {
        showMore: _showMore,
    };
});
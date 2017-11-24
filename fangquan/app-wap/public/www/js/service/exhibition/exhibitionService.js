define([
    'zepto',
    'ajax',
    'page.params'
], function ($, ajax, params) {

    function _showMore(opts) {
        ajax({
            type: 'GET',
            url: '/api/exhibition/flashback/allaudio/' + opts.data.page,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    function _showMoreResult(opts) {
        ajax({
            type: 'GET',
            url: '/api/exhibition/result/' + opts.data.page,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    return {
        showMore: _showMore,
        showMoreResult: _showMoreResult
    };
});
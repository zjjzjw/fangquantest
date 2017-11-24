define(['zepto', 'ajax', 'page.params'], function ($, ajax, params) {

    //问卷调查
    function exhibitionQs(opts) {
        var params = opts.data;
        ajax({
            type: 'POST',
            url: '/api/exhibition/user-answer/store/' + params.id,
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    return {
        exhibitionQs: exhibitionQs
    };
});
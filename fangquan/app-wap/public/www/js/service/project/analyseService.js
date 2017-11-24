define(['zepto', 'ajax'], function ($, ajax) {

    function storeProjectAnalyse(opts) {
        ajax({
            type: 'POST',
            url: '/api/project/analyse/store',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }
    function analyseDeatilDelete(opts) {
        var  params = opts.data;
        ajax({
            type: 'POST',
            url: '/api/project/analyse/delete/'+ params.id,
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    return {
        storeProjectAnalyse: storeProjectAnalyse,
        analyseDeatilDelete: analyseDeatilDelete
    };
});
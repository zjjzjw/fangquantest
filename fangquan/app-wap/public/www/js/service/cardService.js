define(['zepto', 'ajax', 'page.params'], function ($, ajax, params) {


    function storeCard(opts) {
        ajax({
            type: 'POST',
            url: '/api/card/store',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    function cardDelete(opts) {
        var params = opts.data;
        ajax({
            type: 'POST',
            url: '/api/card/delete/' + params.id,
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    return {
        storeCard: storeCard,
        cardDelete: cardDelete
    };
});
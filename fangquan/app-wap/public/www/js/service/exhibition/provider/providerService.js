define(['zepto', 'ajax', 'page.params'], function ($, ajax, params) {


    function _getProviderList(opts) {
        ajax({
            type: 'GET',
            url: '/api/exhibition/provider/list',
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    return {
        getProviderList: _getProviderList
    };

});
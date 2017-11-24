define(['zepto', 'ajax', 'page.params'], function ($, ajax, params) {


    function _getDeveloperProjectList(opts) {
        ajax({
            type: 'GET',
            url: '/api/exhibition/developer-project/list',
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    return {
        getDeveloperProjectList: _getDeveloperProjectList
    };
});
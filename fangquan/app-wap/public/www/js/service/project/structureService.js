define(['zepto', 'ajax', 'page.params'], function ($, ajax, params) {

    function storeProjectStructure(opts) {
        ajax({
            type: 'POST',
            url: '/api/project/structure/store',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    //组织架构详情删除
    function structureDetailDelete(opts) {
        var params = opts.data;
        ajax({
            type: 'POST',
            url: '/api/project/structure/delete/' + params.id,
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }
    function getCardListByKeyword(opts) {
        //扩展参数
        $.extend(opts.data, {type: params.listType});
        ajax({
            type: 'GET',
            url: '/api/card/list/keyword',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    return {
        storeProjectStructure: storeProjectStructure,
        structureDetailDelete: structureDetailDelete,
        getCardListByKeyword: getCardListByKeyword
    };
});
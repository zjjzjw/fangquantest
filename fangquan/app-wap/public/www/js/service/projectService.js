define(['zepto', 'ajax', 'page.params'], function ($, ajax, params) {

    function getProjectPageList(opts) {
        var url = '/api/project/list';
        if (params.listType == 'project.individual.list') {
            url = '/api/project/individual/list';
        } else if (params.listType == 'project.partner.list') {
            url = '/api/project/partner/list';
        }
        ajax({
            type: 'GET',
            url: url,
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    function getProjectListByKeyword(opts) {
        //扩展参数
        $.extend(opts.data, {type: params.listType});
        ajax({
            type: 'GET',
            url: '/api/project/list/keyword',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    function storeProject(opts) {
        ajax({
            type: 'POST',
            url: '/api/project/store',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    //项目详情删除
    function projectDetailDelete(opts) {
        var params = opts.data;
        ajax({
            type: 'POST',
            url: '/api/project/delete/' + params.id,
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    //项目匹配
    function getSaleListByKeyword(opts) {
        $.extend(opts.data, {type: params.listType});
        ajax({
            type: 'GET',
            url: '/api/sale/list/keyword',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    return {
        getProjectPageList: getProjectPageList,
        getProjectListByKeyword: getProjectListByKeyword,
        storeProject: storeProject,
        projectDetailDelete: projectDetailDelete,
        getSaleListByKeyword: getSaleListByKeyword
    };
});
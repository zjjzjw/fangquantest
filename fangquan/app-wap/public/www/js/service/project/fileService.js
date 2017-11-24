define(['zepto', 'ajax'], function ($, ajax) {

    function storeProjectFile(opts) {
        ajax({
            type: 'POST',
            url: '/api/project/file/store',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }
    //档案详情删除
    function fileDeatilDelete(opts) {
        var  params = opts.data;
        ajax({
            type: 'POST',
            url: '/api/project/file/delete/' + params.id,
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    return {
        storeProjectFile: storeProjectFile,
        fileDeatilDelete: fileDeatilDelete
    };
});
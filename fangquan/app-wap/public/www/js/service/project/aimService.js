define(['zepto', 'ajax'], function ($, ajax) {

    function storeProjectAim(opts) {
        ajax({
            type: 'POST',
            url: '/api/project/aim/store',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    function storeProjectAimHinder(opts) {
        ajax({
            type: 'POST',
            url: '/api/project/aim/hinder/store',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    //目标详情删除
    function aimDetailDelete(opts) {
        var params = opts.data;
        ajax({
            type: 'POST',
            url: '/api/project/aim/delete/' + params.id,
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    //目标障碍删除
    function aimHinderDelete(opts) {
        var params = opts.data;
        ajax({
            type: 'POST',
            url: '/api/project/aim/hinder/delete/' + params.id,
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    //目标障碍审核
    function aimHinderAudit(opts) {
        var params = opts.data;
        console.log(params);
        ajax({
            type: 'POST',
            url: '/api/project/aim/hinder/audit',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    function getHinderPageList(opts) {
        var url = '/api/user/approval/hinder/list';
        ajax({
            type: 'GET',
            url: url,
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    return {
        storeProjectAim: storeProjectAim,
        storeProjectAimHinder: storeProjectAimHinder,
        aimDetailDelete: aimDetailDelete,
        aimHinderDelete: aimHinderDelete,
        aimHinderAudit: aimHinderAudit,
        getHinderPageList: getHinderPageList,
    };
});
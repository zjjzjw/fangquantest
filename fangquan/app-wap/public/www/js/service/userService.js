define(['zepto', 'ajax'], function ($, ajax) {

    //是否登录
    function islogin(opts) {
        ajax({
            type: 'GET',
            url: '/api/islogin',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    //登录
    function login(opts) {
        ajax({
            type: 'POST',
            url: '/api/verifyPhone',
            data: opts.data,
            dataType: 'json',
            success: opts.successCb, //后台根据from_src跳转至不同页面
            error: opts.errorCb
        });
    }

    //修改密码
    function modifyPassword(opts) {
        ajax({
            type: 'POST',
            url: '/api/user/modify-password',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    //保存意见反馈
    function storeUserFeedback(opts) {
        ajax({
            type: 'POST',
            url: '/api/user/feedback/store',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    function getSalePageList(opts) {
        ajax({
            type: 'GET',
            url: '/api/user/approval/sale/list',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    //任务分配-创建任务
    function signTaskStore(opts) {
        ajax({
            type: 'POST',
            url: '/api/user/sign-task/store',
            data: opts.data,
            dataType: 'json',
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    return {
        islogin: islogin,
        login: login,
        modifyPassword: modifyPassword,
        storeUserFeedback: storeUserFeedback,
        getSalePageList: getSalePageList,
        signTaskStore: signTaskStore
    };
});
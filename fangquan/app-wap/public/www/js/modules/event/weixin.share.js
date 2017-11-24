/* jshint unused: false, camelcase: false */
define(['zepto', 'app/lib/jweixin', 'app/service/weixinService', 'zepto.sp'], function($, wx, service, sp) {
    /*
     * options: title, desc, link, imageUrl
     */
    function WxShare(options) {
        var titleValue = options.title;
        var descValue = options.desc;
        var linkValue = options.link;
        var imgUrlValue = options.imageUrl;

        service.getWeixinParam({
            data: {
                url: options.pageUrl
            },
            sucCb: _wxUtil
        });

        function _wxUtil (params) {

            wx.config({
                debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
                appId: params.info.app_id,  // 必填，公众号的唯一标识
                timestamp: params.info.timestamp, // 必填，生成签名的时间戳
                nonceStr: params.info.noncestr, // 必填，生成签名的随机串
                signature: params.info.signature,// 必填，签名，见附录1
                jsApiList: [
                    'checkJsApi',
                    'onMenuShareTimeline',
                    'onMenuShareAppMessage'
                ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
            });
            wx.ready(function () {
                // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
                //分享朋友圈
                wx.onMenuShareTimeline({
                    title: descValue,
                    desc: descValue,
                    link: linkValue,
                    imgUrl: imgUrlValue,
                    trigger: function (res) {
                        //alert('用户点击发送给朋友');
                    },
                    success: function (res) {
                        sp.publish('shareTimelineSuccess');
                    },
                    cancel: function (res) {
                        //alert('已取消');
                    },
                    fail: function (res) {
                        //alert(JSON.stringify(res));
                    }
                });
                //分享朋友
                wx.onMenuShareAppMessage({
                    title: titleValue,
                    desc: descValue,
                    link: linkValue,
                    imgUrl: imgUrlValue,
                    trigger: function (res) {
                        //alert('用户点击发送给朋友');
                    },
                    success: function (res) {
                        sp.publish('shareAppMessageSuccess');
                    },
                    cancel: function (res) {
                        //alert('已取消');
                    },
                    fail: function (res) {
                        //alert(JSON.stringify(res));
                    }
                });

            });
            wx.error(function (res) {
                //alert(res.errMsg);
            });    
        }
    }

    return WxShare;
});
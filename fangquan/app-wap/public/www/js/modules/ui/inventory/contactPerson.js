define(['zepto', 'page.params', 'ui.amap'], function($, params, Amap) {
    'use strict';

    //添加静态地图
    (function() {
        //下载app
        $('#chat-inline-broker').on('click', function() {
            var name = $(this).data('name');
            location.href = "http://www.angejia.com/download/app?from=" + params.from_Code['immediately_contact'];
            $.trackEvent({
                action: 'TW_VPPV_Click_' + name,
                page_param: {
                    brokerId: params.brokerId,
                    inventoryId: params.property_id || ''
                }
            });
        });
    })();
});
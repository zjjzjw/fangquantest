$(function () {
    require("../../component/exhibition-header");
    var Popup = require('../../component/popup');
    var temp = require('../../component/temp');
    var service = require('../../service/exhibition/resultService');

    $loadingPop = new Popup({
        width: 128,
        height: 128,
        contentBg: 'transparent',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#loadingTpl').html()
    });

    var page = 1;
    $(document).on('click', '.look-more', function () {
        var opt = {data: {}};
        var $data_dom = $('.dynamic');
        page = page + 1;

        service.lookMore({
            data: {page: page},
            beforeSend: function () {
                $loadingPop.showPop(opt);
            },
            sucFn: function (data, status, xhr) {
                console.log(data);
                $loadingPop.closePop();
                var tempList = temp('list_tpl', {
                    data: data
                });
                $data_dom.append(tempList);
                if (data.items.length < 10) {
                    $('.look-more').hide();
                }
            },
            errFn: function (data, status, xhr) {
            }
        });
    });
});
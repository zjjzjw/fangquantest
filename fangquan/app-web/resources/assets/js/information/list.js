$(function () {
    require("../../component/exhibition-header");
    var Popup = require('../../component/popup');
    var temp = require('../../component/temp');
    var service = require('../../service/exhibition/informationService');
    $loadingPop = new Popup({
        width: 128,
        height: 128,
        contentBg: 'transparent',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#loadingTpl').html()
    });
    //显示更多
    var page = 1;
    $(document).on('click', '.more-box', function () {
        var opt = {data: {}};
        var $data_dom = $('.information-box');
        $loadingPop.showPop(opt);
        page = page + 1;
        service.lookMore({
            data: {page: page},
            sucFn: function (data, status, xhr) {
                $loadingPop.closePop();
                var tpl = temp('show_moreTpl', {
                    'data': data
                });

                $data_dom.append(tpl);
                if (data.items.length < 15) {
                    $('.more-box').hide();
                }
            },
            errFn: function (data, xhr, errorType, error) {
            }
        });
    });
    function showError(data) {
        var info = '';
        var messages = [];
        var i = 0;
        for (var key in data) {
            messages.push(++i + "、" + data[key][0]);
        }
        info = messages.join('</br>');
        return info;
    }
});
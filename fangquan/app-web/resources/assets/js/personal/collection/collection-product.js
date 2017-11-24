$(function () {
    var Popup = require('../../../component/popup');
    var service = require('../../../service/personal/collection/collectionProductService');

    $confirmPop = new Popup({
        width: 400,
        height: 225,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#confirmTpl').html()
    });
    $promptPop = new Popup({
        width: 400,
        height: 225,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#promptTpl').html()
    });

    var data_id;
    $('.delete').on('click', function () {
        data_id = $(this).data('id');
        var opt = {data: {}};
        $confirmPop.showPop(opt);
    });
    $(document).on('click', '#dialog_cancel', function () {
        $confirmPop.closePop();
    });
    $(document).on('click', '#dialog_confirm', function () {
        var opt = {data: {}};
        service.delete({
            data: {_token: $.params.token, provider_product_id: data_id},
            sucFn: function (data, status, xhr) {
                $confirmPop.closePop();
                window.location.reload();
            },
            errFn: function (data, status, xhr) {
                $confirmPop.closePop();
                $('.text').html(showError(data));
                $promptPop.showPop(opt);
            }
        });
    });
    $(document).on('click', '#pop_close', function () {
        $promptPop.closePop();
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
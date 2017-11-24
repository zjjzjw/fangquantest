$(function () {
    var Popup = require('./../../../component/popup');
    var service = require('./../../../service/brand/brandCooperationService');
    var data_id;
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
    $('.delete').on('click', function () {
        data_id = $(this).data('id');
        var opt = {data: {}};
        $confirmPop.showPop(opt);
        $('.text').html("确定要删除吗？");
        return false;
    });
    $(document).on('click', '#dialog_cancel', function () {
        $confirmPop.closePop();
    });
    $(document).on('click', '#dialog_confirm', function () {
        var opt = {data: {}};
        service.delete({
            data: {id: data_id},
            sucFn: function (data, status, xhr) {
                $confirmPop.closePop();
                window.location.reload();
                $('.text').html("确定要删除吗？");
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
        $('.text').html("确定要删除吗？");
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
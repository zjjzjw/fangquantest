$(function () {
    var Popup = require('../../../component/popup');
    var temp = require('../../../component/temp');
    var service = require('../../../service/provider/providerProjectService');
    var status_s;
    $loadingPop = new Popup({
        width: 128,
        height: 128,
        contentBg: 'transparent',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#loadingTpl').html()
    });

    $promptPop = new Popup({
        width: 400,
        height: 225,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#promptTpl').html()
    });

    $(document).on("click", ".save", function () {
        status_s = $(this).data('status');
        var opt = {data: {}};
        $promptPop.showPop(opt);
        $('.text').html("审核通过后，该供应商信息将在网站上显示，确认通过吗？");
        return false;
    });

    $(document).on("click", ".reject", function () {
        status_s = $(this).data('status');
        var opt = {data: {}};
        $promptPop.showPop(opt);
        $('.text').html("审核不通过后，该供应商信息将不在网站上显示，确认不通过吗？");
        return false;
    });

    $(document).on('click', '#pop_close', function () {
        $promptPop.closePop();
    });


    $(document).on('click', '#dialog_cancel', function () {
        $promptPop.closePop();
    });

    $(document).on('click', '#dialog_confirm', function () {

        if (status_s == "1") {
            var opt = {data: {}};
            service.reject({
                data: $('#form').serialize(),
                params: $.params,
                beforeSend: function () {
                    $loadingPop.showPop(opt);
                },
                sucFn: function (data, status, xhr) {
                    $promptPop.closePop();
                    $loadingPop.showPop(opt);
                    setTimeout(skipUpdate, 1000);
                    function skipUpdate() {
                        window.location.href = '/provider/' + 'provider-project/list';
                    }
                },
                errFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $('.text').html(showError(data));
                    $promptPop.showPop(opt);
                }
            });
        } else {
            var opt = {data: {}};
            service.audit({
                data: $('#form').serialize(),
                params: $.params,
                beforeSend: function () {
                    $loadingPop.showPop(opt);
                },
                sucFn: function (data, status, xhr) {
                    $promptPop.closePop();
                    $loadingPop.showPop(opt);
                    setTimeout(skipUpdate, 1000);
                    function skipUpdate() {
                        window.location.href = '/provider/' + 'provider-project/list';
                    }
                },
                errFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $('.text').html(showError(data));
                    $promptPop.showPop(opt);
                }
            });
        }


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
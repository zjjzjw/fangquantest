$(function () {
    var Popup = require('../../../component/popup');
    var temp = require('../../../component/temp');
    var service = require('../../../service/fqUser/fqUserFeedbackService');
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
        $('.text').html("确认已处理吗？");
        return false;
    });

    $(document).on("click", ".reject", function () {
        status_s = $(this).data('status');
        var opt = {data: {}};
        $promptPop.showPop(opt);
        $('.text').html("确认未处理吗？");
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
                        window.location.href = '/fq-user/fq-user-feedback/index';
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
                        window.location.href = '/fq-user/fq-user-feedback/index';
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
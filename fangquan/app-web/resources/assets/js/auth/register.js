$(function () {
    var Popup = require('../../component/popup');
    var service = require('../../service/auth/registerService');
    $successPop = new Popup({
        width: 360,
        height: 180,
        contentBg: '#fff',
        maskColor: '#ededed',
        maskOpacity: '0.6',
        content: $('#successTpl').html()
    });
    $loadingPop = new Popup({
        width: 128,
        height: 128,
        contentBg: 'transparent',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#loadingTpl').html()
    });

    $.validate({
        form: '#form',
        onSuccess: function ($form) {
            moreValidate();
            return false;
        }
    });

    // 倒计时
    function downTime() {
        var countdown = 3;
        var headler = setInterval(function () {
            if (countdown === 1) {
                $successPop.closePop();
                window.location.href = '/';
            } else {
                countdown--;
                $('.time').html(countdown);
            }
        }, 1000);
    }

    $('.validation-code').click(function () {
        var opt = {data: {}};
        var data = {};
        var phone = $('input[name="mobile"]').val();
        var type = $('input[name="type"]').val();
        var _token = $('input[name="_token"]').val();
        var error_message = $('.error-message').html();
        data.phone = phone;
        data.type = type;
        data._token = _token;

        var self = $(this);
        var countdown = 60;
        var headler;

        if (phone.length && !error_message) {
            self.attr("disabled", true);
            self.val(countdown + 's重新发送');
            countdown--;
            service.verifyCode({
                data: data,
                beforeSend: function () {
                    $loadingPop.showPop(opt);
                },
                sucFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    self.attr("disabled", true);
                    self.val(countdown-- + 's重新发送');
                    headler = setInterval(function () {
                        if (countdown == 0) {
                            self.removeAttr("disabled");
                            self.val("获取验证码");
                            clearInterval(headler);
                        } else {
                            self.val(countdown + 's重新发送');
                            countdown--;
                        }
                    }, 1000);

                },
                errFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    self.val("获取验证码");
                    $('.error-message').html(showError(data));
                }
            });
        }
    });

    $('input').keydown(function () {
        $('.error-message').html('');
        $('.validation-code').removeAttr("disabled");
    });

    function moreValidate() {
        var opt = {data: {}};
        $('.error-message').html('');

        service.mobileRegister({
            data: $('#form').serialize(),
            beforeSend: function () {
                $loadingPop.showPop(opt);
            },
            sucFn: function (data, status, xhr) {
                $loadingPop.closePop();
                $successPop.showPop(opt);
                downTime();
            },
            errFn: function (data, status, xhr) {
                $loadingPop.closePop();
                $('.error-message').html(showError(data));
            }
        });
    }

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
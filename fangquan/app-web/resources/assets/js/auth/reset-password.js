$(function () {
    var Popup = require('../../component/popup');
    var service = require('../../service/auth/resetPasswordService');

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

    //找回密码验证
    $.validate({
        form: '#form',
        onSuccess: function ($form) {
            moreValidate();
            return false;
        }
    });

    var phone, verifycode;

    //获取验证码
    $('.validation-code').click(function () {
        var opt = {data: {}};
        var data = {};
        phone = $('input[name="phone"]').val();
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
                sucFn: function (data, status, xhr) {
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
                    self.val("获取验证码");
                    $('.error-message').html(showError(data));
                }
            });
        }
    });

    //找回密码 - 下一步
    function moreValidate() {
        $('#reset-form').show();
        $('#form').hide();
        phone = $('input[name="phone"]').val();
        verifycode = $('input[name="verifycode"]').val();
        $('.error-message').html('');
    }

    //重置密码验证
    $.validate({
        form: '#reset-form',
        onSuccess: function ($form) {
            moreResetValidate();
            return false;
        }
    });

    // 请求密码验证
    function moreResetValidate() {
        var opt = {data: {}};
        $('input[name="phone"]').val(phone);
        $('input[name="verifycode"]').val(verifycode);
        var password = $('input[name="password"]').val();
        var repeat_password = $('input[name="repeat-password"]').val();

        if (password != repeat_password) {
            $('.error-message').html('两次密码不一致！');
        } else {
            service.resetPassword({
                data: $('#reset-form').serialize(),
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
    }

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
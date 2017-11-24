$(function () {
    var Popup = require('./../../../component/popup');
    var service = require('../../../service/personal/accountService');

    $bindingPop = new Popup({
        width: 520,
        height: 350,
        contentBg: '#fff',
        maskColor: '#ececec',
        maskOpacity: '0.6',
        content: $('#bindingTpl').html()
    });

    $loadingPop = new Popup({
        width: 128,
        height: 128,
        contentBg: 'transparent',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#loadingTpl').html()
    });

    $successPop = new Popup({
        width: 360,
        height: 210,
        contentBg: '#fff',
        maskColor: '#ededed',
        maskOpacity: '0.6',
        content: $('#successTpl').html()
    });

    var password;
    var confirm_password;

    //修改密码-按钮高亮
    $('.set-password .input-group input').keydown(function () {
        var old_password = $('input[name="old_password"]').val();
        password = $('input[name="password"]').val();
        confirm_password = $('input[name="confirm_password"]').val();
        if (old_password && password && confirm_password) {
            $('.save-btn').addClass('high-light');
        } else {
            $('.save-btn').removeClass('high-light');
        }
    });

    $('.set-password .input-group input').blur(function () {
        var old_password = $('input[name="old_password"]').val();
        password = $('input[name="password"]').val();
        confirm_password = $('input[name="confirm_password"]').val();
        if (old_password && password && confirm_password) {
            $('.save-btn').addClass('high-light');
        } else {
            $('.save-btn').removeClass('high-light');
        }
    });

    $('.set-password .input-group input').focus(function () {
        var old_password = $('input[name="old_password"]').val();
        password = $('input[name="password"]').val();
        confirm_password = $('input[name="confirm_password"]').val();
        if (old_password && password && confirm_password) {
            $('.save-btn').addClass('high-light');
        } else {
            $('.save-btn').removeClass('high-light');
        }
    });

    // 倒计时
    function downTime() {
        var countdown = 3;
        var headler = setInterval(function () {
            if (countdown === 1) {
                $successPop.closePop();
                window.location.href = '/login';
            } else {
                countdown--;
                $('.time').html(countdown);
            }
        }, 1000);
    }

    // 修改密码
    $.validate({
        form: '#form',
        scrollToTopOnError: false,
        onSuccess: function ($form) {
            moreValidate();
            return false;
        }
    });

    function moreValidate() {
        var opt = {data: {}};
        if (password != confirm_password) {
            $('.set-password .error-message').html('两次密码不一致');
        } else {
            service.modifyPassword({
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
                    $('.set-password .error-message').html(showError(data));
                }
            });
        }
    };


    //修改昵称
    $('.modify-nickname').click(function () {
        var input = '<input type="text" name="nickname" value="" maxlength="30">';
        var text = $('.span-nickname').html().replace(/(^\s*)|(\s*$)/g, "");
        $('.span-nickname').html(input).find('input').val(text);
        $(this).hide().next('a').show();
    });

    //确认修改
    $('.send-nickname').click(function () {
        var opt = {data: {}};
        var _token = $('input[name="_token"]').val();
        var nickname = $('input[name="nickname"]').val();
        var reg = /^([\u4e00-\u9fa5]|[0-9a-zA-Z_-]){2,30}$/;   //用户名昵称
        var regTest = reg.test(nickname);
        if (regTest) {
            service.modifyNickname({
                data: {'nickname': nickname, _token: _token},
                beforeSend: function () {
                    $loadingPop.showPop(opt);
                },
                sucFn: function (data, status, xhr) {
                    $loadingPop.closePop();

                    $('.nickname-error').html('');
                    $('.span-nickname').html(nickname);
                    $('.modify-nickname').show().next('a').hide();
                    $('.login .nickname em').text(nickname);
                },
                errFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $('.nickname-error').html('2-30个字符，支持中文、数字、字母、“_”、减号。');
                }
            });
        } else {
            $('.nickname-error').html('2-30个字符，支持中文、数字、字母、“_”、减号。');
        }
    });

    //绑定手机号
    $.validate({
        form: '#binding-form',
        scrollToTopOnError: false,
        onSuccess: function ($form) {
            bindingForm();
            return false;
        }
    });

    $('.binding-mobile').click(function () {
        var opt = {data: {}};
        $bindingPop.showPop(opt);
    });


    $('.close-btn').click(function () {
        $bindingPop.closePop();
        $('body').css('overflow-y', 'auto');
    });

    $('input').keydown(function () {
        $('.error-message').html('');
        $('.validation-code').removeAttr("disabled");
    });

    // 绑定手机号-发送验证码
    $('.validation-code').click(function () {
        var opt = {data: {}};
        var data = {};
        var phone = $('input[name="phone"]').val();
        var type = $('input[name="type"]').val();
        var _token = $('input[name="_token"]').val();
        var error_message = $('.binding-pop .error-message').html();

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
                    $('.binding-pop .error-message').html(showError(data));
                }
            });
        }
    });

    function bindingForm() {
        var opt = {data: {}};
        service.bindPhone({
            data: $('#binding-form').serialize(),
            beforeSend: function () {
                $loadingPop.showPop(opt);
            },
            sucFn: function (data, status, xhr) {
                $loadingPop.closePop();
                window.location.reload();
            },
            errFn: function (data, status, xhr) {
                $loadingPop.closePop();
                $('.binding-pop .error-message').html(showError(data));
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
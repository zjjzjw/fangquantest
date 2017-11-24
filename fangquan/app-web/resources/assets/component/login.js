module.exports = (function ($) {

    var Popup = require('./popup');
    var service = require('../service/auth/userService');


    function Login(options) {
        $.inherit(this, $.Observer);
        this.init();
    }

    Login.prototype.init = function () {

        $loginPop = new Popup({
            width: 600,
            height: 520,
            contentBg: '#fff',
            maskColor: '#000',
            maskOpacity: '0.6',
            content: $('#loginTpl').html()
        });


        $.validate({
            form: '#login_form',
            validateOnBlur: false,
            scrollToTopOnError: false,
            onSuccess: function ($form) {
                moreValidate();
                return false;
            }
        });

        function moreValidate() {
            var opt = {data: {}};


            service.login({
                data: $('#login_form').serialize(),
                params: $.params,
                sucFn: function (data, status, xhr) {
                    $loginPop.closePop();
                    window.location.reload();
                },
                errFn: function (data, status, xhr) {
                    $('.msg-message').html(showError(data));
                }
            });
        }

        //登录
        $(document).on('click', '.hint-close .iconfont', function () {
            $loginPop.closePop();
        });
    };


    Login.prototype.closePop = function () {
        $loginPop.closePop();
    };


    Login.prototype.showPop = function (opt) {
        $loginPop.showPop(opt)
    };


    function showError(data) {
        var info = '';
        var messages = [];
        var i = 0;
        for (var key in data) {
            messages.push(data[key][0]);
        }
        info = messages.join('</br>');
        return info;
    }


    return Login;

})(jQuery);
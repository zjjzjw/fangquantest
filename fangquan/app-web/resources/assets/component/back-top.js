module.exports = (function ($) {
    var service = require('../service/backTopService');

    function feedback(options) {

        $.validate({
            form: '#user-feedback',
            validateOnBlur: false,
            scrollToTopOnError: false,
            onSuccess: function ($form) {
                moreValidate();
                return false;
            }
        });

        function moreValidate() {

            var opt = {data: {}};
            service.store({
                data: $('#user-feedback').serialize(),
                params: $.params,
                sucFn: function (data, status, xhr) {
                    $(".feedback-box").hide();
                },
                errFn: function (data, status, xhr) {
                    $('.text').html(showError(data));
                }
            });
        }

        function statInputNum(textArea, numItem) {
            var max = numItem.text(),
                curLength;
            textArea[0].setAttribute("maxlength", max);
            curLength = textArea.val().length;
            numItem.text(curLength);
            textArea.on('input propertychange', function () {
                var _value = $(this).val().replace(/\n/gi, "");
                numItem.text(_value.length);
            });
        }

        // 文本域限制文字数量
        var textarea = $("#textarea"),
            textArea = textarea.find("textarea"),
            totalNum = textarea.find(".area");

        if (textarea[0]) {
            statInputNum(textArea, totalNum);
        }

        //反馈
        $(document).on('click', '.feedback', function () {
            $(".feedback-box").show();
        });

        // 返回顶部

        $(document).on("click", ".backTop", function () {
            $('html,body').animate({scrollTop: 0}, 500)
        });

        // //关闭该窗口
        $(document).on("click", ".close", function () {
            console.log(1);
            $(".feedback-box").hide();
        });

    }

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

    return feedback;

})(jQuery);

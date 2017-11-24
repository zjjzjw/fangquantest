define(['zepto'],
    function ($) {
        var List = function () {
            var self = this;
            self.init();
        };
        List.prototype.init = function () {
            var self = this;

            //筛选
            $('.parentup').on('click', function () {
                if ($(this).hasClass('high')) {
                    $('.parentup').removeClass('high');
                    $('.g-touchicon-l').addClass('revolve');
                    $('#dialog').hide();
                    $('.optionlist').hide();
                } else {
                    $('.parentup').removeClass('high');
                    $('.g-touchicon-l').addClass('revolve');
                    $(this).addClass('high');

                    $(this).next().removeClass('revolve');
                    $(this).next().next().show();

                    $('#dialog').show();
                    $('.optionlist').show();
                    //区分筛选条件
                    var type = $(this).data('type');
                    $('.menunav-info').eq(type).show().siblings().hide();
                }
            });
            //点击灰色区域隐藏浮层
            $('#dialog').on('click', function () {
                $('.parentup').removeClass('high');
                $('.g-touchicon-l').addClass('revolve');
                $('.optionlist').hide();
                $(this).hide();
            });
        };
        new List();
    }
);

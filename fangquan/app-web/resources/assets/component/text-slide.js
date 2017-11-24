module.exports = (function($) {
    function textSlide(arg) {
            var handler;
            var distance;
            // 自定义
            var defaults = {
                element: '#main',//元素
                is_show: true,//是否显示图标
                speed: 2000,//运行速度
                child_element: '',
                height: ''
            };
            //          合并
            var options = $.extend(defaults, arg);
            var oli = $(options.element).find(options.child_element + ' >li').first().html();
            var one_height = $(options.element).find(options.child_element + ' >li').first().height();
            $(options.element).find(options.child_element).append('<li>' + oli + '</li>');
            // 是否显示图标
            if (!options.is_show) {
                $(options.element + ' >a').hide();
            }
            // 总个数
            var num = $(options.element).find(options.child_element + ' >li').length;
            $(options.child_element).css({'height': num * one_height + 'px'})
            if (options.height) {
                distance = options.height;
            } else {
                distance = $(options.element).find(options.child_element + ' >li').first().outerHeight();
            }
            var initial = 0;
            // 状态
            var sta = 1;
            // 数字自动填充
            $('.num').html(1 + '/' + (num - 1));

            function move() {
                sta = 0;
                initial++;
                if (initial == num) {
                    $(options.element).find(options.child_element).css('top', 0 + 'px');
                    initial = 1;
                }
                var sum = -distance * initial;
                $(options.element).find(options.child_element).animate({top: sum + "px"}, 500, function () {
                    sta = 1;
                });
                var n = 0;
                if (initial < num - 1) {
                    n = initial + 1;
                } else {
                    n = 1;
                }
                $('.num').html(n + '/' + (num - 1));

            }


            handler = setInterval(move, options.speed);
            $(options.element).mouseover(function () {
                clearInterval(handler);
            });

            $(options.element).mouseout(function () {
                handler = setInterval(move, options.speed);
            })
        }
    return textSlide;
})(jQuery);
module.exports = (function($) {
    function carousel(arg) {
            var handler;
            var distance;
            // 自定义
            var defaults = {
                element: '#main',//元素
                is_show: true,//是否显示图标
                speed: 2000,//运行速度
                child_element: '',
                width: ''
            };
            //          合并
            var options = $.extend(defaults, arg);
            var oli = $(options.element).find(options.child_element + ' >li').first().html();
            var one_width = $(options.element).find(options.child_element + ' >li').first().width();
            $(options.element).find(options.child_element).append('<li>' + oli + '</li>');
            // 是否显示图标
            if (!options.is_show) {
                $(options.element + ' >a').hide();
            }
            // 总个数
            var num = $(options.element).find(options.child_element + ' >li').length;
            $(options.child_element).css({'width': num * one_width + 'px'})
            if (options.width) {
                distance = options.width;
            } else {
                distance = $(options.element).find(options.child_element + ' >li').first().outerWidth();
            }
            var initial = 0;
            // 状态
            var sta = 1;
            // 数字自动填充
            $('.num').html(1 + '/' + (num - 1));
            // 左按钮
            // 左边按钮点击
            $(options.element).find('.btnR').click(function () {
                clearInterval(handler);
                if (sta == 1) {
                    move();
                }
            });

            function move() {
                sta = 0;
                initial++;
                if (initial == num) {
                    $(options.element).find(options.child_element).css('left', 0 + 'px');
                    initial = 1;
                }
                var sum = -distance * initial;
                $(options.element).find(options.child_element).animate({left: sum + "px"}, 500, function () {
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

            // 右边按钮
            $(options.element).find('.btnL').click(function () {
                clearInterval(handler);
                if (sta == 1) {//如果不等于1，就表示元素正在运动状态，后面的代码都不执行
                    sta = 0;//运动状态
                    initial--;
                    if (initial == -1) {
                        $(options.element).find(options.child_element).css('left', -distance * num + distance);
                        initial = num - 2;
                    }
                    var sum = initial * -distance;
                    $(options.element).find(options.child_element).animate({left: sum + 'px'}, 500, function () {
                        sta = 1;
                    });
                    if (initial < 3) {
                        n = initial + 1;
                    } else {
                        n = 1;
                    }
                    $('.num').html(n + '/' + (num - 1));
                }
            });

            handler = setInterval(move, options.speed);
            $(options.element).mouseover(function () {
                clearInterval(handler);
            });

            $(options.element).mouseout(function () {
                handler = setInterval(move, options.speed);
            })
        }
    return carousel;
})(jQuery);
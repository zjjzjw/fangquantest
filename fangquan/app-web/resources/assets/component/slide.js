module.exports = (function($) {
    function slide(obj) {
            var self = this;
            var i = 0; //图片标识
            var img_num = obj.children("li").length; //图片个数
            console.log('总共图片' + img_num);
            $(".img_ul_pop li").hide(); //初始化图片
            $(".img_ul_pop li:first-of-type").show();
            play();
            slideEach();
            function slideEach() {
                $(".img_hd_pop ul").css("width", ($(".img_hd_pop ul li").outerWidth(true)) * img_num); //设置小图ul的长度
                $(".bottom_a").css("opacity", 0.7); //初始化底部a透明度
                if (!window.XMLHttpRequest) {//对ie6设置a的位置
                    $(".change_a").css("height", $(".change_a").parent().height());
                }

                $(".change_a").focus(function () {
                    this.blur();
                });
                $(".bottom_a").hover(function () {//底部a经过事件
                    $(this).css("opacity", 1);
                }, function () {
                    $(this).css("opacity", 0.7);
                });

                $(".img_hd_pop ul li").click(function () {//大小图
                    i = $(this).index();
                    play();
                    console.log(1);
                });

                $(".prev_a_click").click(function () {
                    // i+=img_num;
                    i--;
                    //i=i%img_num;
                    i = (i < 0 ? 0 : i);
                    play();
                    console.log(2);
                });
                $(".next_a_click").click(function () {
                    i++;
                    // i=i%img_num;
                    i = (i > (img_num - 1) ? (img_num - 1) : i);
                    play();
                    console.log(3);
                });
            }

            function play() {//动画移动
                var img = new Image(); //图片预加载
                img.onload = function () {
                    img_load(img, $(".img_ul_pop").children("li").eq(i).find("img"));
                };
                img.src = $(".img_ul_pop").children("li").eq(i).find("img").attr("src");
                console.log('我是url' + img.src);
                $(".img_hd_pop ul").children("li").eq(i).addClass("on").siblings().removeClass("on");
                if (img_num > 6) {//大于6个的时候进行移动
                    if (i < img_num - 3) { //前3个
                        $(".img_hd_pop ul").css({"left": (-($(".img_hd_pop ul li").outerWidth() + 4) * (i - 3 < 0 ? 0 : (i - 3)))});
                    } else if (i >= img_num - 3) {//后3个
                        $(".img_hd_pop ul").css({"left": (-($(".img_hd_pop ul li").outerWidth() + 4) * (img_num - 6))});
                    }
                }
            }

            function img_load(img_id, now_imgid) {//大图片加载设置 （img_id 新建的img,now_imgid当前图片）
                if (img_id.width / img_id.height > 1) {
                    if (img_id.width >= $("#play").width())
                        $(now_imgid).width($("#play").width());
                } else {
                    if (img_id.height >= 500) $(now_imgid).height(500);
                }
                $(".img_ul_pop").children("li").eq(i).show().siblings("li").hide(); //大小确定后进行显示
            }
        };
    return slide;
})(jQuery);
module.exports = (function($) {
    function Slide(obj) {
        $.inherit(this, $.Observer);
        this.init();
        this.initEvent();
    };
    Slide.prototype.init = function(){
        var self = this;
    };
    Slide.prototype.initEvent = function(){
        var self = this;
        var i = 0; //图片标识
        var img_num = self.opts.children("li").length; //图片个数
        console.log(img_num);
        self.find('.img_ul').find('li').hide(); //初始化图片
        // $(".img_ul li:first-of-type").show();
        // $(".img_hd ul").css("width", ($(".img_hd ul li").outerWidth(true)) * img_num); //设置小图ul的长度
        // $(".bottom_a").css("opacity", 0.7); //初始化底部a透明度
        // if (!window.XMLHttpRequest) {//对ie6设置a的位置
        //     $(".change_a").css("height", $(".change_a").parent().height());
        // }

        // $(".change_a").focus(function () {
        //     this.blur();
        // });
        // $(".bottom_a").hover(function () {//底部a经过事件
        //     $(this).css("opacity", 1);
        // }, function () {
        //     $(this).css("opacity", 0.7);
        // });

        // $(".img_hd ul li").click(function () {
        //     i = $(this).index();
        //     play();
        // });

        // $(".prev_a").click(function () {
        //     // i+=img_num;
        //     i--;
        //     //i=i%img_num;
        //     i = (i < 0 ? 0 : i);
        //     play();
        // });
        // $(".next_a").click(function () {
        //     i++;
        //     // i=i%img_num;
        //     i = (i > (img_num - 1) ? (img_num - 1) : i);
        //     play();
        // });
    };

        // function play() {//动画移动
        //     var img = new Image(); //图片预加载
        //     img.onload = function () {
        //         img_load(img, $(".img_ul").children("li").eq(i).find("img"));
        //     };
        //     img.src = $(".img_ul").children("li").eq(i).find("img").attr("src");
        //     console.log('我是url' + img.src);
        //     $(".img_hd ul").children("li").eq(i).addClass("on").siblings().removeClass("on");
        //     if (img_num > 6) {//大于6个的时候进行移动
        //         if (i < img_num - 3) { //前3个
        //             $(".img_hd ul").css({"left": (-($(".img_hd ul li").outerWidth() + 4) * (i - 3 < 0 ? 0 : (i - 3)))});
        //         } else if (i >= img_num - 3) {//后3个
        //             $(".img_hd ul").css({"left": (-($(".img_hd ul li").outerWidth() + 4) * (img_num - 6))});
        //         }
        //     }
        // }

        // function img_load(img_id, now_imgid) {//大图片加载设置 （img_id 新建的img,now_imgid当前图片）
        //     if (img_id.width / img_id.height > 1) {
        //         if (img_id.width >= $("#play").width())
        //             $(now_imgid).width($("#play").width());
        //     } else {
        //         if (img_id.height >= 500) $(now_imgid).height(500);
        //     }
        //     $(".img_ul").children("li").eq(i).show().siblings("li").hide(); //大小确定后进行显示
        // }
    return Slide;
})(jQuery);
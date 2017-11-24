$(function () {
    require('../../component/exhibition-header');
    var swiper = require('../../component/swiper');
    //大图轮播
    $("#top-pic .img-box li:eq(0)").appendTo($("#top-pic .img-box"));
    var mySwiper = new Swiper('.swiper-container1', {
        autoplay: 2000,
        speed: 5000,
        loop: true
    });


});
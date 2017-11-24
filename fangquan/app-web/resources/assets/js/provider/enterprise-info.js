$(function () {
    var Popup = require('../../component/popup');
    var Slide = require('../../component/slide');
    var swiper = require('../../component/swiper')
    //企业大图轮播
     $("#top-pic .img-box li:eq(0)").appendTo($("#top-pic .img-box"))
    var mySwiper =new Swiper('.swiper-container1',{
    
     autoplay: 2000,
     speed:800,
     loop: true 
      
       
     })
 

    $('.top-pic .img-box li').find('img').css({'vertical-align': 'middle'});
    //工厂照片
    $factiryTpl = new Popup({
        width: 840,
        height: 600,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#factiryTpl').html()
    });
    $(document).on('click', '.factiry-img-box', function () {
        var opt = {data: {}};
        $("body").css({"overflow": "hidden"});
        $factiryTpl.showPop(opt);
        var obj = $('.factiry-slide');
        $('.factiry-detail').find('.next_a').addClass('next_a_click');
        $('.factiry-detail').find('.prev_a').addClass('prev_a_click');
        $('.factiry-detail').find('.img_ul').addClass('img_ul_pop');
        $('.factiry-detail').find('.img_hd').addClass('img_hd_pop');
        if (obj.find('li').length > 0) {
            Slide(obj);
        }
        $(document).keydown(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '27') {
                $factiryTpl.closePop();``
                $('.factiry-detail').find('.next_a_click').removeClass('next_a_click');
                $('.factiry-detail').find('.img_ul_pop').removeClass('img_ul_pop');
                $('.factiry-detail').find('.img_hd_pop').removeClass('img_hd_pop');
                $('.factiry-detail').find('.prev_a_click').removeClass('prev_a_click');
            }
        });
    });
    $(document).on('click', '.close-factiry-box', function () {
        $factiryTpl.closePop();
        $('.factiry-detail').find('.next_a_click').removeClass('next_a_click');
        $('.factiry-detail').find('.img_ul_pop').removeClass('img_ul_pop');
        $('.factiry-detail').find('.img_hd_pop').removeClass('img_hd_pop');
        $('.factiry-detail').find('.prev_a_click').removeClass('prev_a_click');
    });
    //设备照片
    $deviceTpl = new Popup({
        width: 840,
        height: 600,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#deviceTpl').html()
    });
    $(document).on('click', '.device-img-box', function () {
        var opt = {data: {}};
        $("body").css({"overflow": "hidden"});
        $deviceTpl.showPop(opt);
        var obj = $('.device-slide');
        $('.device-detail').find('.next_a').addClass('next_a_click');
        $('.device-detail').find('.prev_a').addClass('prev_a_click');
        $('.device-detail').find('.img_ul').addClass('img_ul_pop');
        $('.device-detail').find('.img_hd').addClass('img_hd_pop');
        if (obj.find('li').length > 0) {
            Slide(obj);
        }
        $(document).keydown(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '27') {
                $deviceTpl.closePop();
                $('.device-detail').find('.next_a_click').removeClass('next_a_click');
                $('.device-detail').find('.img_ul_pop').removeClass('img_ul_pop');
                $('.device-detail').find('.img_hd_pop').removeClass('img_hd_pop');
                $('.device-detail').find('.prev_a_click').removeClass('prev_a_click');
            }
        });
    });
    $(document).on('click', '.close-device-box', function () {
        $deviceTpl.closePop();
        $('.device-detail').find('.next_a_click').removeClass('next_a_click');
        $('.device-detail').find('.img_ul_pop').removeClass('img_ul_pop');
        $('.device-detail').find('.img_hd_pop').removeClass('img_hd_pop');
        $('.device-detail').find('.prev_a_click').removeClass('prev_a_click');
    });
    //企业证书
    $certificateTpl = new Popup({
        width: 840,
        height: 600,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#certificateTpl').html()
    });
    $(document).on('click', '.certificate li', function () {
        var opt = {data: {}};
        var toIndex = $(this).data('index');
        $certificateTpl.showPop(opt);
        $("body").css({"overflow": "hidden"});
        $('.certificate-detail').each(function(){
            if($(this).data('index') == toIndex){
                $(this).show();
                var obj = $(this).find('.certificate-slide');
                $(this).find('.next_a').addClass('next_a_click');
                $(this).find('.prev_a').addClass('prev_a_click');
                $(this).find('.img_ul').addClass('img_ul_pop');
                $(this).find('.img_hd').addClass('img_hd_pop');
                if (obj.find('li').length > 0) {
                    Slide(obj);
                }
            }
        });
    });
    $(document).on('click', '.close-certificate-box', function () {
        $certificateTpl.closePop();
        $('.certificate-detail').hide();
        $('.certificate-detail').find('.next_a_click').removeClass('next_a_click');
        $('.certificate-detail').find('.img_ul_pop').removeClass('img_ul_pop');
        $('.certificate-detail').find('.img_hd_pop').removeClass('img_hd_pop');
        $('.certificate-detail').find('.prev_a_click').removeClass('prev_a_click');
    });
    //战略合作开发商
    var mySwiper =new Swiper('.swiper-container2',{
     
     autoplay: 2000,
     speed:800,
     loop: true ,
     nextButton: '.swiper-button-next',
     prevButton: '.swiper-button-prev',
       
     })
    //企业介绍查看全部
    var $commDesc = $('.bussiness-produce em');
    var $openCommDesc = $('.open-comm-desc');
    var $commDescStr = $commDesc.html();
    if ($commDescStr.length > 175) {
        $commDesc.html($commDescStr.substring(0, 165) + '...');
        $openCommDesc.show();
        $openCommDesc.click(function () {
            $commDesc.html($commDescStr);
            $openCommDesc.hide();
        });
    }

});
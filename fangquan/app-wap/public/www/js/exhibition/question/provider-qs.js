define([
    'zepto', 'app/service/exhibitionService'
], function ($, service) {
    'use strict';

    var answer = [];
    var numlength = [];
    var reg = /^1\d{10}$/;

    $('.qs-ans').on('click', function () {
        if ($(this).children('i').hasClass('checked')) {
            $(this).children('i').removeClass('checked');
            $(this).children('i').html('&#xe600;');
            $(this).removeClass('other-checked');
        } else if ($(this).hasClass('other')) {
            $(this).addClass('other-checked');
            $(this).children('i').addClass('checked');
            $(this).children('i').html('&#xe633;');
        } else {
            $(this).children('i').addClass('checked');
            $(this).children('i').html('&#xe633;');
        }
    });

    $('.other input').click(function (event) {
        $(this).parent().addClass('other-checked');
        $(this).parent().children('i').addClass('checked');
        $(this).parent().children('i').html('&#xe633;');
        var event = event || window.event;
        event.stopPropagation();
    });
    //联系人信息
    $('.connect-self').on('click',function(){
        if($(this).children('i').hasClass("connect-checked")){
            $(this).children('i').removeClass('connect-checked');
            $(this).children('i').html('&#xe672;');
            $('.connect-other').children('i').html('&#xe606;');
            $('.connect-other').children('i').addClass("connect-checked");
        }else{
            $(this).children('i').html('&#xe606;');
            $(this).children('i').addClass("connect-checked");
            $('.connect-other').children('i').html('&#xe672;');
            $('.connect-other').children('i').removeClass("connect-checked");
        }
    });
    $('.connect-other').on('click',function(){
        if($(this).children('i').hasClass("connect-checked")){
            $(this).children('i').removeClass('connect-checked');
            $(this).children('i').html('&#xe672;');
            $('.connect-self').children('i').html('&#xe606;');
            $('.connect-self').children('i').addClass("connect-checked");
        }else{
            $(this).children('i').html('&#xe606;');
            $(this).children('i').addClass("connect-checked");
            $('.connect-self').children('i').html('&#xe672;');
            $('.connect-self').children('i').removeClass("connect-checked");
        }
    });

    $('.reason').on('click',function(){
        if($(this).children('i').hasClass("reason-checked")){
            $(this).children('i').removeClass('reason-checked');
            $(this).children('i').html('&#xe600;');
        }else{
            $(this).children('i').addClass('reason-checked');
            $(this).children('i').html('&#xe633;');
        }
    });
    $('.main-btn').on('click', function () {
        var is_jump = $(this).parent().find('.checked').length;
        var is_other = $(this).parent().find('.other-checked').length;
        if (is_other > 0) {
            if ($(this).parent().find('input').val() == '') {
                $(this).prev().html("请在其他栏填写内容");
            } else {
                $(this).parent().find('.checked').each(function () {
                    var ans = $(this).parent().find('.checked').data('val');
                    answer.push(ans);
                });
                var other_ans = $(this).parent().find('input').val();
                answer.push(other_ans);
                numlength.push(is_jump + 1);
                $(this).prev().html("");
                $(this).parent().hide();
                $(this).parent().next().show();
            }
        } else if (is_jump <= 0) {
            $(this).prev().html("请至少选择一个");
        } else {
            $(this).parent().find('.checked').each(function () {
                var ans = $(this).parent().find('.checked').data('val');
                answer.push(ans);
            });
            numlength.push(is_jump);
            $(this).prev().html("");
            $(this).parent().hide();
            $(this).parent().next().show();
        }
    });
    $('.result-btn').on('click', function () {
        var name = $('.name').val(),
            phone = $('.phone').val(),
            job = $('.job').val(),
            reason = $('.txt-reason').val();
        var connect_info = [
            {
                'name': name
            },
            {
                'phone': phone
            },
            {
                'job': job
            },
            {
                'reason': reason
            }
        ];
        if($(this).parent().find('i').hasClass('reason-checked')&& reason==''){
            $(this).prev().html("不参加活动原因勾选必填");
        }else if($('.connect-checked').data('val') == 2){
            if(name==''){
                $(this).prev().html("姓名必填");
            }else if(phone == ''){
                $(this).prev().html("联系方式必填");
            }else if(!reg.test(phone)){
                $(this).prev().html("联系方式为11位手机号");
            }else if(job == ''){
                $(this).prev().html("职位必填");
            }else{
                answer.push(connect_info);
                numlength.push(1);
                service.exhibitionQs(
                    {
                        data: {
                            id: 0,
                            type: 'developer',
                            answer: answer,
                            num: numlength
                        },
                        sucFn: function () {
                            window.location.href = '/exhibition/gather/shadowe';
                        },
                        errFn: function () {
                            window.location.href = '/exhibition/gather/shadowe';
                        }
                    }
                );
            }
        }else{
            answer.push(connect_info);
            numlength.push(1);
            service.exhibitionQs(
                {
                    data: {
                        id: 0,
                        type: 'developer',
                        answer: answer,
                        num: numlength
                    },
                    sucFn: function () {
                        window.location.href = '/exhibition/gather/shadowe';
                    },
                    errFn: function () {
                        window.location.href = '/exhibition/gather/shadowe';
                    }
                });
        }
    });
});
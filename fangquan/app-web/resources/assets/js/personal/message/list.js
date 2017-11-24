$(function () {


    var Popup = require('./../../../component/popup');
    var service = require('../../../service/personal/messageService');

    $loadingPop = new Popup({
        width: 128,
        height: 128,
        contentBg: 'transparent',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#loadingTpl').html()
    });

    $(document).on('click', '.right-box li', function () {
        var opt = {data: {}};
        var msg_id = $('.right-box li').data('id');
        var _token = $('input[name="_token"]').val();

        $(this).toggleClass("active");
        //加号变减号
        var has_active = $(this).hasClass('active');
        if (has_active) {
            $(this).find('.push').html('&#xe613;');
        } else {
            $(this).find('.push').html('&#xe623;');
        }
        //未读状态
        var has_read = $(this).find('p').hasClass('unread');
        if (has_read) {
            $(this).find('p').removeClass('unread');

            service.setRead({
                data: {msg_id: msg_id, _token: _token},
                beforeSend: function () {
                    $loadingPop.showPop(opt);
                },
                sucFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                },
                errFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $('.error-message').html(showError(data));
                }
            });
        }
    });

    function showError(data) {
        var info = '';
        var messages = [];
        var i = 0;
        for (var key in data) {
            messages.push(++i + "、" + data[key][0]);
        }
        info = messages.join('</br>');
        return info;
    }


});
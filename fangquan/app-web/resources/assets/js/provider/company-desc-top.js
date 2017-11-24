$(function () {
    var Popup = require('./../../component/popup');
    var temp = require('./../../component/temp');
    var service = require('../../service/provider/providerService');
    var LoginPop = require('./../../component/login');

    $login_pop = new LoginPop();
    //查看联系方式
    $(document).on('click', '.contact-info', function () {
        var opt = {data: {}};
        if ($.params.login_info.id) {
            service.contact({
                data: {
                    provider_id: $.params.provider_id,
                },
                sucFn: function (data, status, xhr) {
                    var html = temp('contact_list_tpl', {'contacts': data});
                    $('.change-info').html(html);
                    $('.contact-info').hide();
                },
                errFn: function (data, status, xhr) {
                }
            });
        }
        else {
            $login_pop.showPop(opt)
        }
    });
    //收藏
    $(document).on("click", ".collection", function () {
        var opt = {data: {}};
        if ($.params.login_info.id) {
            var data_id = $(this).data('id');
            service.collect({
                data: {
                    id: 0,
                    provider_id: data_id,
                    _token: $.params.token
                },
                sucFn: function (data, status, xhr) {
                    window.location.reload();
                },
                errFn: function (data, status, xhr) {
                }
            })
        }
        else {
            $login_pop.showPop(opt);
        }
    });

    //取消收藏
    $(document).on("click", ".close-collection", function () {
        var opt = {data: {}};
        if ($.params.login_info.id) {
            var data_id = $(this).data('id');
            service.cancel({
                data: {
                    id: 0,
                    provider_id: data_id,
                    _token: $.params.token
                },
                sucFn: function (data, status, xhr) {
                    window.location.reload();
                },
                errFn: function (data, status, xhr) {
                }
            })
        }
        else {
            $login_pop.showPop(opt);
        }
    });


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
});
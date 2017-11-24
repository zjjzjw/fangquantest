$(function () {
    var service = require('../../../service/provider/providerSchemeService');
    //收藏
    $(document).on("click", ".product-collection", function () {
        var opt = {data: {}};
        if ($.params.login_info.id) {
            var data_id = $(this).data('id');
            service.collect({
                data: {
                    id: 0,
                    product_programme_id: data_id,
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
    $(document).on("click", ".close-product-collection", function () {
        var opt = {data: {}};
        if ($.params.login_info.id) {
            var data_id = $(this).data('id');
            service.cancel({
                data: {
                    id: 0,
                    product_programme_id: data_id,
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
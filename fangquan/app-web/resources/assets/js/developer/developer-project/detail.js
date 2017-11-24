$(function () {
    var Popup = require('./../../../component/popup');
    var temp = require('./../../../component/temp');
    var service = require('../../../service/developer/developerProjectService');
    var LoginPop = require('./../../../component/login');

    $login_pop = new LoginPop();

    $contactPop = new Popup({
        width: 560,
        height: 260,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#contactTpl').html()
    });

    //联系人
    $(document).on('click', '.contact-title', function () {
        $contactPop.closePop();
    });


    //查看联系人
    $(document).on('click', '.contact-way', function () {
        var opt = {data: {}};
        var project_contact = $.params.project_contact;
        if ($.params.login_info.id) {
            if ($.params.login_info.account_type == 0) {
                $contactPop.showPop(opt);
            } else {
                service.contact({
                    data: {
                        project_id: $.params.developer_project_id,
                    },
                    sucFn: function (data, status, xhr) {
                        var html = temp('contact_list_tpl', {'contacts': data});
                        if (data.length == 0) {
                            $('.contact-list').html('<h2>暂无数据</h2>');
                        } else {
                            $('.contact-list').html(html);
                        }
                    },
                    errFn: function (data, status, xhr) {
                        $('.contact-content .text').html(showError(data));
                        $contactPop.showPop(opt);
                    }
                });
            }
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
                data: {id: data_id, _token: $.params.token},
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
                data: {id: data_id, _token: $.params.token},
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


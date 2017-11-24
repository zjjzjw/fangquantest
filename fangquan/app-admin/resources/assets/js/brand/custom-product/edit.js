$(function () {
    var Popup = require('../../../component/popup');
    var service = require('./../../../service/brand/brandCustomProductService');
    var Search = require('./../../../component/search');
    $successPop = new Popup({
        width: 200,
        height: 150,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#successTpl').html()
    });
    $loadingPop = new Popup({
        width: 128,
        height: 128,
        contentBg: 'transparent',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#loadingTpl').html()
    });

    $promptPop = new Popup({
        width: 400,
        height: 225,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#promptTpl').html()
    });

    $.validate({
        form: '#form',
        validateOnBlur: false,
        onSuccess: function ($form) {
            moreValidate();
            return false;
        }
    });

    $("#developer-keyword").keydown(function () {
        if (event.keyCode == 8) {
            $('input[name="developer_id"]').val(0);
        }
    });

    $("#project-keyword").keydown(function () {
        if (event.keyCode == 8) {
            $('input[name="loupan_id"]').val(0);
        }
    });

    function moreValidate() {
        var error_developer = $('input[name="developer_id"]').val();
        var error_loupan = $('input[name="loupan_id"]').val();

        if (error_developer == 0) {
            $('.error-tip-developer').show();
        } else if (error_loupan == 0) {
            $('.error-tip-developer').hide();
            $('.error-tip-loupan').show();
        } else if (parseInt($.params.id) == 0) {
            $('.error-tip-developer').hide();
            $('.error-tip-loupan').hide();
            var opt = { data: {} };
            service.store({
                data: $('#form').serialize(),
                params: $.params,
                beforeSend: function () {
                    $loadingPop.showPop(opt);
                },
                sucFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $successPop.showPop(opt);
                    setTimeout(skipUpdate, 2000);

                    function skipUpdate() {
                        $successPop.closePop();
                        window.location.href = '/brand/' + $.params.brand_id + '/custom-product/index';
                    }
                },
                errFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $('.text').html(showError(data));
                    $promptPop.showPop(opt);
                }
            });
        } else {
            $('.error-tip-developer').hide();
            $('.error-tip-loupan').hide();
            var opt = { data: {} };
            service.update({
                data: $('#form').serialize(),
                params: $.params,
                beforeSend: function () {
                    $loadingPop.showPop(opt);
                },
                sucFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $successPop.showPop(opt);
                    setTimeout(skipUpdate, 2000);

                    function skipUpdate() {
                        $successPop.closePop();
                        window.location.href = '/brand/' + $.params.brand_id + '/custom-product/index';
                    }
                },
                errFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $('.text').html(showError(data));
                    $promptPop.showPop(opt);
                }
            });
        }
    }

    //开发商下拉功能
    var autoComplete = new Search({
        keyword: '#developer-keyword',
        resources: service.getDeveloperByKeyword
    });

    autoComplete.on('search_box_selected', function (data, event) {
        $("input[name='developer_id']").val(data.item.id);
        renderInfo.call(this, data, event);
    });

    //楼盘项目下拉功能
    var autoComplete = new Search({
        keyword: '#project-keyword',
        resources: service.getLoupanByKeyword
    });

    autoComplete.on('search_box_selected', function (data, event) {
        $("input[name='loupan_id']").val(data.item.id);
        renderInfo.call(this, data, event);
    });

    autoComplete.on('search_box_focus', function (data, event) {
        renderInfo.call(this, data, event);
    });

    function renderInfo(data, event) {
        var item = data.item;
    }

    $(document).on('click', '#pop_close', function () {
        $promptPop.closePop();
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
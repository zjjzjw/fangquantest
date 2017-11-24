$(function () {
    var Popup = require('../../../component/popup');
    var Search = require('./../../../component/search');
    var service = require('../../../service/fqUser/fqUserService');

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

    function moreValidate() {
            var opt = {data: {}};
            service.relevanceProvider({
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
                        window.location.href = '/fq-user/fq-user/index';
                    }
                },
                errFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $('.text').html(showError(data));
                    $promptPop.showPop(opt);
                }
            });
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

    //选择企业类型
    //下拉联想
    $("#select-input").change(function(){
        changeValue();
    });
    function changeValue() {
        var value_s = $("#select-input").val();
        var url = '';
        if(value_s=="2"){
            url = service.getProviderByKeyword;
        }else if(value_s=="3"){
            url = service.getDeveloperByKeyword;
        }
        var autoComplete = new Search({
            keyword: '#keyword',
            resources: url
        });
        autoComplete.on('search_box_selected', function (data, event) {
            $("input[name='relevance_id']").val(data.item.id);
            renderInfo.call(this, data, event);
        });

        autoComplete.on('search_box_focus', function (data, event) {
            renderInfo.call(this, data, event);
        });

        function renderInfo(data, event) {
            var item = data.item;
            $("#keyword").attr('data-relevance_id', item.id);
        }
    }
    changeValue();
});
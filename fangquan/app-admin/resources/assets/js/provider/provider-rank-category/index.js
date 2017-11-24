$(function () {
    var Popup = require('./../../../component/popup');
    var temp = require('./../../../component/temp');
    var Search = require('./../../../component/search');
    var service = require('./../../../service/provider/providerRankCategoryService');


    var data_id;
    $confirmPop = new Popup({
        width: 400,
        height: 225,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#confirmTpl').html()
    });
    $promptPop = new Popup({
        width: 400,
        height: 225,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#promptTpl').html()
    });

    $('.delete').on('click', function () {
        data_id = $(this).data('id');
        var opt = {data: {}};
        $confirmPop.showPop(opt);
        $('.text').html("确定要删除吗？");
        return false;
    });
    $(document).on('click', '#dialog_cancel', function () {
        $confirmPop.closePop();
    });
    $(document).on('click', '#dialog_confirm', function () {
        var opt = {data: {}};
        service.delete({
            data: {id: data_id},
            sucFn: function (data, status, xhr) {
                $confirmPop.closePop();
                window.location.reload();
                $('.text').html("确定要删除吗？");
            },
            errFn: function (data, status, xhr) {
                $confirmPop.closePop();
                $('.text').html(showError(data));
                $promptPop.showPop(opt);
            }
        });
    });
    $(document).on('click', '#pop_close', function () {
        $promptPop.closePop();
        $('.text').html("确定要删除吗？");
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

    //下拉功能
    var autoComplete = new Search({
        keyword: '#keyword',
        resources: service.getProviderByKeyword
    });

    autoComplete.on('search_box_selected', function (data, event) {
        renderInfo.call(this, data, event);
    });

    autoComplete.on('search_box_focus', function (data, event) {
        renderInfo.call(this, data, event);
    });

    function renderInfo(data, event) {
        var item = data.item;
        $("#keyword").attr('data-provider_id', item.id);
    }


    $('.btn').click(function () {
        var keyword = $('input[name="keyword"]').val();
        var provider_id = $('#keyword').data('provider_id');
        var category_id = $('select[name="category_id"]').val();

        window.location.href = '/provider/provider-rank-category/index?provider_id=' + provider_id + '&category_id=' + category_id;


    });
});
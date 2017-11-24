$(function () {
    var Search = require('./../../../component/search');
    var service = require('./../../../service/provider/providerService');

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
        var status = $('select[name="status"]').val();

        window.location.href = '/provider/provider-news/list?provider_id=' + provider_id + '&keyword=' + keyword + '&status=' + status;


    });
});
$(function () {
    var Search = require('./../../../component/search');
    var service = require('./../../../service/fqUser/fqUserService');

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
        $("#keyword").attr('data-company_id', item.id);
    }


    $('.btn').click(function () {
        var company_id = $('#keyword').data('company_id');
        var keyword = $('input[name="keyword"]').val();
        var account_type = $('#account_type').val();
        var platform_id = $('#platform_id').val();

        window.location.href = '/fq-user/fq-user/index?company_id=' + company_id + '&keyword=' + keyword + '&account_type=' + account_type + '&platform_id=' + platform_id;


    });
});
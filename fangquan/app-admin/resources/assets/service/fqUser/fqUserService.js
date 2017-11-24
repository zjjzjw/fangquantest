module.exports = (function () {

    var _store = function store(opts) {
        $.http({
            type: 'POST',
            url: '/api/fq-user/fq-user/store/' + opts.params.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    var _update = function update(opts) {
        $.http({
            type: 'POST',
            url: '/api/fq-user/fq-user/update/' + opts.params.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    var _setPassword = function (opts) {
        $.http({
            type: 'POST',
            dataType: 'json',
            url: '/api/fq-user/fq-user/set-password/' + opts.params.id,
            data: opts.data,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    var _relevanceProvider = function relevanceProvider(opts) {
        $.http({
            type: 'POST',
            url: '/api/fq-user/fq-user/relevance-provider/' + opts.params.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    var _getDeveloperByKeyword = function (opts) {
        $.http({
            type: 'GET',
            dataType: 'json',
            url: '/api/developer/developer/get-developer-keyword',
            data: opts.data,
            success: opts.success,
            error: opts.error
        });
    };

    var _getProviderByKeyword = function (oData) {

        $.http({
            type: 'GET',
            dataType: 'json',
            url: '/api/provider/provider/get-provider-keyword',
            data: oData.data,
            success: oData.success,
            error: oData.error
        });
    };

    return {
        store: _store,
        update: _update,
        setPassword: _setPassword,
        relevanceProvider:_relevanceProvider,
        getDeveloperByKeyword:_getDeveloperByKeyword,
        getProviderByKeyword:_getProviderByKeyword
    };
})();
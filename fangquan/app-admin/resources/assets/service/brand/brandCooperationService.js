module.exports = (function () {

    var _store = function store(opts) {
        $.http({
            type: 'POST',
            url: '/api/brand/brand-cooperation/store/' + opts.params.id,
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
            url: '/api/brand/brand-cooperation/update/' + opts.params.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    var _delete = function (opts) {
        $.http({
            type: 'POST',
            dataType: 'json',
            url: '/api/brand/brand-cooperation/delete/' + opts.data.id,
            data: opts.data,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    var _getDeveloperByKeyword = function (oData) {

        $.http({
            type: 'GET',
            dataType: 'json',
            url: '/api/developer/loupan/get-developer-keyword',
            data: oData.data,
            success: oData.success,
            error: oData.error
        });
    };

    return {
        store: _store,
        update: _update,
        delete: _delete,
        getDeveloperByKeyword:_getDeveloperByKeyword
    };
})();
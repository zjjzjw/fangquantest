module.exports = (function () {

    var _store = function store(opts) {
        $.http({
            type: 'POST',
            url: '/api/product/product/store/' + opts.params.id,
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
            url: '/api/product/product/update/' + opts.params.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    var _attribute = function attribute(opts) {
        $.http({
            type: 'POST',
            url: '/api/category/category/attribute/' + opts.data.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    var _secondLevel = function secondLevel(opts) {
        $.http({
            type: 'POST',
            url: '/api/category/category/second-level/' + opts.data.id,
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
            url: '/api/product/product/delete/' + opts.data.id,
            data: opts.data,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    var _getBrandByKeyword = function (oData) {
        $.http({
            type: 'GET',
            dataType: 'json',
            url: '/api/provider/provider/get-provider-keyword',
            data: oData.data,
            success: oData.success,
            error: oData.error
        });
    };
    var _commentdelete = function (opts) {
        $.http({
            type: 'POST',
            dataType: 'json',
            url: '/api/comment/comment/delete/' + opts.data.id,
            data: opts.data,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    return {
        store: _store,
        update: _update,
        attribute: _attribute,
        secondLevel: _secondLevel,
        delete: _delete,
        getBrandByKeyword: _getBrandByKeyword,
        commentdelete: _commentdelete
    };
})();
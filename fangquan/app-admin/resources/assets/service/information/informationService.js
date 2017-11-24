module.exports = (function () {

    var _store = function store(opts) {
        $.http({
            type: 'POST',
            url: '/api/information/information/store/' + opts.params.id,
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
            url: '/api/information/information/update/' + opts.params.id,
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
            url: '/api/information/information/delete/' + opts.data.id,
            data: opts.data,
            success: opts.sucFn,
            error: opts.errFn
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

    var _getProductByKeyword = function (oData) {

        $.http({
            type: 'POST',
            dataType: 'json',
            url: '/api/product/product/keyword',
            data: oData.data,
            success: oData.success,
            error: oData.error
        });
    };
    var _getBrandByKeyword = function (oData) {

        $.http({
            type: 'POST',
            dataType: 'json',
            url: '/api/brand/brand/keyword',
            data: oData.data,
            success: oData.success,
            error: oData.error
        });
    };

    var _processImage = function processImage(opts) {
        $.http({
            type: 'POST',
            url: '/api/information/information/process-image/' + opts.data.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    return {
        store: _store,
        update: _update,
        delete: _delete,
        commentdelete: _commentdelete,
        getProductByKeyword: _getProductByKeyword,
        getBrandByKeyword: _getBrandByKeyword,
        processImage: _processImage
    };
})();
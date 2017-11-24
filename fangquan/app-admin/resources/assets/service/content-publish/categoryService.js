module.exports = (function () {

    var _store = function store(opts) {
        $.http({
            type: 'POST',
            url: '/api/content/content-category/store/' + opts.data.id,
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
            url: '/api/content/content-category/update/' + opts.data.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    var _delete = function (opts) {
        $.http({
            type: 'GET',
            dataType: 'json',
            url: '/api/content/content-category/delete/' + opts.data.id,
            data: opts.data,
            success: opts.sucFn,
            error: opts.errFn
        });
    };

    var _getNextContentCategory = function getNextContentCategory(opts) {
        $.http({
            type: 'GET',
            dataType: 'json',
            url: '/api/content/content-category/get-next-content-category/' + opts.data.id,
            data: opts.data,
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    };


    return {
        store: _store,
        update: _update,
        delete:_delete,
        getNextContentCategory:_getNextContentCategory
    };
})();
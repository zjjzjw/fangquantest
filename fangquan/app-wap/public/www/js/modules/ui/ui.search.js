define("ui.search", ['zepto', 'zepto.sp', 'zepto.temp'], function ($, sp, temp) {
    "use strict";

    var Search = function (_op) {
        var self = this;
        self.op = $.extend({}, {
            inputSelect: '#auto_ipt', // input id
            resources: [],
            replaceItemKeyword: null,  //function
            listSelect: '#auto_content', // list box
            liSelect: 'div.item', //
            boxSelect: null,
            liTpl: 'autocomplete_tpl',
            emptyHandle: false, // function
            showDefaultData: false
        }, _op);

        self.dom = $(self.op.inputSelect);
        self.list = $(self.op.listSelect);
        self.contentBox = self.op.boxSelect === null ? self.list : $(self.op.boxSelect);
        self.autoContent = $('#auto_content');
        self.init();
    };

    Search.prototype.init = function () {
        var self = this;
        self.list.on('click', self.op.liSelect, function () {
            $(self.dom).val($(this).data('name'));
            sp.publish('value_changed', [{name: $(this).data('name'), id: $(this).data('id'), item: $(this)}]);
            self.close();
        });
        self.dom.on('input', function () {
            self.getResult();
        });
        // temporary comment
        $(window).on('keydown', function (e) {
            if (e.keyCode == 13) {
                sp.publish('autocomplete_entered', [self.dom.val()]);
            }
        });
    };

    Search.prototype.getResult = function () {
        var self = this,
            val = $.trim(self.dom.val());
        if (!val) {
            self.list.hide();
            return;
        }
        if ($.isArray(self.op.resources)) {
            var _r = self.op.resources;
            self.dataHandle(_r);
        } else if (typeof self.op.resources == 'string') {
            $.ajax({
                type: 'post',
                url: self.op.resources,
                data: self.op.reqDataInit(val),
                dataType: 'json',
                success: function (da) {
                    var _da = self.op.repDataInit(da);
                    self.dataHandle(_da);
                }
            });
        } else {
            self.op.resources({
                data: {
                    keyword: val
                },
                sucFn: function (data) {
                    self.dataHandle(data);
                },
                errFn: function () {
                }
            });
        }
    };

    Search.prototype.dataHandle = function (_da) {
        var self = this;
        self.da = _da;
        _da = self.replaceKeyword(_da);
        if (_da.length > 0 && self.op.showDefaultData) {
            self.contentBox.html(temp(self.op.liTpl, {'names': _da}));
            self.contentBox.append(temp('autocomplete_default_data_tpl', {'name': self.dom.val()}));
            self.open();
        } else if (_da.length > 0) {
            self.contentBox.html(temp(self.op.liTpl, {'names': _da}));
            self.open();
        } else if (_da.length === 0 && self.op.emptyHandle) {
            self.contentBox.html(temp('autocomplete_empty_tpl', {'name': self.dom.val()}));
            self.open();
        } else if (_da.length === 0) {
            self.close();
        }
    };

    Search.prototype.replaceKeyword = function (_da) {
        var self = this;
        var keyword = $.trim(this.dom.val());
        var data = [];
        var reg = new RegExp(keyword, 'g');
        var replaceItemKeyword = self.op.replaceItemKeyword ? self.op.replaceItemKeyword : self.replaceItemKeyword;
        for (var i = 0, len = _da.length; i < len; i++) {
            var temp = replaceItemKeyword(reg, _da[i], keyword);
            data.push(temp);
        }
        console.log(data);
        return data;
    };

    Search.prototype.replaceItemKeyword = function (reg, _item, keyword) {
        var temp = $.extend({}, _item);
        //temp.repAddress = _item.address.replace(reg, '<em style="color: #f60;">' + keyword + '</em>');
        temp.repName = _item.name.replace(reg, '<em style="color: #f60;">' + keyword + '</em>');
        return temp;
    };

    Search.prototype.close = function () {
        this.contentBox.empty().hide();
    };

    Search.prototype.open = function () {
        this.contentBox.show();
    };

    Search.prototype.focus = function () {
        this.dom.focus();
    };

    Search.prototype.clearAutoIpt = function () {
        this.dom.val('');
    };

    Search.prototype.cancelSearch = function () {
        var self = this;
        self.dom.val('');
        self.list.hide(300);
    };

    Search.prototype.setInputVal = function (val) {
        var self = this;
        if (val) {
            self.dom.val(val);
            self.getResult();
        } else {
            self.autoContent.hide();
        }
        // self.dom.focus();
    };

    return Search;
});
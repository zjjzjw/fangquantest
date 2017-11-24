define("ui.autocomplete", ['zepto', 'zepto.sp', 'zepto.temp'], function ($, sp, temp) {
    "use strict";

    var AutoComplete = function (_op) {
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
        self.cancelBtn = $('#btn_cancel');
        self.cancelAll = $('#cancel_all');
        self.tags = $('#auto_tags');
        self.autoContent = $('#auto_content');
        self.init();
    };

    AutoComplete.prototype.init = function () {
        var self = this;
        self.list.on('click', self.op.liSelect, function () {
            $(self.dom).val($(this).data('name'));
            sp.publish('value_changed', [{name: $(this).data('name'), id: $(this).data('id')}]);
            self.close();
        });
        self.dom.on('input', function () {
            self.getResult();
        });
        self.cancelBtn.on('click', function (e) {
            e.preventDefault();
            self.list.hide();
            self.dom.val('');
            sp.publish('search_canceled', []);
        });
        self.cancelAll.on('click', function (e) {
            e.preventDefault();
            self.cancelSearch();
        });
        // temporary comment
        $(window).on('keydown', function (e) {
            if (e.keyCode == 13) {
                sp.publish('autocomplete_entered', [self.dom.val()]);
            }
        });
        // $('#auto_tags').height(window.innerHeight);
    };

    AutoComplete.prototype.getResult = function () {
        var self = this,
            val = $.trim(self.dom.val());
        if (!val) {
            self.cancelAll.hide();
            self.tags.show();
            self.list.hide();
            return;
        }
        self.cancelAll.show();
        self.tags.hide();
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

    AutoComplete.prototype.dataHandle = function (_da) {
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

    AutoComplete.prototype.replaceKeyword = function (_da) {
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

    AutoComplete.prototype.replaceItemKeyword = function (reg, _item, keyword) {
        var temp = $.extend({}, _item);
        //temp.repAddress = _item.address.replace(reg, '<em style="color: #f60;">' + keyword + '</em>');
        temp.repName = _item.name.replace(reg, '<em style="color: #f60;">' + keyword + '</em>');
        return temp;
    };

    AutoComplete.prototype.close = function () {
        this.contentBox.empty().hide();
    };

    AutoComplete.prototype.open = function () {
        this.contentBox.show();
    };

    AutoComplete.prototype.focus = function () {
        this.dom.focus();
    };

    AutoComplete.prototype.clearAutoIpt = function () {
        this.dom.val('');
    };

    AutoComplete.prototype.cancelSearch = function () {
        var self = this;
        self.dom.val('');
        self.cancelAll.hide();
        self.list.hide(300);
        self.tags.show();
    };

    AutoComplete.prototype.setInputVal = function (val) {
        var self = this;
        if (val) {
            self.dom.val(val);
            self.cancelAll.show();
            self.getResult();
        } else {
            self.cancelAll.hide();
            self.autoContent.hide();
            self.tags.show();
        }
        // self.dom.focus();
    };

    return AutoComplete;
});
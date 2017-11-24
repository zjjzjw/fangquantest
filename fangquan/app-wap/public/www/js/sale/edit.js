define(['zepto', 'page.params', 'backbone', 'ui.popup', 'validate',
    'app/component/area', 'app/service/saleService', 'ui.search', 'zepto.sp'
], function ($, params, Backbone, Popup, mvalidate, Area, service, search, sp) {
    'use strict';


    var Edit = function () {
        var self = this;
        self.limitPop = new Popup({
            width: 250,
            height: 150,
            content: $('#limitTpl').html()
        });
        self.loadingPop = new Popup({
            content: $('#loadingTpl').html()
        });
        //联系人匹配
        self.auto = new search({
            //通用的keyword
            resources: service.getCardListByKeyword
        });
        self.init();
        self.bindEvent();
    };

    Edit.prototype.bindEvent = function () {
        var self = this;

        $('#form_creat').mvalidate({
            type: 2,
            onKeyup: true,
            sendForm: false,
            firstInvalidFocus: true,
            valid: function (event, options) {
                self.loadingPop.showPop();
                //点击提交按钮时,表单通过验证触发函数
                service.saleStore(
                    {
                        data: $('#form_creat').serialize(),
                        sucFn: function (data, status, xhr) {
                            self.loadingPop.closePop();
                            window.location.href = '/sale/individual/list';
                        },
                        errFn: function (xhr, errorType, error) {
                            var message = showError(xhr);
                            $('.hint-content').empty().html(message);
                            self.loadingPop.closePop();
                            self.limitPop.showPop();
                        }
                    }
                );
                //提交数据
                event.preventDefault();
            },
            invalid: function (event, status, options) {
                //点击提交按钮时,表单未通过验证触发函数
            },
            eachField: function (event, status, options) {
                //点击提交按钮时,表单每个输入域触发这个函数 this 执向当前表单输入域，是jquery对象
            },
            eachValidField: function (val) {
            },
            eachInvalidField: function (event, status, options) {
            },
            conditional: {
                confirmCloseType: function () {
                    if (parseInt($('.close-sale').val()) == 6) {
                        if ($.trim($('.class-reason').val()) == "") {
                            return false;
                        }
                    }
                    return true;
                }
            },
            descriptions: {
                projectname: {
                    required: '请输入项目名',
                    valid: '',
                },
                province: {
                    required: '请输入项目所在地',
                    valid: '',
                },
                city: {
                    required: '请输入项目所在地',
                    valid: '',
                },
                detailaddress: {
                    required: '请输入详细地址',
                    valid: '',
                },
                productor: {
                    required: '请输入所属开发商',
                    valid: '',
                },
                group: {
                    required: '请输入开发商所属集团',
                    valid: '',
                },
                mass: {
                    required: '请输入项目体量',
                    pattern: '请输入整数',
                    valid: '',
                },
                stage: {
                    required: '请选择项目所处阶段',
                    valid: '',
                },
                person: {
                    required: '请输入联系人',
                    valid: '',
                },
                station: {
                    required: '请输入岗位',
                    valid: '',
                },
                contact: {
                    required: '请输入联系方式',
                    pattern: '请输入11位手机号',
                    valid: '',
                },
                close: {
                    required: '请选择关闭原因',
                    valid: '',
                },
                close_reason: {
                    valid: '',
                    conditional: '请输入关闭原因'
                }
            }
        });
        $('.limit-close').on('click', function () {
            self.limitPop.closePop();
            $('.hint-content').empty();
        });
    };

    Edit.prototype.init = function () {
        var self = this;
        $('.close-sale').change(function () {
            if ($('.close-sale').val() == 6) {
                $('#p_close_reason').show();
                $('.class-reason').val('');
            } else {
                $('#p_close_reason').hide();
            }
        });
        //姓名匹配
        sp.subscribe('autocomplete_entered', function (data) {
            self.auto.clearAutoIpt();
        });

        sp.subscribe('value_changed', function (data) {
            self.auto.clearAutoIpt();
            $('.auto-ipt').val(data.item.data('name'));
            $('.position').val(data.item.data('position_name'));
            $('.contact').val(data.item.data('phone'));
        });

        //输出数据
        var area = new Area({idNames: ['#province_id', '#city_id'], data: params.areas});
        area.selectedId(params.province_id, params.city_id);

    };
    new Edit();
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
});

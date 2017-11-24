define(['zepto', 'page.params', 'backbone', 'validate', 'ui.popup', 'app/component/area', 'app/service/project/structureService', 'ui.search', 'zepto.sp'
], function ($, params, Backbone, mvalidate, Popup, Area, service, search, sp) {
    'use strict';


    var Edit = function () {
        var self = this;
        //权限
        self.limitPop = new Popup({
            width: 250,
            height: 150,
            content: $('#limitTpl').html()
        });
        self.loadingPop = new Popup({
            content: $('#loadingTpl').html()
        });
        //姓名匹配
        self.auto = new search({
            //通用的keyword
            resources: service.getCardListByKeyword
        });
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
                service.storeProjectStructure(
                    {
                        data: $('#form_creat').serialize(),
                        sucFn: function (data, status, xhr) {
                            self.loadingPop.closePop();
                            window.location.href = '/project/' + params.project_id + '/structure/flow';
                        },
                        errFn: function (data, xhr, errorType, error) {
                            var message = showError(data);
                            $('.hint-content').empty().html(message);
                            self.loadingPop.closePop();
                            self.limitPop.showPop();
                        }
                    }
                );
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
                confirmlength: function () {
                    var len = $("input[type='checkbox']:checked").length;
                    if (len <= 3) {
                        return true;
                    }
                }
            },
            descriptions: {
                name: {
                    required: '请输入姓名',
                    valid: '',
                },
                position: {
                    required: '请输入职位',
                    valid: '',
                },
                role: {
                    required: '请选择角色',
                    valid: '',
                },
                relation: {
                    required: '请选择现阶段关系',
                    valid: '',
                },
                character: {
                    required: '请选择性格,最多三个',
                    valid: '',
                    conditional: '最多可选三个',
                },
                hobby: {
                    required: '请输入兴趣点',
                    valid: '',
                },
                plan: {
                    required: '请输入突破计划',
                    valid: '',
                },
                testification: {
                    required: '请输入举证',
                    valid: '',
                },
                pain: {
                    required: '请输入痛苦描述',
                    valid: '',
                },
                contact: {
                    required: '请输入联系方式',
                    pattern: '请输入11位手机号',
                    valid: '',
                },
                support: {
                    required: '请选择支持与反对',
                    valid: '',
                }
            }
        });
        $('.limit-close').on('click', function () {
            self.limitPop.closePop();
            $('.hint-content').empty();
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
    };
    new Edit();
    //权限信息数据处理
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

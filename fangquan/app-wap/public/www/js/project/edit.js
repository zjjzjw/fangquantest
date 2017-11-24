define(['zepto', 'page.params', 'backbone', 'validate', 'app/component/area',
    'ui.popup', 'app/service/projectService', 'ui.search', 'zepto.sp'
], function ($, params, Backbone, mvalidate, Area, Popup, service, search, sp) {
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
        //项目匹配
        self.auto = new search({
            //通用的keyword
            resources: service.getSaleListByKeyword
        });
        self.init();
        self.bindEvent();
    };

    Edit.prototype.bindEvent = function () {
        var self = this;

        $('.add-partner').on('click', function () {
            $('.principal-content').show();
            $('.edit-content').hide();
        });

        $('.assign-back').on('click', function () {
            $('.principal-content').hide();
            $('.edit-content').show();
        });

        $('.name').on('click', function () {
            if ($(this).children().hasClass('item-show')) {
                $(this).children().removeClass('item-show');
                $(this).next().hide();
            } else {
                $(this).children().addClass('item-show');
                $(this).next().show();
            }
        });

        $('.principal-btn').on('click', function () {
            $('.principal-content').hide();
            $('.edit-content').show();
            //得到值
            var checked_ids = [], checked_names = [];
            $('input[name="cooperation_user"]:checked').each(function () {
                checked_ids.push($(this).val());
                checked_names.push($(this).data('user-name'));
            });
            $('.add-partner').val(checked_names);
            $('#cooperation_user_ids').val(checked_ids);
        });

        $('#form_creat').mvalidate({
            type: 2,
            onKeyup: true,
            sendForm: false,
            firstInvalidFocus: true,
            valid: function (event, options) {
                self.loadingPop.showPop();
                //点击提交按钮时, 表单通过验证触发函数
                service.storeProject(
                    {
                        data: $('#form_creat').serialize(),
                        sucFn: function (data, status, xhr) {
                            //跳转到我的项目列表
                            self.loadingPop.closePop();
                            window.location.href = '/project/individual/list';
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
                person: {
                    required: '请输入联系人',
                    valid: '',
                },
                mass: {
                    required: '请输入项目体量',
                    pattern: '请输入整数',
                    valid: '',
                },
                time: {
                    required: '请输入合同签订时间',
                    valid: '',
                },
                partner: {
                    required: '请选择合作人员',
                    valid: '',
                },
                principal: {
                    required: '请选择负责人',
                    valid: '',
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
        //项目匹配
        sp.subscribe('autocomplete_entered', function (data) {
            self.auto.clearAutoIpt();
        });

        sp.subscribe('value_changed', function (data) {
            self.auto.clearAutoIpt();
            $('.auto-ipt').val(data.item.data('name'));
            $('.address').val(data.item.data('address'));
            $('.volume').val(data.item.data('volume'));
            area.selectedId(data.item.data('province'), data.item.data('city'));
        });


        //输出数据
        var area = new Area({idNames: ['#province_id', '#city_id'], data: params.areas});
        area.selectedId(params.province_id, params.city_id);
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

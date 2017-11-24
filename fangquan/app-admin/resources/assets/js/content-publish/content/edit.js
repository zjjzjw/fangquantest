$(function () {
    var Popup = require('../../../component/popup');
    var temp = require('../../../component/temp');
    var fileupload = require('../../../component/fileupload');
    var service = require('../../../service/contentPublish/contentService');
    var datetimepicker = require('../../../lib/datetimepicker/jquery.datetimepicker');

    $successPop = new Popup({
        width: 200,
        height: 150,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#successTpl').html()
    });
    $loadingPop = new Popup({
        width: 128,
        height: 128,
        contentBg: 'transparent',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#loadingTpl').html()
    });

    $promptPop = new Popup({
        width: 400,
        height: 225,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#promptTpl').html()
    });

    //时间筛选
    $('.date').datetimepicker({
        timepicker: false,
        format: 'Y-m-d H:i:s',
        formatTime: 'H:i:s',
        formatDate: 'Y/m/d',
        closeOnDateSelect: true,
        scrollInput: false,
        lang: 'zh'
    });

    $.validate({
        form: '#form',
        validateOnBlur: false,
        onSuccess: function ($form) {
            moreValidate();
            return false;
        }
    });

    var ue = UE.getEditor('container');
    ue.ready(function () {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
    });

    function moreValidate() {
        //正文判断
        var iframe_box = ue.getContent();
        var timing_publish = $('input[name="is_timing_publish"]:checked').length;
        var status = $('input[name="status"]:checked').length;

        if (iframe_box == "") {
            $('.error-tip-content').show();
        } else if (timing_publish < 1) {
            $('.error-tip-content').hide();
            $('.error-tip-timing_publish').show();
        } else if (status < 1) {
            $('.error-tip-timing_publish').hide();
            $('.error-tip-status').show();
        } else if (parseInt($.params.id) == 0) {
            $('.error-tip-status').hide();
            var opt = {data: {}};
            service.store({
                data: $('#form').serialize(),
                params: $.params,
                beforeSend: function () {
                    $loadingPop.showPop(opt);
                },
                sucFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $successPop.showPop(opt);
                    setTimeout(skipUpdate, 2000);

                    function skipUpdate() {
                        $successPop.closePop();
                        window.location.href = '/content-publish/content/index';
                    }
                },
                errFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $('.text').html(showError(data));
                    $promptPop.showPop(opt);
                }
            });
        } else {
            $('.error-tip-status').hide();
            var opt = {data: {}};
            service.update({
                data: $('#form').serialize(),
                params: $.params,
                beforeSend: function () {
                    $loadingPop.showPop(opt);
                },
                sucFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $successPop.showPop(opt);
                    setTimeout(skipUpdate, 2000);

                    function skipUpdate() {
                        $successPop.closePop();
                        $promptPop.closePop();
                        window.location.href = '/content-publish/content/index';
                    };
                },
                errFn: function (data, status, xhr) {
                    $loadingPop.closePop();
                    $('.text').html(showError(data));
                    $promptPop.showPop(opt);
                }
            });
        }
    }

    $(document).on('click', '#pop_close', function () {
        $promptPop.closePop();
    });


    //上传图片
    fileupload({
        acceptFileTypes: ['plain', 'jp*g', 'png', 'gif', 'bmp'],
        dom: $('#addPicture-image'),
        start: function (e, data) {
            var opt = {data: {}};
            $loadingPop.showPop(opt);
        },
        always: function (e, data, Errors) {
        },
        progress: function (e, data) {
            var loaded = e.delegatedEvent['loaded'];
            var total = e.delegatedEvent['total'];

            $('.upload-progress').html((Number(loaded / total * 100)).toFixed(2) + '%');
        },
        callback: function (result, data) {
            $loadingPop.closePop();
            var tempFiles = temp('files_tpl', {
                data: data,
                result: result,
                name: 'image',
                single: false
            });

            $('.add-image').before(tempFiles);
            $('.add-image').css('border-color', '#d9d9d9');


            //图片删除
            $('.picture-box-image .show-item').on('click', '.delete', function () {
                $(this).parent('.show-item').remove();
                $('.add-image').show();
            });
        }
    });

    //删除
    $('.picture-box-image .show-item').on('click', '.delete', function () {
        $(this).parent('.show-item').remove();
        $('.add-image').show();
    });


    //上传视频
    fileupload({
        acceptFileTypes: ['video'],
        dom: $('#addPicture-audio'),
        start: function (e, data) {
            var opt = {data: {}};
            $loadingPop.showPop(opt);
        },
        always: function (e, data, Errors) {
        },
        progress: function (e, data) {
            var loaded = e.delegatedEvent['loaded'];
            var total = e.delegatedEvent['total'];

            $('.upload-progress').html((Number(loaded / total * 100)).toFixed(2) + '%');
        },
        callback: function (result, data, files) {
            $loadingPop.closePop();
            result.url = '/www/image/audio.png';
            result.origin_url = '/www/images/audio.png';

            var tempFiles = temp('files_tpl', {
                data: data,
                result: result,
                name: 'audio',
                single: true
            });

            //文件名
            $('.audio-title').val(files[0].name);

            $('.add-audio').before(tempFiles);
            $('.add-audio').css('border-color', '#d9d9d9');

            $('.add-audio').hide();

            //图片删除
            $('.picture-box-audio .show-item').on('click', '.delete', function () {
                $(this).parent('.show-item').remove();
                $('.add-audio').show();
            });
        }
    });

    //删除
    $('.picture-box-audio .show-item').on('click', '.delete', function () {
        $(this).parent('.show-item').remove();
        $('.add-audio').show();
    });


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
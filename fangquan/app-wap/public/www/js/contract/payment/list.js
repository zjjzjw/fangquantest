define(['zepto',
        'page.params'
    ], function ($, params) {
        var List = function () {
            var self = this;
            self.init();
        };

        List.prototype.init = function () {
            var self = this;
            $('.add-btn').click(function () {
                if ($(this).hasClass('pull-down')) {
                    $(this).removeClass('pull-down').addClass('arrow-up');
                    $('#dialog').show();
                    $('#optionlist').show();
                } else {
                    $(this).addClass('pull-down').removeClass('arrow-up');
                    $('#dialog').hide();
                    $('#optionlist').hide();
                }
            });

            //点击灰色区域隐藏浮层
            $('#dialog').on('click', function () {
                $('.add-btn').addClass('pull-down').removeClass('arrow-up');
                $('.optionlist').hide();
                $(this).hide();
            });
            $('.com-back').attr("href", "/contract/detail/" + params.contract_id);
        };
        new List();
    }
);

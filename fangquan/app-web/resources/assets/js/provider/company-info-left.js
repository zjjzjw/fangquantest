$(function () {
    var Popup = require('../../component/popup');
    var fraction = $.params.fraction;

    $downloadTpl = new Popup({
        width: 520,
        height: 300,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#downloadTpl').html()
    });
    $(document).on('click', '#downloadReport', function () {
        var opt = {data: {}};
        $('body').css('overflow', 'hidden');
        $downloadTpl.showPop(opt);
    });
    $(document).on('click', '.download-close-box', function () {
        $downloadTpl.closePop();
        $('body').css('overflow', 'auto');
    });
    var chartData = {
        labels: ["企业规模", "行业资质", "企业信用", "服务体系", "创新能力",],
        datasets: [
            {
                //背景颜色
                fillColor: "rgba(246,122,51,0.35)",
                //边框
                strokeColor: "rgba(246,122,51,1)",
                //点
                pointColor: "rgba(246,122,51,1)",
                //点的边框
                pointStrokeColor: "#F67A33",
                data: fraction
            }
        ]
    };
    $.charts = {
        set: function (arg) {
            // 自定义
            var defaults = {
                element: '#myChart',//canvas元素
                type: 'Line',//图表类型,其他类型参考插件官网
                data: chartData,//图表数据
                parameter: {}
            };
            var options = $.extend(defaults, arg);
            var ctx = $(options.element)[0].getContext("2d"), myNewChart;
            switch (options.type) {
                case 'Line'://曲线图
                    myNewChart = new Chart(ctx).Line(options.data, options.parameter);
                    break;
                case 'Bar'://柱状图
                    myNewChart = new Chart(ctx).Bar(options.data, options.parameter);
                    break;
                case 'Radar'://雷达图或蛛网图
                    myNewChart = new Chart(ctx).Radar(options.data, options.parameter);
                    break;
                case 'PolarArea'://极地区域图
                    myNewChart = new Chart(ctx).PolarArea(options.data, options.parameter);
                    break;
                case 'Pie'://饼图
                    myNewChart = new Chart(ctx).Pie(options.data, options.parameter);
                    break;
                case 'Doughnut'://环形图
                    myNewChart = new Chart(ctx).Doughnut(options.data, options.parameter);
                    break;
            }
        }
    };
    $.charts.set({
        element: '#myChart',//canvas元素
        type: 'Radar',//图表类型,其他类型参考插件官网
        data: chartData,//图表数据
        parameter: {
            scaleOverride: true,
            scaleSteps: 2,
            scaleStepWidth: 50,
            scaleStartValue: 0,
            pointLabelFontSize: 14,
            pointLabelFontColor: "#999",
            pointDotStrokeWidth: 0.5,
            datasetStrokeWidth: 1,
            scaleLineColor: "#1cc7ca",
            angleLineColor: "#1cc7ca",
        }
    });
});
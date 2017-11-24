define(['zepto', 'page.params', 'backbone', 'app/lib/chart/Chart'
], function ($, params, Backbone, Chart) {
    'use strict';
    init();
    function init() {
        initChart();
    }

    function initChart() {
        var radarChartData = {
            labels: params.labels,
            datasets: [
                {
                    label: "竞品",
                    fillColor: "rgba(52,154,229,0.6)",
                    strokeColor: "rgba(52,154,229,0.6)",
                    pointColor : "#349ae5",
                    pointStrokeColor : "#349ae5",
                    data: params.inferiority
                },
                {
                    label: "我方",
                    fillColor: "rgba(235,45,81,0.6)",
                    strokeColor: "rgba(235,45,81,0.6)",
                    pointColor : "#eb2d51",
                    pointStrokeColor : "#eb2d51",
                    data: params.advantage
                }
            ]
        };
        var ctx = document.getElementById("canvas").getContext("2d");
        ctx.fillRect(10, 10, 10, 200);
        var myRadar = new Chart(ctx).Radar(radarChartData, {
            responsive: true
        });
    }
    $('.com-back').attr("href", "/project/detail/" + params.project_id);
});

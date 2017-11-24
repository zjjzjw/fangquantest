$(function () {
    var data = $.params.service_network_data;
    var dom = document.getElementById("main");
    var myChart = echarts.init(dom);
    var app = {};
    var option = null;
    var geoCoordMap = $.params.cities;

    var convertData = function (data) {
        var res = [];
        for (var i = 0; i < data.length; i++) {
            var geoCoord = geoCoordMap[data[i].city_name];
            if (geoCoord) {
                res.push({
                    name: data[i].name,
                    value: geoCoord.concat(100)//小球的大小
                });
            }
        }
        return res;
    };

    option = {
        backgroundColor: '#ffffff',//背景颜色
        geo: {
            map: 'china',
            label: {
                emphasis: {
                    show: false
                }
            },
            roam: false,//地图是否可以放大
            itemStyle: {
                normal: {
                    areaColor: '#e7f9f9',//地图颜色
                    borderColor: '#ffffff'//地图边框
                },
                emphasis: {
                    areaColor: '#e7f9f9'//鼠标移入地图颜色
                }
            }
        },
        series: [
            {
                type: 'scatter',
                coordinateSystem: 'geo',
                data: convertData(data),
                symbolSize: function (val) {
                    return val[2] / 10;
                },
                label: {
                    emphasis: {
                        show: false//是否显示地名
                    }
                },
                itemStyle: {
                    normal: {
                        color: '#1cc7ca',//小球颜色
                        borderColor: '#fff',
                        borderWidth: 1
                    }
                }
            },
            {
                type: 'effectScatter',
                coordinateSystem: 'geo',
                data: convertData(data.sort(function (a, b) {
                    return b.value - a.value;
                }).slice(0, 6)),
                symbolSize: function (val) {
                    return val[2] / 10;
                },

                rippleEffect: {
                    brushType: 'stroke'
                },
                hoverAnimation: false,//一上去小球变大
                label: {
                    normal: {
                        formatter: '{b}',
                        position: 'right',
                        show: false//是否加载进来的显示地名
                    }
                },
                itemStyle: {//小球颜色
                    normal: {
                        color: '#1cc7ca'
                    }
                },
                zlevel: 1
            }
        ]
    };

    myChart.on('click', function (param) {
        var name = param.name;
        $.each(data, function (i, k) {
            if (k.name == name) {
                add(k, param.event);
            }
        });
    });

    function add(k, e) {
        //计算鼠标和事件源的距离
        var ev = window.event || e;
        var mouse_left = ev.layerX || ev.offsetX;
        var mouse_top = ev.layerY || ev.offsetY;
        console.log(mouse_left,mouse_top);
        $(".network-box").remove();
        html = '<div class="network-box">' +
            '<div class="text">' +
            '<div class="network-cancel"><i>x</i></div>';

        html += '<p class="city-name">' + k.city_name + '</p>';
        if (k.worker_count && k.worker_count != 0) {
            html += '<p>服务人数：' + k.worker_count + '</p>';
        }

        if (k.contact.length) {
            html += '<p>联系人：' + k.contact + '</p>';
        }

        if (k.telphone.length) {
            html += '<p>联系电话：' + k.telphone + '</p>';
        }
        if (k.address.length) {
            html += '<p class="address">地址：' + k.address + '</p>';
        }

        html += '</div></div>';
        $('#main').append(html);
        var height = $('#main .network-box .text').outerHeight();
        var width = $('#main .network-box .text').outerWidth();
        var left = mouse_left - width-10;
        var top = mouse_top - height-35;
        console.log(height,left,top);
        $("#main .network-box").css({
            left: left,
            top: top
        })
    }

    $(document).on('click', '.network-cancel', function () {
        $('.network-box').hide();
    });

    myChart.setOption(option, true);

});
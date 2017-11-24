define("ui.amap", ['zepto'], function($) {
    "use strict";

    //TODO: 使用动态地图功能时需要将<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=43d4bbd0927a02280dcd5a3de5499f29"></script>引入相应的html中去

    var AgjAMap = function(_ops) {
        var self = this;
        self.ops = _ops;
    };
    //必传参数lng&lat,接收callback；
    AgjAMap.prototype.getStaticMapUri = function() {
        var self = this;
        if(!(self.ops && self.ops.lng && self.ops.lat && self.ops.width && self.ops.height)) {
            if(self.ops && self.ops.callback) {
                var _code;
                var _mes;
                if(!(self.ops.lng && self.ops.lat)) {
                    _code = '400';
                    _mes = '缺少必传参数经度或纬度';
                }
                if(!(self.ops.width & self.ops.height)) {
                    _code = '401';
                    _mes = '缺少必传参数宽度或高度';
                }
                if(self.ops.width && self.ops.height) {
                    self.ops.width = isNaN(self.ops.width) ? parseFloat(self.ops.width) : self.ops.width;
                    self.ops.height = isNaN(self.ops.height) ? parseFloat(self.ops.height) : self.ops.height;
                    if((self.ops.width <= 0) || (self.ops.height <= 0))
                        _code = '402';
                    _mes = '经纬度值错误';
                }
                var respPara = {
                    'code': _code,
                    'message': _mes
                };
                self.ops.callback(respPara);
                return;
            }
            return;
        }
        var staticMapUrl = self.getStaticMapUrl();
        if(self.ops && self.ops.callback) {
            var mapUrl = {
                'rez': staticMapUrl
            };
            self.ops.callback(mapUrl);
            return;
        }
        return staticMapUrl;
    };
    //将用户参数与AgjAMap默认参数按高德地图（静态图）指定的格式拼接
    AgjAMap.prototype.getStaticMapUrl = function() {
        var self = this;
        var staticMapOps = $.extend({},{
            baseUrl: 'http://restapi.amap.com/v3/staticmap?',
            key: '322b3600535c4312afe222971387d49b',//高德静态地图key,
            zoom: 14, // 默认缩放级别[1-17]
            size: '400*300', //默认图片尺寸：最大值为1024*1024
            iconUrl: 'http://img.dev.agjimg.com/Fl6JJO0ytyaqrwkbTMF0mRhe-tjB?.png' //标注使用的图片：只支持png格式//TODO
            //scale: '1', //普通/高清:1:回普通图；2:调用高清图，图片高度和宽度都增加一倍，zoom也增加一倍（当zoom为最大值时，zoom不再改变）
            //traffic: '0',//底图是否展现实时路况。 可选值： 0，不展现；1，展现
        },self.ops);
        var _markers = 'markers=-1,' + staticMapOps.iconUrl + ',0:' + staticMapOps.lng + ',' + staticMapOps.lat;
        var _size = 'size=' + staticMapOps.size;
        if(staticMapOps.width && staticMapOps.height) {
            _size = 'size=' + staticMapOps.width + '*' + staticMapOps.height;
        }
        var staticMapUrl = staticMapOps.baseUrl + _markers + '&key=' + staticMapOps.key + '&zoom=' + staticMapOps.zoom + '&' + _size;
        return staticMapUrl;
    };

    return AgjAMap;
});
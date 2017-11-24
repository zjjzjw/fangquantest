define(['zepto', 'page.params', 'ui.amap'], function($, params, Amap) {
    'use strict';

    var $map = $('#map'), $mapImg = $('#map>img');

    //添加静态地图
    (function() {
        var _lng = params.lng, _lat = params.lat, loupanId = params.loupanId;
        if (!(_lng && _lat)) {
            $map.addClass('map-hide');
            return;
        }
        _lng = parseFloat(_lng);
        _lat = parseFloat(_lat);
        if (!((_lng > 0) && (_lat > 0))) {
            $map.addClass('map-hide');
            return;
        }
        var _mapOps = {
            width: 400,
            height: 200,
            lng: _lng,
            lat: _lat,
            iconUrl: 'http://img.dev.agjimg.com/Fl6JJO0ytyaqrwkbTMF0mRhe-tjB?.png'
        };
        var _map = new Amap(_mapOps);
        var _staticMapUri = _map.getStaticMapUri();
        var _dynamicMapPage = '/loupan/map/' + loupanId;
        $mapImg.attr('src', _staticMapUri);
        $map.attr('href', _dynamicMapPage);
    })();
});

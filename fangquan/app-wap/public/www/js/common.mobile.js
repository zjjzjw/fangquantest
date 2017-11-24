//The build will inline common dependencies into this file.
requirejs.config({
    baseUrl: 'js',
    paths: {
        app: '../js',

        // Files
        common: '../common.mobile',

        // 3rd party libraries
        zeptoDir: 'lib/zepto',
        zepto: 'lib/zepto-custom.min',//custom zepto js
        fastclick: 'lib/fastclick',
        'backbone': 'lib/backbone',
        'underscore': 'lib/underscore-min',
        //modules ui
        'modules.ui': 'modules/ui',

        // modules
        utils: 'lib/utils',
        ajax: 'lib/ajax',
        'zepto.temp': 'lib/zepto.temp',
        'zepto.sp': 'lib/zepto.subscribepublish',
        'ui.popup': 'modules/ui/ui.popup',
        'ui.vote': 'modules/ui/ui.vote',
        'ui.tab': 'modules/ui/ui.tab',
        'ui.autocomplete': 'modules/ui/ui.autocomplete',
        'ui.swipe': 'modules/ui/ui.swipe',
        'ui.commonlist': 'modules/ui/inventorylist/ui.commonlist',
        'ui.waterfall': 'modules/ui/ui.waterfall',
        'ui.navbar': 'modules/ui/ui.navbar',
        'ui.scrollwheel': 'modules/ui/ui.scrollwheel',
        'ui.doublewheel': 'modules/ui/ui.doublewheel',
        'ui.gotop': 'modules/ui/ui.gotop',
        'ui.iscroll': 'modules/ui/ui.iscroll',
        'ui.amap': 'modules/ui/ui.amap',
        'ui.uploader': 'modules/ui/ui.uploader'
    },
    shim: {
        backbone: {
            exports: 'Backbone',
            deps: ['zepto', 'underscore']
        },
        underscore: {
          exports: '_'
        },
        zepto: {
            exports: '$'
        },
        'zepto.temp': {
            deps: ['zepto']
        },
        ajax: {
            deps: ['zepto']
        },
        common: {
            deps: ['zepto', 'fastclick', 'utils', 'zepto.temp', 'zepto.sp', 'ajax', 'app/lib/detect', 'app/header','app/modules/event/track.link', 'app/modules/event/track.event']
        },
        'ui.popup': {
            deps: ['zepto']
        },
        'app/header': {
            deps: ['zepto']
        }
    }
});

define('common', ['zepto', 'fastclick', 'utils', 'zepto.temp', 'zepto.sp', 'ajax', 'app/lib/detect', 'app/header', 'app/modules/event/track.link', 'app/modules/event/track.event'], function($, FastClick, utils, temp, sp, ajax, detect, header, trackLink){
    // Track Links
    trackLink();
    $.trackEvent();

    $(function(){
        FastClick.attach(document.body);
    });

    // Detect network
    (function($, sp) {
        var netStatus = 'online',
            networkStatusDom = $('.network-status'),
            animation = function (netStatus) {
                if ('online' === netStatus) {
                    networkStatusDom.html('已连接成功。');
                } else {
                    networkStatusDom.html('已断开网络，请检查网络连接。');
                }

                networkStatusDom.show();
                setTimeout(function(){
                    networkStatusDom.hide();
                }, 2000);
            },
            fnCallback = function (event) {
                animation(netStatus);
                event.preventDefault();
                return false;
            };

        sp.subscribe('detect.network', function(data) {
            // data: {online: true, status: "online", event: Event}
            netStatus = data.status;
            if (networkStatusDom) {
                if (! data.online) {
                    $('body').on('touchstart', 'a', fnCallback);
                } else {
                    $('body').off('touchstart', 'a', fnCallback);
                }
                animation(netStatus);
            }
        });
    })($, sp);
});

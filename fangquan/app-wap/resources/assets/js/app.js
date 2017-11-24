/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


(function ($) {
    $.isIE6 = (function () {
        var isIe6 = false;

        if (/msie/.test(navigator.userAgent.toLowerCase())) {
            if (jQuery.browser && jQuery.browser.version && jQuery.browser.version == '6.0') {
                isIe6 = true
            } else if (!$.support.leadingWhitespace) {
                isIe6 = true;
            }
        }

        return isIe6;
    })();

    $.hasPlaceholder = (function () {
        var d = document.createElement('input');
        d.type = 'text';
        return d.placeholder === undefined;
    })();

    $.inherit = function (my, classParent, args) {
        classParent.apply(my, args || []);
        $.extend(my.constructor.prototype, classParent.prototype);
    };

    $.Observer = function () {
        this.ob = {};
    };

    $.Observer.prototype.on = function (eventNames, callback) {
        var _events = eventNames.split(' ');
        var _eventKeys = {};
        for (var i = 0; i < _events.length; i++) {
            if (!this.ob[_events[i]]) {
                this.ob[_events[i]] = [];
            }
            var _key = this.ob[_events[i]].push(callback);
            _eventKeys[_events[i]] = _key - 1; // push 返回数组长度，key是 现有长度减一。
        }
        return _eventKeys;
    };

    $.Observer.prototype.off = function (eventName, keys) {
        if (!!keys && !$.isArray(keys)) {
            keys = [keys]
        }
        for (var i = 0; i < this.ob[eventName].length; i++) {
            if (!keys || $.inArray(i, keys) > -1) {
                this.ob[eventName][i] = undefined;
            }
        }
    }

    $.Observer.prototype.trigger = function (eventName, args) {
        var r;
        if (!this.ob[eventName]) {
            return r;
        }
        var _arg = args || [];
        for (var i = 0; this.ob[eventName] && i < this.ob[eventName].length; i++) {
            if (!this.ob[eventName][i]) {
                continue;
            }
            var _r = this.ob[eventName][i].apply(this, _arg);
            r = (r === false) ? r : _r;
        }

        return r;
    };

    $.Observer.prototype.once = function (eventName, callback) {
        var self = this;
        var key = self.on(eventName, function () {
            callback.apply(this, arguments);
            self.off(eventName, key);
        });
    };

    $.http = (function () {
        var $ajaxLoading = $('.ajax-loading');

        function ajax(options) {

            // default configurations.
            var defaultOptions = {
                dataType: 'json',
                ignoreAjaxLoading: false
            }, callback = {
                success: options.success,
                error: options.error
            };

            options = $.extend(defaultOptions, options);

            options.success = function (data, status, xhr) {
                /* jshint expr:true */
                (callback.success) ? callback.success(data, status, xhr) : null;
            };
            options.error = function (xhr, errorType, error) {
                var dataType = options.dataType,
                    result = xhr.responseText;
                if (result && dataType === 'json') {
                    try {
                        result = $.parseJSON(result);
                    } catch (exception) {
                        result = {msg: 'Invalid JSON format'};
                    }
                    error = result.msg;
                } else if (dataType === 'xml') {
                    result = xhr.responseXML;
                }

                /* jshint expr:true */
                (callback.error) ? callback.error(result, errorType, error, xhr) : null;
            };
            options.complete = function (xhr, status) {
                /* jshint expr:true */
                (!options.ignoreAjaxLoading) && $ajaxLoading.hide();

                (callback.complete) ? callback.complete(xhr, status) : null;
            };

            /* jshint expr:true */
            (!options.ignoreAjaxLoading) && $ajaxLoading.show();

            return $.ajax(options);
        }

        return ajax;
    })();
})(jQuery);
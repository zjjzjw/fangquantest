if (typeof String.prototype.trim !== 'function') {
    String.prototype.trim = function () {
        return this.replace(/^\s+|\s+$/g, '');
    }
}

define('utils', ['zepto'], function ($) {
    try {
        var angejiaLogo = '\n';
        var angejiaCulture = '%c理想与激情 (Dream & Passion)\n做最好的自己，把事情做到极致 (Do Your Best, Make Things Best.)\n目标一致，团队一心(One Goal, One Team)\n专注要事，快速行动 (Stay Focused and Move Fast)\n帮助他人成功 (Make Others Great)\n';
        var angejiaZhaopin = '\n%c加入绘房，你的人生会更精彩。\n';

        if (window.console && window.console.log) {
            console.log(angejiaLogo + angejiaCulture + angejiaZhaopin, "color:#FF8000", "color:#F1A40E", "color:#000;");
            console.log("请将简历发送至：%hongyu.sun@fq960.com（邮件标题请以“姓名-应聘XX职位-来自console”命名）", "color:red");
            console.log("职位介绍：")
        }
    } catch (e) {
    }

    function parseQueryString(queryString) {
        var params = {}, queries, temp, i, l;

        // Split into key/value pairs
        queries = queryString.split("&");

        // Convert the array of strings into an object
        for (i = 0, l = queries.length; i < l; i++) {
            temp = queries[i].split('=');
            params[temp[0]] = temp[1];
        }

        return params;
    }

    /**
     * Replace query string
     * @param queryString 'name=test&pass=abc'
     * @param replaceRule
     * {
     *  name: 'user'
     * }
     */
    function replaceQueryString(queryString, replaceRule) {
        var keys = [];

        var href = queryString.replace(/([\w-]+)=([\w-]+)/ig, function (result, key, value) {
            /*jshint unused:false, eqnull:true */
            var newString = result;
            if (undefined !== replaceRule[key]) {
                newString = key + '=' + replaceRule[key];
            }
            keys.push(key);
            return newString;
        });
        $.each(replaceRule, function (key, value) {

            if ($.inArray(key, keys) < 0) {
                if (href.indexOf('?') > -1) {
                    if (href.substr(href.length - 1, 1) != '&') {
                        href += '&' + key + '=' + value;
                    } else {
                        href += key + '=' + value;
                    }
                } else {
                    href += '?' + key + '=' + value;
                }
            }
        });

        return href;
    }

    /*app_title for app */
    function getAppTitle() {
        return document.querySelector('meta[name="app-title"]').getAttribute('content');
    }


    (function ($) {
        var e = {
            nextAll: function (s) {
                var $els = $(), $el = this.next();
                while ($el.length) {
                    if (typeof s === 'undefined' || $el.is(s)) {
                        $els = $els.add($el);
                    }
                    $el = $el.next();
                }
                return $els;
            },
            prevAll: function (s) {
                var $els = $(), $el = this.prev();
                while ($el.length) {
                    if (typeof s === 'undefined' || $el.is(s)) {
                        $els = $els.add($el);
                    }
                    $el = $el.prev();
                }
                return $els;
            }
        };

        $.extend($.fn, e);
    })(Zepto);

    $.utils = {
        parseQueryString: parseQueryString,
        replaceQueryString: replaceQueryString,
        getAppTitle: getAppTitle
    };

    return $.utils;
});

/**
 * Created by cuizhuochen on 2/12/15.
 */
define([], function () {
    'use strict';

    var tagOrigin = 'data-origin';

    function inputString(json) {
        var inputs = [];

        for (var k in json) {
            inputs.push("<input name='" + k + "' value='" + json[k] + "' />");
        }
        return inputs;
    }

    function formatImageSrc(json){
        var srcArray = [];

        for (var k in json) {
            srcArray.push(k + '=' + json[k]);
        }
        return srcArray;
    }

    /**
     * add extra code
     *
     * @param target
     * example:
     *  link.com#action?param=xxx
     *  link.com?param=xxx#action
     *  link.com?from=xxx
     *  link.com
     *  lnk.com/#hoverlink
     */
    function formatUrl(target) {
        var url = target.attr('href'),
            urlParts = url.split('?'),
            urlPartsLen = urlParts.length,
            paramStr = urlPartsLen > 1 ? urlParts[1] : url,
            paramParts = paramStr.split('#'),
            conn = urlPartsLen > 1 ? '&' : '?',
            combineParamStr = _combineParams(target);

        if(!combineParamStr) return '';

        var queryStr = conn + combineParamStr;

        if (urlPartsLen > 1 && paramParts.length > 1) {
            // link.com?param=xxx#action
            return urlParts[0] + '?' + paramParts[0] + queryStr + '#' + paramParts[1];
        } else {
            // link.com#action?param=xxx
            // link.com
            return url + queryStr;
        }
    }

    /**
     * combine params
     * @param target
     * @returns {string} e.g.: "from=soj&spred=spd"
     */
    function _combineParams(target){
        var url = target.attr('href'),
            originCode = target.attr(tagOrigin),
            regOrigin = /[?&]from=/;

        // if not exist "from="
        if (! regOrigin.test(url) && originCode) {
            return 'from=' + encodeURIComponent(originCode);
        }

        return '';
    }

    return {
        inputString: inputString,
        formatImageSrc: formatImageSrc,
        formatUrl: formatUrl
    };
});

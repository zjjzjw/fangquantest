/**
 * Created by cuizhuochen on 1/23/15.
 */
define(['zepto', 'ajax', 'app/modules/event/utils', 'page.params'], function ($, ajax, utils, params) {
    'use strict';

    var trackUrl = params.logServer,//'http://s.dev.angejia.com/',
        MAX_DATA_LENGTH = 2040;

    function sendTrack (option) {
        isGet(option) ? sendGet(option) : sendPost(option); // jshint ignore:line

        /*var test = {
            a:'a',
            b: {c:'c', d:'d'},
            e:[{f:'f', g:'g', m:[1, 1, 1], n:{p:'p'}}, {f1:'f1', g1:'g1', m1:{h1:'h1', i1:'i1'}}],
            k:[[1, 2, 3, 4],[1, 2, 3, 4]]
        };
        var a = utils._json2Map('', test);*/
    }

    function isGet(json) {
        return utils.formatImageSrc(json).join('&').length < MAX_DATA_LENGTH ? true : false;
    }

    function sendGet (data) {
        $.env.isIE ? _sendGet4IE(data) : _send('GET', data); // jshint ignore:line
    }

    function sendPost (data) {
        $.env.isIE ? _sendPost4IE(data) : _send('POST', data); // jshint ignore:line
    }

    function _send (type, data) {
        ajax({
            type: type,
            url: trackUrl,
            data: data,
            ignoreAjaxLoading: true
        });
    }

    function _sendGet4IE (data) {
        var img = $('<img />');
        img.attr('src', trackUrl + '?' + utils.formatImageSrc(data).join('&'));
    }

    function _sendPost4IE (data) {
        var content = $('<div></div>');
        var iframe = $('<iframe id="log-target" name="log-target"></iframe>');
        content.append(iframe);

        var form = $('<form id="test" action="' + trackUrl + '" method="POST" target="log-target"></form>');
        var inputs = utils.inputString(data);
        form.append(inputs.join(''));
        content.append(form);
        $('head').children(':first-child').before(content);

        form[0].submit();
    }

    return sendTrack;
});

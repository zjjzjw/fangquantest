/**
 * Created by cuizhuochen on 2/12/15.
 */
define(['zepto'], function($){
    'use strict';

    $.getCookie = function (name) {
        var offset, end;
        var cookievalue = "";
        var search = name + "=";

        if(document.cookie.length > 0)
        {
            offset = document.cookie.indexOf(search);

            if (offset != -1)
            {
                offset += search.length;
                end = document.cookie.indexOf(";", offset);

                if (end == -1){
                    end = document.cookie.length;
                }
                cookievalue = document.cookie.substring(offset, end);
            }
        }

        return cookievalue;
    };


    $.setCookie = function (name, value, expiredays, path) {
        /* jshint unused:false */
        var exdate = new Date();
        exdate.setDate(exdate.getDate() + expiredays);
        document.cookie = name + "=" + escape(value) + ( (expiredays == null) ? "" : ";expires=" + exdate.toGMTString()) + (path == null ? "" : ';path=' + path);
    };
});
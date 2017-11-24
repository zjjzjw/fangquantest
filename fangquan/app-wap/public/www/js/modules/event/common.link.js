/**
 * Created by cuizhuochen on 3/13/15.
 */
define(['zepto', 'app/modules/event/utils'], function ($, utils) {
    /* 处理单个 a 标签*/
    function linkHandle(target){
        var $target, url;
        if(target.tagName.toLowerCase() === 'a'){
            $target = $(target);
            if(! ($target.attr('href') && $target.attr('href').indexOf('javascript:') != 0 && $target.attr('data-origin') )) {
                return;
            }

            url = utils.formatUrl($target);
            url && $target.attr('href' , url); // jshint ignore:line
        }
    }

    /*将对 block 的处理转换为 a */
    function delegateLinkHandle(blockTarget){
        if(blockTarget.tagName.toLowerCase() === 'a') {

            linkHandle(blockTarget);
            return;
        }

        var links = $('a', blockTarget);
        if(links.length){
            links.each(function(i, v){
                linkHandle(v);
            });
        }
        return;
    }

    return {
        linkHandle: linkHandle,
        delegateLinkHandle: delegateLinkHandle
    };
});
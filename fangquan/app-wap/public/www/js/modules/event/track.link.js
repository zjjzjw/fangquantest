/**
 * Created by cuizhuochen on 1/23/15.
 */
define(['zepto', 'app/modules/event/common.link'], function ($, common) {
    var delegateClass = '.track-link';
    function trackLink() {
        $('body').on('touchstart', 'a', function(e){
            common.linkHandle(e.target);
        });

        $('body').on('touchstart', delegateClass, function(e){
            common.delegateLinkHandle(e.currentTarget);
        });
    }

    return trackLink;
});
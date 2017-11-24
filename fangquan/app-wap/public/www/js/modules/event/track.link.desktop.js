/**
 * Created by cuizhuochen on 3/13/15.
 */
define(['zepto', 'app/modules/event/common.link'], function ($, common) {
    var delegateClass = '.track-link';
    function trackLink() {
        $('body').on('mousedown', 'a', function(e){
            common.linkHandle(e.target);
        });

        $('body').on('mousedown', delegateClass, function(e){
            common.delegateLinkHandle(e.currentTarget);
        });
    }
    return trackLink;
});

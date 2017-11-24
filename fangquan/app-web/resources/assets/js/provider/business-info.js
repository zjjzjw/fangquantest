$(function () {
    //查看全部
    var $commDesc = $('.bussiness-range em');
    var $openCommDesc = $('.open-comm-desc');
    var $commDescStr = $commDesc.html();
    if ($commDescStr.length > 75) {
        $commDesc.html($commDescStr.substring(0, 65) + '...');
        $openCommDesc.show();
        $openCommDesc.click(function () {
            $commDesc.html($commDescStr);
            $openCommDesc.hide();
        });
    }
});
<?php namespace App\Service\Match;


class MatchService
{
    /**
     * 用正则表达式验证手机号码(中国大陆区)
     * @param  $num
     * @return boolean
     */
    public static function isMobile($num)
    {
        if (!$num) {
            return false;
        }

        return preg_match('/^1\d{10}$/', $num) ? true : false;
    }

    /**
     * 验证邮箱格式
     * @param $email
     * @return bool
     */
    public static function isEmail($email)
    {
        if (!$email) {
            return false;
        }
        return preg_match('/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i', $email) ? true : false;
    }

    /**
     * 验证用户昵称是否合法
     *
     * @param $nickname
     * @return bool
     */
    public static function isValidNickname($nickname)
    {
        return preg_match('/^[\x{4e00}-\x{9fa5}a-zA-Z0-9-_]{2,30}$/u', $nickname);
    }

}

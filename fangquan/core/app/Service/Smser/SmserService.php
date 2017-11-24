<?php namespace App\Service\Smser;


//短信SDK
class SmserService
{
    const VERIFY_CODE_TIMEOUT_MINUTES = 15; //短信验证码过期时间，单位分钟
    const VERIFY_CODE_FREQUENTLY_MINUTES = 1; //短信验证码发送频率，单位分钟

    /**
     * 发送附带验证码的短信
     * @param string $mobile 手机号
     * @param string $code 验证码
     */
    public static function sendMessage($mobile, $code)
    {
        $ch = curl_init();
        $post_data = array(
            "account"      => "sdk_fq960",
            "password"     => "kfhdjgh",
            "destmobile"   => $mobile,
            "msgText"      => "【房圈网】" . $code . "，验证码在" . self::VERIFY_CODE_TIMEOUT_MINUTES . "分钟内有效，请尽快完成验证。",
            "sendDateTime" => "",
        );

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $post_data = http_build_query($post_data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_URL, 'http://www.jianzhou.sh.cn/JianzhouSMSWSServer/http/sendBatchMessage');
        curl_exec($ch);

        return true;
    }
}
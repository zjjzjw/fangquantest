<?php

namespace App\Wap\Service\Weixin;


use GuzzleHttp\Client;
use Illuminate\Http\Request;

class WeixinService
{
    //将XML转为array
    function xmlToArray($xml)
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }


    function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    public function getUserToken($code)
    {
        $client = new Client();
        $appid = 'wxdf12185d1130a809';
        $appsecret = 'bf4a87e997018aeac0eff8f3b3cfe9d4';
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid
            . '&secret=' . $appsecret . '&code=' . $code . '&grant_type=authorization_code';
        $exceptions = false;
        $allow_redirects = ['strict' => false];
        $headers = [];
        $response = $client->get($url, compact('headers', 'exceptions', 'allow_redirects'));
        $contents = $response->getBody()->getContents();
        $result = json_decode($contents, true);
        return $result;
    }


    function getAccessToken()
    {
        if (!empty($access_token = \Cache::get('wap_access_token'))) {
            return $access_token;
        } else {
            $appid = 'wxdf12185d1130a809';
            $appsecret = 'bf4a87e997018aeac0eff8f3b3cfe9d4';
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $appid . '&secret=' . $appsecret;
            $arr = $this->httpCurl($url);

            \Cache::put('wap_access_token', $arr['access_token'], 120);
            return $arr['access_token'];
        }
    }


    function httpCurl($url, $type = 'get', $arr = '')
    {
        //1.初始化
        $ch = curl_init();
        //2.设置curl的参数
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($type == 'post') {
            curl_setopt($ch, CURLOPT_POST, 1);
            if (is_array($arr)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($arr, null, "&"));
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
            }

        }
        //3.执行
        $res = curl_exec($ch);
        //4.关闭curl
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        // return $res;
        return json_decode($res, true);
    }

    function signature(Request $request)
    {
        $token = 'Fq123456';
        //获取微信服务器的get请求参数
        $signature = $request->get('signature'); //微信的加密的签名
        $timestamp = $request->get('timestamp'); //时间戳
        $nonce = $request->get('nonce'); //随机数
        $echostr = $request->get('echostr'); //随机字符串

        //将$nonce  $timestamp  TOKEN  放在数组里
        $stempArr = array($nonce, $timestamp, $token);
        //排序 SORT_STRING(快速的排序)
        sort($stempArr, SORT_STRING);
        //把数组转换为字符串
        $stempStr = implode($stempArr);
        //进行sha1加密
        $stempStr = sha1($stempStr);
        //进行校验->确认请求是来自微信服务器 而不是恶意的第三方
        if ($stempStr == $signature) {
            return $echostr;
        } else {
            return false;
        }
    }

    /**
     * 发给文本消息
     * @param  string $openid
     * @return mixed
     */
    public function sendText($openid)
    {
        $token = $this->getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=' . $token;
        $data['touser'] = $openid;
        $data['msgtype'] = 'text';
        $data['text']['content'] = '您好，欢迎参加中国建材市场协会工程招标采购分会与房圈网主办的“新形势下地产行业采购、销售创新之路”。
请点击下方“南方区会议”关注详情';

        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $data = curl_exec($ch);

        return $data;

    }


    public function sendMessage($openid)
    {
        $token = $this->getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=' . $token;

        $data['touser'] = $openid;
        $data['msgtype'] = 'news';

        $redirect_url = urlencode('http://wap.fq960.com');

        $data['news']['articles'] = [
            [
                'title'       => '问卷调查',
                'description' => '',
                'picurl'      => '',
                'url'         => 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxdf12185d1130a809&redirect_uri=' . $redirect_url
                    . '&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect',
            ],
        ];

        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $data = curl_exec($ch);

        return $data;
    }


    /** 设置菜单函数 */
    public function setMenu()
    {
        $token = $this->getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . $token;

//        $redirect_url = urlencode('http://wap.fq960.com');
//        $data['button'][] =
//            [
//                'type' => 'view',
//                'name' => '南方区会议',
//                'url'  => 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxdf12185d1130a809&redirect_uri=' . $redirect_url
//                    . '&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect ',
//            ];

        $data['button'] =
            [
                [
                    'type' => 'view',
                    'name' => '展会首页',
                    'url'  => 'http://wap.fq960.com',
                ],
                [
                    'type' => 'view',
                    'name' => '项目库',
                    'url'  => 'http://wap.fq960.com/exhibition/developer-project/list',
                ],
                [
                    'type' => 'view',
                    'name' => '品牌库',
                    'url'  => 'http://wap.fq960.com/exhibition/provider/index',
                ],
            ];

        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $data = curl_exec($ch);
        return $data;

    }

}


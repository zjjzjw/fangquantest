<?php namespace App\Service\FqUser;


use App\Src\Exception\LoginException;
use App\Src\FqUser\Infra\Repository\MobileSessionRepository;
use Illuminate\Http\Request;

class CheckTokenService
{

    public static $m;
    public static $t;
    public static $user_id;
    public static $device_type;
    public static $token;

    public static function setHeaders(Request $request)
    {
        self::$token;
        self::$m = $request->header('m');
        self::$t = $request->header('t');
        self::$user_id = $request->header('userid');
        self::$token = $request->header('token');
        self::$device_type = $request->header('devicetype');
    }

    public static function getUserId()
    {
        return self::$user_id;
    }

    public static function getToken()
    {
        return self::$token;
    }

    public static function getDeviceType()
    {
        return self::$device_type;
    }

    public static function getT()
    {
        return self::$t;
    }

    public static function getM()
    {
        return self::$m;
    }

    public static function isLogin()
    {
        return (self::$user_id !== null) && !empty(self::$user_id);
    }

    public static function checkToken()
    {
        $token = self::$token;
        $user_id = self::$user_id;
        $mobile_session_repository = new MobileSessionRepository();
        if (!empty($token) && !empty($user_id)) {
            $mobile_session_entity = $mobile_session_repository->tokenValid($token, $user_id);
            if (empty($mobile_session_entity)) {
                throw new LoginException('', LoginException::ERROR_TOKEN_ILLEGAL);
            }
        }
        return true;
    }

    /**
     * 验证token失效
     * @param $token
     * @return bool
     */
    public static function apiTokenIsValid($token)
    {
        $mobile_session_repository = new MobileSessionRepository();
        $mobile_session_entity = $mobile_session_repository->tokenValid($token);
        $updated_at = strtotime($mobile_session_entity->updated_at);
        $expire = env('API_TOKEN_EXPIRE');
        if (empty($expire)) return true;
        return $updated_at + $expire >= time();
    }
}
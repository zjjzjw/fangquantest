<?php namespace App\Src\Exception;


class LoginException extends BaseException
{
    const ERROR_TOKEN_ILLEGAL = 1000;
    const ERROR_TOKEN_EXPIRE = 1001;
    const ERROR_MISS_PARAM = 1002;
    const ERROR_M_ILLEGAL = 1003;
    const ERROR_M_EXPIRE = 1004;
    const ERROR_MOBILE_PATTERN_INVALID = 1005;
    const ERROR_MOBILE_IS_EXIST = 1006;
    const ERROR_SMS_SEND_TOO_FREQUENTLY = 1007;
    const ERROR_SMS_SEND_FAILED = 1008;
    const ERROR_SMS_VERIFY_CODE_ERROR = 1009;
    const ERROR_SMS_VERIFY_CODE_TIMEOUT = 1010;
    const ERROR_REGISTER_FAILED = 1011;
    const ERROR_SMS_REGISTER_MOBILE_IS_EXIST = 1012;
    const ERROR_LOGIN_FAILED = 1013;
    const ERROR_LOGIN_FAILED_ACCOUNT_NOT_ACTIVE = 1014;
    const ERROR_SMS_SEND_RETRIEVE_PWD_PHONE_NOT_EXIST = 1015;
    const ERROR_RETRIEVE_PWD_FAILED = 1016;
    const ERROR_BIND_PHONE_FAILED = 1017;
    const ERROR_ACCOUNT_CONFIG_FAILED = 1018;
    const ERROR_NICKNAME_INVALID = 1019;
    const ERROR_DEVICE_TYPE = 1020;
    const ERROR_NOT_FOUND_API = 1021;
    const ERROR_THIRD_PARTY_NOT_REGISTER = 1022;
    const ERROR_CONTRAST_CATEGORY = 1023;
    const ERROR_ACCOUNT_PROVIDER = 1024;
    const ERROR_PROJECT_LOW_NUM = 1025;
    const ERROR_PROJECT_HIGH_NUM = 1026;
    const ERROR_USER_NOT_EXPIRE = 1027;
    const ERROR_PROJECT_MAX_NUM = 1028;
    const ERROR_PROJECT_CONTACTS = 1029;
    const ERROR_MODEL_NO_EXIST = 1030;
    const ERROR_ACCOUNT_DISABLE = 1031;
    const ERROR_NO_CONTACT_PERMISSION_AREA = 1032;
    const ERROR_NO_CONTACT_PERMISSION_CATEGORY = 1033;
    const ERROR_NO_LOGIN = 1304;
    const ERROR_NO_FORMAL_ACCOUNT = 1305;

    /**
     * 异常和 HTTP Status Code 映射
     *
     * @var array
     */
    protected $http_status_codes = [
        self::ERROR_TOKEN_ILLEGAL                         => '401',
        self::ERROR_TOKEN_EXPIRE                          => '401',
        self::ERROR_MISS_PARAM                            => '401',
        self::ERROR_M_ILLEGAL                             => '401',
        self::ERROR_M_EXPIRE                              => '401',
        self::ERROR_MOBILE_PATTERN_INVALID                => '401',
        self::ERROR_MOBILE_IS_EXIST                       => '401',
        self::ERROR_SMS_SEND_TOO_FREQUENTLY               => '401',
        self::ERROR_SMS_SEND_FAILED                       => '401',
        self::ERROR_SMS_VERIFY_CODE_ERROR                 => '401',
        self::ERROR_SMS_VERIFY_CODE_TIMEOUT               => '401',
        self::ERROR_REGISTER_FAILED                       => '401',
        self::ERROR_SMS_REGISTER_MOBILE_IS_EXIST          => '401',
        self::ERROR_LOGIN_FAILED                          => '401',
        self::ERROR_LOGIN_FAILED_ACCOUNT_NOT_ACTIVE       => '401',
        self::ERROR_SMS_SEND_RETRIEVE_PWD_PHONE_NOT_EXIST => '401',
        self::ERROR_RETRIEVE_PWD_FAILED                   => '401',
        self::ERROR_BIND_PHONE_FAILED                     => '401',
        self::ERROR_ACCOUNT_CONFIG_FAILED                 => '401',
        self::ERROR_NICKNAME_INVALID                      => '401',
        self::ERROR_DEVICE_TYPE                           => '401',
        self::ERROR_NOT_FOUND_API                         => '401',
        self::ERROR_THIRD_PARTY_NOT_REGISTER              => '401',
        self::ERROR_CONTRAST_CATEGORY                     => '401',
        self::ERROR_ACCOUNT_PROVIDER                      => '401',
        self::ERROR_PROJECT_LOW_NUM                       => '401',
        self::ERROR_PROJECT_HIGH_NUM                      => '401',
        self::ERROR_USER_NOT_EXPIRE                       => '401',
        self::ERROR_PROJECT_MAX_NUM                       => '401',
        self::ERROR_PROJECT_CONTACTS                      => '401',
        self::ERROR_MODEL_NO_EXIST                        => '401',
        self::ERROR_ACCOUNT_DISABLE                       => '401',
        self::ERROR_NO_CONTACT_PERMISSION_AREA            => '401',
        self::ERROR_NO_CONTACT_PERMISSION_CATEGORY        => '401',
        self::ERROR_NO_LOGIN                              => '401',
        self::ERROR_NO_FORMAL_ACCOUNT                     => '401',
    ];

    /**
     * 异常和文案映射
     *
     * @var array
     */
    protected $pretty_messages = [

        self::ERROR_TOKEN_ILLEGAL                         => 'token非法',
        self::ERROR_TOKEN_EXPIRE                          => 'token过期',
        self::ERROR_MISS_PARAM                            => '缺少必填参数',
        self::ERROR_M_ILLEGAL                             => 'm值非法',
        self::ERROR_M_EXPIRE                              => 'm值过期',
        self::ERROR_MOBILE_PATTERN_INVALID                => '手机格式错误',
        self::ERROR_MOBILE_IS_EXIST                       => '手机号已存在',
        self::ERROR_SMS_SEND_TOO_FREQUENTLY               => '发送短信验证码太频繁，请稍后再试',
        self::ERROR_SMS_SEND_FAILED                       => '发送短信验证码失败',
        self::ERROR_SMS_VERIFY_CODE_ERROR                 => '短信验证码错误',
        self::ERROR_SMS_VERIFY_CODE_TIMEOUT               => '短信验证码过期，请重新获取',
        self::ERROR_REGISTER_FAILED                       => '注册失败',
        self::ERROR_SMS_REGISTER_MOBILE_IS_EXIST          => '手机号已被占用',
        self::ERROR_LOGIN_FAILED                          => '帐号或密码错误',
        self::ERROR_LOGIN_FAILED_ACCOUNT_NOT_ACTIVE       => '账号未激活，请激活后再登录',
        self::ERROR_SMS_SEND_RETRIEVE_PWD_PHONE_NOT_EXIST => '手机号码不存在，请通过其他途径找回密码',
        self::ERROR_RETRIEVE_PWD_FAILED                   => '重置密码失败',
        self::ERROR_BIND_PHONE_FAILED                     => '绑定(更换)手机号失败',
        self::ERROR_ACCOUNT_CONFIG_FAILED                 => '修改用户配置失败',
        self::ERROR_NICKNAME_INVALID                      => '2-30个字符，支持中文、数字、字母、“_”、减号',
        self::ERROR_DEVICE_TYPE                           => '设备号格式错误',
        self::ERROR_NOT_FOUND_API                         => '未找到api接口',
        self::ERROR_THIRD_PARTY_NOT_REGISTER              => '该第三方账号尚未注册过',
        self::ERROR_CONTRAST_CATEGORY                     => '不同分类产品不能对比',
        self::ERROR_PROJECT_LOW_NUM                       => '你的资料完整度不足{1}%，剩余可查看普通项目数为零',
        self::ERROR_PROJECT_HIGH_NUM                      => '你的资料完整度不足{1}%，剩余可查看优质项目数为零',
        self::ERROR_PROJECT_MAX_NUM                       => '优质项目每月最多可查看20次',
        self::ERROR_USER_NOT_EXPIRE                       => '用户不存在',
        self::ERROR_ACCOUNT_PROVIDER                      => '账号不是供应商认证账号',
        self::ERROR_PROJECT_CONTACTS                      => '项目联系人只为供应商提供',
        self::ERROR_MODEL_NO_EXIST                        => '参数错误，请填写正确参数',
        self::ERROR_ACCOUNT_DISABLE                       => '该账号已被禁用',
        self::ERROR_NO_CONTACT_PERMISSION_AREA            => '您的账号尚未购买该地区的项目，无法查看联系人',
        self::ERROR_NO_CONTACT_PERMISSION_CATEGORY        => '您的账号尚未购买该类别的项目，无法查看联系人',
        self::ERROR_NO_LOGIN                              => '未登录',
        self::ERROR_NO_FORMAL_ACCOUNT                     => '账号不是正式账号',
    ];
}

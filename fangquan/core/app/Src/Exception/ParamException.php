<?php namespace App\Src\Exception;


class ParamException extends BaseException
{
    const ERROR_PARAM = 2001;

    /**
     * 异常和 HTTP Status Code 映射
     *
     * @var array
     */
    protected $http_status_codes = [
        self::ERROR_PARAM => '401',
    ];

    /**
     * 异常和文案映射
     *
     * @var array
     */
    protected $pretty_messages = [
        self::ERROR_PARAM => '参数错误',
    ];
}

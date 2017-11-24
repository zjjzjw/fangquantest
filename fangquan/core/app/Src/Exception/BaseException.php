<?php namespace App\Src\Exception;

use Exception;

/**
 * 异常基类
 *
 * @package Aifang\Exception
 */
class BaseException extends Exception
{
    /**
     * 未知错误码
     */
    const CODE_UNKNOWN = '9999';
    const CODE_CONCURRENCY = '9998';

    /**
     * 异常和 HTTP Status Code 映射
     *
     * @var array
     */
    protected $http_status_codes = [
        self::CODE_CONCURRENCY => 503,
    ];

    /**
     * @var int
     */
    protected $default_http_status_code = 400;

    /**
     * 异常和文案映射
     *
     * @var array
     */
    protected $pretty_messages = [
        self::CODE_CONCURRENCY => self::CONCURRENCY_PRETTY_MESSAGE,
    ];

    const DEFAULT_PRETTY_MESSAGE = '系统错误，请重试或联系客服。';
    const CONCURRENCY_PRETTY_MESSAGE = '请求过快。';

    /**
     * 获取错误码
     *
     * @return int|mixed|string
     */
    public function getErrorCode()
    {
        $code = parent::getCode();
        if ($code < 1000) {
            $code = self::CODE_UNKNOWN;
        }

        return $code;
    }

    /**
     * 获取 HTTP 状态码
     *
     * @return int
     */
    public function getHttpStatusCode()
    {
        return isset($this->http_status_codes[$this->getCode()])
            ? $this->http_status_codes[$this->getCode()]
            : $this->default_http_status_code;
    }

    /**
     * 获取友好的业务文案
     *
     * @return int
     */
    public function getPrettyMessage()
    {
        return isset($this->pretty_messages[$this->getCode()])
            ? $this->pretty_messages[$this->getCode()]
            : self::DEFAULT_PRETTY_MESSAGE;
    }
}

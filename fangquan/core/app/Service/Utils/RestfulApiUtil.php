<?php namespace App\Service\Utils;

use stdClass;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class RestfulApiUtil
{
    /**
     * 通用 Headers
     *
     * @param \Illuminate\Http\Request                   $request
     * @param \Symfony\Component\HttpFoundation\Response $response
     */
    public static function commonHeaders(Request $request, SymfonyResponse $response)
    {
        $headers = [
            'App-Clock' => date('Y-m-d H:i:s'),
        ];
        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }
    }

    /**
     * 通用 Headers
     *
     * @param \Illuminate\Http\Request                   $request
     * @param \Symfony\Component\HttpFoundation\Response $response
     */
    public static function jsonResponse(Request $request, SymfonyResponse $response)
    {
        $camel_case = (bool)$request->header('App-CamelCase', true);
        $stringify = (bool)$request->header('App-Stringify', true);

        if ($response instanceof JsonResponse) {
            /* @var \Illuminate\Http\JsonResponse $response */
            $data = $response->getData();
            if (static::isObjectOrArray($data)) {
                $data = static::normalize($data);

                if ($camel_case) {
                    $data = static::camelCaseJsonResponse($data);
                }

                if ($stringify) {
                    $data = static::stringifyJsonResponse($data);
                }

                $response->setData($data);

                // JSON 结果为空时，强制结果为 {}
                if (empty($data)) {
                    $response->setContent('{}');
                }
            }
        } elseif ($response instanceof Response) {
            /* @var \Illuminate\Http\Response $response */
            $content = $response->getContent();
            if (static::isJsonObjectOrArray($content)) {
                $data = json_decode($content);
                $data = static::normalize($data);

                if ($camel_case) {
                    $data = static::camelCaseJsonResponse($data);
                }

                if ($stringify) {
                    $data = static::stringifyJsonResponse($data);
                }

                $response->setContent(json_encode($data));

                // JSON 结果为空时，强制结果为 {}
                if (empty($data)) {
                    $response->setContent('{}');
                }
            }
        }
    }

    protected static function isObjectOrArray($var)
    {
        return is_object($var) || is_array($var);
    }

    protected static function isJsonObjectOrArray($str)
    {
        $str = trim($str);
        if (!(Str::startsWith($str, '{')) && !(Str::startsWith($str, '{'))) {
            return false;
        }

        $var = json_decode($str);
        return json_last_error() == JSON_ERROR_NONE && static::isObjectOrArray($var);
    }

    /**
     * 提取对象或数组中可访问的数据
     *
     * @param $data
     *
     * @return stdClass|array|mixed
     */
    protected static function normalize($data)
    {
        if (is_object($data)) {
            $result = new stdClass();
            foreach ($data as $key => $sub_data) {
                $result->$key = static::normalize($sub_data);
            }
            return $result;
        } elseif (is_array($data)) {
            foreach ($data as $key => &$sub_data) {
                $sub_data = static::normalize($sub_data);
            }
            return $data;
        } else {
            return $data;
        }
    }

    protected static function camelCaseJsonResponse($data)
    {
        if (is_object($data)) {
            $result = new stdClass();
            foreach ($data as $key => $sub_data) {
                $result->{Str::camel($key)} = static::camelCaseJsonResponse($sub_data);
            }
            return $result;
        } elseif (is_array($data)) {
            $result = [];
            foreach ($data as $key => $sub_data) {
                $result[Str::camel($key)] = static::camelCaseJsonResponse($sub_data);
            }
            return $result;
        } else {
            return $data;
        }
    }

    public static function stringifyJsonResponse($data)
    {
        if (is_object($data)) {
            $result = new stdClass();
            foreach ($data as $key => $sub_data) {
                $result->$key = static::stringifyJsonResponse($sub_data);
            }
            return $result;
        } elseif (is_array($data)) {
            foreach ($data as $key => &$sub_data) {
                $sub_data = static::stringifyJsonResponse($sub_data);
            }
            return $data;
        } else {
            return (string)$data;
        }
    }
}

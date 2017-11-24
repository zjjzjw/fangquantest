<?php

return [
    // UI pages configurations.
    //IMPORTANT: Please override in YOUR LOCAL config.
    'host'        => env('PAGE_HOST', '/www'),
    'debug'       => env('PAGE_DEBUG', true),
    'server'      => array(
        'log' => env('PAGE_LOG_SERVER_URL', 'http://s.fq960.com/uba'),
    ),
    'baiduhmtkey' => env('PAGE_BAIDU_HMT_KEY', '699404de6fefd77dd900c2697310a888'),
    'activity'    => [
        'items' => [

        ],
    ],
    'from_code'   => [
    ],
];

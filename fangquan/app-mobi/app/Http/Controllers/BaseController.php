<?php

namespace App\Mobi\Http\Controllers;

class BaseController extends Controller
{
    protected function view($view, $data = array())
    {
        $data = array_merge(
            [
                'basic_data' => [
                    'user' => request()->user(),
                ],
            ],
            $data
        );
        return view($view, $data);
    }
}



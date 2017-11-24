<?php

namespace App\Web\Http\Controllers\Exhibition;

use App\Web\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class BroadcastController extends BaseController
{
    public function detail(Request $request)
    {

        $data = [];
        return $this->view('pages.exhibition.broadcast.detail', $data);

    }


}
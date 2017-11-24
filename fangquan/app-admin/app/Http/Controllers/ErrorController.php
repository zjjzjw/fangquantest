<?php

namespace App\Admin\Http\Controllers;

class ErrorController extends BaseController
{
    public function index()
    {
        $data = [];
        return $this->view('pages.error.index', $data);
    }

    public function store()
    {

    }

    public function update()
    {

    }
}



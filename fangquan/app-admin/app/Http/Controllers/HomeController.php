<?php

namespace App\Admin\Http\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        $data = [];
        return $this->view('pages.home.index', $data);
    }

    public function store()
    {

    }

    public function update()
    {

    }
}



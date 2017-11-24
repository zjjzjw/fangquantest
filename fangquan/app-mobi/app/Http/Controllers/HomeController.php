<?php

namespace App\Mobi\Http\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        $data = [];
        return view('home.index', $data);
    }

    public function store()
    {

    }

    public function update()
    {

    }
}



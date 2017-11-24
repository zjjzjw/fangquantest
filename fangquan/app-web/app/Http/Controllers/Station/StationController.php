<?php

namespace App\Web\Http\Controllers\Station;

use App\Web\Http\Controllers\BaseController;
use Illuminate\Http\Request;


class StationController extends BaseController
{
    public function about(Request $request)
    {
        return $this->view('pages.station.about');
    }

    public function contact(Request $request)
    {
        return $this->view('pages.station.contact');
    }

    public function agreement(Request $request)
    {
        return $this->view('pages.station.agreement');
    }

    public function recruitmen(Request $request)
    {
        return $this->view('pages.station.recruitmen');
    }

}
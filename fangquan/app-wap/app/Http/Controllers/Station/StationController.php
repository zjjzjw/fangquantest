<?php

namespace App\Wap\Http\Controllers\Station;

use App\Wap\Http\Controllers\BaseController;
use Illuminate\Http\Request;


class StationController extends BaseController
{
    public function about(Request $request)
    {
        return $this->view('pages.station.about');
    }

    public function contact(Request $request)
    {
        $data = [];
        $this->title = '首届房地产创新采购展';
        $this->file_css = 'pages.station.contact';
        $this->file_js = 'pages.station.contact';

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
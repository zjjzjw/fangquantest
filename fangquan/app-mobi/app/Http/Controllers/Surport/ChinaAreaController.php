<?php

namespace App\Mobi\Http\Controllers\Surport;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Surport\ChinaAreaMobiService;
use Illuminate\Http\Request;

class ChinaAreaController extends BaseController
{
    public function areaList(Request $request)
    {
        $china_area_mobi_service = new ChinaAreaMobiService();
        $china_areas = $china_area_mobi_service->getChinaArea();
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $china_areas;
        return response()->json($data, 200);
    }

}



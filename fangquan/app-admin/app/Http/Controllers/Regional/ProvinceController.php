<?php

namespace App\Admin\Http\Controllers\Regional;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Regional\Province\ProvinceSearchForm;
use App\Service\Regional\ChinaAreaService;
use App\Service\Regional\ProvinceService;
use App\Src\Surport\Domain\Model\ProvinceSpecification;
use Illuminate\Http\Request;

class ProvinceController extends BaseController
{

    public function index(Request $request, ProvinceSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $province_service = new ProvinceService();
        $data = $province_service->getProvinceList($form->province_specification, 20);
        $appends = $this->getAppends($form->province_specification);
        $data['appends'] = $appends;
        return $this->view('pages.regional.province.index', $data);

    }

    public function edit(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $province_service = new ProvinceService();
            $data = $province_service->getProvinceInfo($id);
        }
        $china_area_service = new ChinaAreaService();
        $data['area_list'] = $china_area_service->getAllChinaArea();
        return $this->view('pages.regional.province.edit', $data);
    }

    public function getAppends(ProvinceSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }
}
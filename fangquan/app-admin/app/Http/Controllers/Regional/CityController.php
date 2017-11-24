<?php

namespace App\Admin\Http\Controllers\Regional;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Regional\City\CitySearchForm;
use App\Service\Regional\CityService;
use App\Service\Regional\ProvinceService;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Surport\Domain\Model\CitySpecification;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use Illuminate\Http\Request;

class CityController extends BaseController
{

    public function index(Request $request, CitySearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $city_service = new CityService();
        $data = $city_service->getCityList($form->city_specification, 20);

        $province_service = new ProvinceService();
        $provinces = $province_service->getAllProvince();

        $appends = $this->getAppends($form->city_specification);
        $data['appends'] = $appends;
        $data['provinces'] = $provinces;
        return $this->view('pages.regional.city.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $city_service = new CityService();
            $data = $city_service->getCityInfo($id);
        }
        $province_service = new ProvinceService();
        $data['province_list'] = $province_service->getAllProvince();

        return $this->view('pages.regional.city.edit', $data);
    }

    public function getAppends(CitySpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        if ($spec->province_id) {
            $appends['province_id'] = $spec->province_id;
        }
        return $appends;
    }
}
<?php

namespace App\Admin\Http\Controllers\Regional;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Regional\ChinaArea\ChinaAreaSearchForm;
use App\Service\Regional\ChinaAreaService;
use App\Src\Surport\Domain\Model\ChinaAreaSpecification;
use Illuminate\Http\Request;

class ChinaAreaController extends BaseController
{

    public function index(Request $request, ChinaAreaSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $china_area_service = new ChinaAreaService();
        $data = $china_area_service->getChinaAreaList($form->china_area_specification, 20);
        $appends = $this->getAppends($form->china_area_specification);
        $data['appends'] = $appends;
        return $this->view('pages.regional.china-area.index', $data);

    }

    public function edit(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $china_area_service = new ChinaAreaService();
            $data = $china_area_service->getChinaAreaInfo($id);
        }
        return $this->view('pages.regional.china-area.edit', $data);
    }

    public function getAppends(ChinaAreaSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }
}
<?php namespace App\Admin\Http\Controllers\Developer;

use App\Admin\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Admin\Src\Forms\Loupan\LoupanSearchForm;
use App\Service\Loupan\LoupanService;
use App\Service\Developer\DeveloperService;
use App\Service\Surport\ProvinceService;
use App\Src\Loupan\Domain\Model\LoupanSpecification;


/**
 * 楼盘列表
 * Class LoupanController
 * @package App\Admin\Http\Controllers\Developer
 */
class LoupanController extends BaseController
{
    public function index(Request $request, LoupanSearchForm $form)
    {
        $data = [];
        $loupan_service = new LoupanService();
        $form->validate($request->all());
        $data = $loupan_service->getLoupanList($form->loupan_specification, 20);
        $appends = $this->getAppends($form->loupan_specification);
        $data['appends'] = $appends;
        $view = $this->view('pages.developer.loupan.index', $data);
        return $view;
    }

    public function edit(Request $request, LoupanSearchForm $form, $id)
    {
        $data = [];
        $province_service = new ProvinceService();
        if (!empty($id)) {
            $loupan_service = new LoupanService();
            $data = $loupan_service->getLoupanInfo($id);
        }
        $data['areas'] = $province_service->getProvinceForSearch();
        $view = $this->view('pages.developer.loupan.edit', $data);
        return $view;
    }

    public function getAppends(LoupanSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }
}

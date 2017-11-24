<?php namespace App\Admin\Http\Controllers\Brand;

use App\Admin\Src\Forms\Brand\BrandCooperation\BrandCooperationSearchForm;
use App\Service\Brand\BrandCooperationService;
use App\Service\Brand\BrandService;
use App\Service\Category\CategoryService;
use App\Src\Brand\Domain\Model\BrandCooperationSpecification;
use App\Src\Brand\Domain\Model\BrandCooperationType;
use Illuminate\Http\Request;
use App\Admin\Http\Controllers\BaseController;

class BrandCooperationController extends BaseController
{
    public function index(Request $request, BrandCooperationSearchForm $form, $brand_id)
    {
        $data = [];
        $brand_cooperation_service = new BrandCooperationService();
        $request->merge(['brand_id' => $brand_id]);
        $form->validate($request->all());
        $data = $brand_cooperation_service->getBrandCooperationList($form->brand_cooperation_specification, 20);

        $brand_service = new BrandService();
        $data['brand_progress'] = $brand_service->getProgress($brand_id);
        $appends = $this->getAppends($form->brand_cooperation_specification);
        $data['appends'] = $appends;

        $data['brand_id'] = $brand_id;
        return $this->view('pages.brand.cooperation.index', $data);
    }

    public function edit(Request $request, $brand_id, $id)
    {
        $data = [];
        if (!empty($brand_id) && !empty($id)) {
            $brand_cooperation_service = new BrandCooperationService();
            $data = $brand_cooperation_service->getBrandCooperationInfo($id);
        }

        $brand_service = new BrandService();
        $data['brand_progress'] = $brand_service->getProgress($brand_id);

        $data['brand_cooperation_type'] = BrandCooperationType::acceptableEnums();
        $data['brand_id'] = $brand_id;
        $category_service = new CategoryService();
        $data['categorys'] = $category_service->getCategoryLists();
        $data['id'] = $id;
        return $this->view('pages.brand.cooperation.edit', $data);
    }

    public function getAppends(BrandCooperationSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        if ($spec->brand_id) {
            $appends['brand_id'] = $spec->brand_id;
        }
        return $appends;
    }
}

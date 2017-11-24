<?php namespace App\Admin\Http\Controllers\Brand;

use App\Admin\Src\Forms\Brand\BrandSignList\BrandSignListSearchForm;
use App\Service\Brand\BrandService;
use App\Service\Brand\BrandSignListService;
use App\Service\Category\CategoryService;
use App\Service\Surport\ProvinceService;
use App\Src\Brand\Domain\Model\BrandSignListSpecification;
use Illuminate\Http\Request;
use App\Admin\Http\Controllers\BaseController;

class BrandSignListController extends BaseController
{
    public function index(Request $request, BrandSignListSearchForm $form, $brand_id)
    {
        $data = [];
        $brand_sign_list_service = new BrandSignListService();
        $request->merge(['brand_id' => $brand_id]);
        $form->validate($request->all());
        $data = $brand_sign_list_service->getBrandSignListList($form->brand_sign_list_specification, 20);
        $brand_service = new BrandService();
        $data['brand_progress'] = $brand_service->getProgress($brand_id);
        $appends = $this->getAppends($form->brand_sign_list_specification);
        $data['appends'] = $appends;
        $data['brand_id'] = $brand_id;
        return $this->view('pages.brand.brand-sign.index', $data);
    }

    public function edit(Request $request, $brand_id, $id)
    {
        $data = [];
        if (!empty($brand_id) && !empty($id)) {
            $brand_sign_list_service = new BrandSignListService();
            $data = $brand_sign_list_service->getBrandSignListInfo($id);
        }
        $province_service = new ProvinceService();
        $areas = $province_service->getProvinceForSearch();
        $category_service = new CategoryService();
        $data['categorys'] = $category_service->getCategoryLists();

        $data['areas'] = $areas;
        $data['brand_id'] = $brand_id;
        $data['id'] = $id;
        $brand_service = new BrandService();
        $data['brand_progress'] = $brand_service->getProgress($brand_id);
        return $this->view('pages.brand.brand-sign.edit', $data);
    }

    public function getAppends(BrandSignListSpecification $spec)
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

<?php namespace App\Admin\Http\Controllers\Brand;


use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Brand\BrandCustomProduct\BrandCustomProductSearchForm;
use App\Service\Brand\BrandCustomProductService;
use App\Service\Brand\BrandService;
use App\Src\Brand\Domain\Model\BrandCustomProductSpecification;
use Illuminate\Http\Request;

class BrandCustomProductController extends BaseController
{

    public function index(Request $request, BrandCustomProductSearchForm $form, $brand_id)
    {
        $data = [];
        $brand_custom_product_service = new BrandCustomProductService();
        $request->merge(['brand_id' => $brand_id]);
        $form->validate($request->all());
        $data = $brand_custom_product_service->getBrandCustomProductList($form->brand_custom_product_specification, 20);

        $brand_service = new BrandService();
        $data['brand_progress'] = $brand_service->getProgress($brand_id);

        $appends = $this->getAppends($form->brand_custom_product_specification);
        $data['appends'] = $appends;
        $data['brand_id'] = $brand_id;

        return $this->view('pages.brand.custom-product.index', $data);
    }

    public function edit(Request $request, $brand_id, $id)
    {
        $data = [];
        if (!empty($brand_id) && !empty($id)) {
            $brand_custom_product_service = new BrandCustomProductService();
            $data = $brand_custom_product_service->getBrandCustomProductInfo($id);
        }

        $brand_service = new BrandService();
        $data['brand_progress'] = $brand_service->getProgress($brand_id);
        $data['brand_id'] = $brand_id;

        return $this->view('pages.brand.custom-product.edit', $data);
    }

    public function getAppends(BrandCustomProductSpecification $spec)
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

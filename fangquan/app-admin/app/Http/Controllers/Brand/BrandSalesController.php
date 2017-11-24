<?php namespace App\Admin\Http\Controllers\Brand;


use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Brand\BrandSale\BrandSaleSearchForm;
use App\Service\Brand\BrandSaleService;
use App\Service\Brand\BrandService;
use App\Src\Brand\Domain\Model\BrandSaleAreaType;
use App\Src\Brand\Domain\Model\BrandSaleSpecification;
use App\Src\Brand\Domain\Model\BrandSaleType;
use Illuminate\Http\Request;

class BrandSalesController extends BaseController
{

    public function index(Request $request, BrandSaleSearchForm $form, $brand_id)
    {
        $data = [];
        $brand_sale_service = new BrandSaleService();
        $request->merge(['brand_id' => $brand_id]);
        $form->validate($request->all());
        $data = $brand_sale_service->getBrandSaleList($form->brand_sale_specification, 20);
        $brand_service = new BrandService();
        $data['brand_progress'] = $brand_service->getProgress($brand_id);
        $appends = $this->getAppends($form->brand_sale_specification);
        $data['appends'] = $appends;
        $data['brand_id'] = $brand_id;
        $data['brand_sale_type'] = BrandSaleType::acceptableEnums();
        return $this->view('pages.brand.brand-sales.index', $data);
    }

    public function edit(Request $request, $brand_id, $id)
    {
        $data = [];
        if (!empty($brand_id) && !empty($id)) {
            $brand_sale_service = new BrandSaleService();
            $data = $brand_sale_service->getBrandSaleInfo($id);
        }
        $brand_service = new BrandService();
        $data['brand_progress'] = $brand_service->getProgress($brand_id);
        $data['brand_sale_type'] = BrandSaleType::acceptableEnums();
        $data['brand_sale_area_type'] = BrandSaleAreaType::acceptableEnums();
        $data['brand_id'] = $brand_id;
        return $this->view('pages.brand.brand-sales.edit', $data);
    }

    public function getAppends(BrandSaleSpecification $spec)
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

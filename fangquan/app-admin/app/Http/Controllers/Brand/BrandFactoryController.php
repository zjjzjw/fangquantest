<?php namespace App\Admin\Http\Controllers\Brand;


use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Brand\BrandFactory\BrandFactorySearchForm;
use App\Service\Brand\BrandFactoryService;
use App\Service\Brand\BrandService;
use App\Service\Surport\ProvinceService;
use App\Src\Brand\Domain\Model\BrandFactoryModelType;
use App\Src\Brand\Domain\Model\BrandFactorySpecification;
use App\Src\Brand\Domain\Model\BrandFactoryType;
use Illuminate\Http\Request;

class BrandFactoryController extends BaseController
{

    public function index(Request $request, BrandFactorySearchForm $form, $brand_id)
    {
        $data = [];
        $brand_factory_service = new BrandFactoryService();
        $request->merge(['brand_id' => $brand_id]);
        $form->validate($request->all());
        $data = $brand_factory_service->getBrandFactoryList($form->brand_factory_specification, 20);
        $brand_service = new BrandService();
        $data['brand_progress'] = $brand_service->getProgress($brand_id);

        $appends = $this->getAppends($form->brand_factory_specification);
        $data['appends'] = $appends;
        $data['brand_id'] = $brand_id;
        return $this->view('pages.brand.brand-factory.index', $data);
    }

    public function edit(Request $request, $brand_id, $id)
    {
        $data = [];
        if (!empty($brand_id) && !empty($id)) {
            $brand_factory_service = new BrandFactoryService();
            $data = $brand_factory_service->getBrandFactoryInfo($id);
        }
        $data['brand_factory_type'] = BrandFactoryType::acceptableEnums();
        $province_service = new ProvinceService();
        $areas = $province_service->getProvinceForSearch();
        $data['areas'] = $areas;
        $data['brand_id'] = $brand_id;
        $data['unit_arr'] = [
            1  => '平方米(m2)',
            2  => '平方公里(km2)',
            3  => '公顷(ha)',
            4  => '市亩',
            5  => '英亩',
            6  => '平方英里(sq mi)',
            7  => '平方竿(sq rd)',
            8  => '平方码(sq yd)',
            9  => '平方英尺(sq ft)',
            10 => '平方英寸(sq in)',
        ];

        $brand_service = new BrandService();
        $data['brand_progress'] = $brand_service->getProgress($brand_id);

        return $this->view('pages.brand.brand-factory.edit', $data);
    }

    public function getAppends(BrandFactorySpecification $spec)
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

<?php namespace App\Admin\Http\Controllers\Brand;


use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Brand\BrandSupplementary\BrandSupplementarySearchForm;
use App\Service\Brand\BrandService;
use App\Service\Brand\BrandSupplementaryService;
use App\Src\Brand\Domain\Model\BrandSupplementarySpecification;
use Illuminate\Http\Request;

class SupplementaryController extends BaseController
{


    public function index(Request $request, BrandSupplementarySearchForm $form, $brand_id)
    {
        $data = [];
        $brand_supplementary_service = new BrandSupplementaryService();
        $request->merge(['brand_id' => $brand_id]);
        $form->validate($request->all());
        $data = $brand_supplementary_service->getBrandSupplementaryList($form->brand_supplementary_specification, 20);
        $brand_service = new BrandService();
        $data['brand_progress'] = $brand_service->getProgress($brand_id);
        $appends = $this->getAppends($form->brand_supplementary_specification);
        $data['appends'] = $appends;
        $data['brand_id'] = $brand_id;
        return $this->view('pages.brand.supplementary.index', $data);
    }


    public function edit(Request $request, $brand_id, $id)
    {
        $data = [];
        if (!empty($brand_id) && !empty($id)) {
            $brand_supplementary_service = new BrandSupplementaryService();
            $data = $brand_supplementary_service->getBrandSupplementaryInfo($id);
        }
        $brand_service = new BrandService();
        $data['brand_progress'] = $brand_service->getProgress($brand_id);
        $data['brand_id'] = $brand_id;
        return $this->view('pages.brand.supplementary.edit', $data);
    }

    public function getAppends(BrandSupplementarySpecification $spec)
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

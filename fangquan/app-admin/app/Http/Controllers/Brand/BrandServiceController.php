<?php namespace App\Admin\Http\Controllers\Brand;

use App\Admin\Http\Controllers\BaseController;
use App\Service\Brand\BrandService;
use App\Service\Brand\BrandServiceService;
use App\Src\Brand\Domain\Model\ServiceType;
use Illuminate\Http\Request;

class BrandServiceController extends BaseController
{
    public function edit(Request $request, $id)
    {
        $data = [];
        $brand_service_service = new BrandServiceService();
        $data = $brand_service_service->getBrandServiceInfo($id);
        $brand_service = new BrandService();
        $data['brand_progress'] = $brand_service->getProgress($id);
        $data['service_types'] = ServiceType::acceptableEnums();
        $data['brand_id'] = $id;
        return $this->view('pages.brand.brand-service.edit', $data);
    }

}

<?php namespace App\Admin\Http\Controllers\Brand;


use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Brand\BrandCertificate\BrandCertificateSearchForm;
use App\Service\Brand\BrandCertificateService;
use App\Service\Brand\BrandService;
use App\Src\Brand\Domain\Model\BrandCertificateSpecification;
use App\Src\Brand\Domain\Model\BrandCertificateType;
use Illuminate\Http\Request;

class BrandCertificateController extends BaseController
{


    public function index(Request $request, BrandCertificateSearchForm $form, $brand_id)
    {
        $data = [];
        $brand_certificate_service = new BrandCertificateService();
        $request->merge(['brand_id' => $brand_id]);
        $form->validate($request->all());
        $data = $brand_certificate_service->getBrandCertificateList($form->brand_certificate_specification, 20);


        $brand_service = new BrandService();
        $data['brand_progress'] = $brand_service->getProgress($brand_id);


        $appends = $this->getAppends($form->brand_certificate_specification);
        $data['appends'] = $appends;
        $data['brand_id'] = $brand_id;
        return $this->view('pages.brand.brand-certificate.index', $data);
    }


    public function edit(Request $request, $brand_id, $id)
    {
        $data = [];
        if (!empty($brand_id) && !empty($id)) {
            $brand_certificate_service = new BrandCertificateService();
            $data = $brand_certificate_service->getBrandCertificateInfo($id);
        }
        $data['brand_certificate_type'] = BrandCertificateType::acceptableEnums();
        $brand_service = new BrandService();
        $data['brand_progress'] = $brand_service->getProgress($brand_id);

        $data['brand_id'] = $brand_id;
        return $this->view('pages.brand.brand-certificate.edit', $data);
    }

    public function getAppends(BrandCertificateSpecification $spec)
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

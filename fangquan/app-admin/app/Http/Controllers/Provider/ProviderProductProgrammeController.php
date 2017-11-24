<?php namespace App\Admin\Http\Controllers\Provider;


use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Provider\ProviderProductProgramme\ProviderProductProgrammeSearchForm;
use App\Service\Provider\ProviderProductProgrammeService;
use App\Service\Provider\ProviderProductService;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderProductProgrammeSpecification;
use App\Src\Provider\Domain\Model\ProviderProductProgrammeStatus;
use App\Src\Provider\Domain\Model\ProviderProductStatus;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use Illuminate\Http\Request;


class ProviderProductProgrammeController extends BaseController
{
    public function index(Request $request, ProviderProductProgrammeSearchForm $form, $provider_id)
    {
        $data = [];
        $request->merge(['provider_id' => $provider_id]);
        $form->validate($request->all());
        $provider_product_programme_service = new ProviderProductProgrammeService();
        $data = $provider_product_programme_service->getProviderProductProgrammeList($form->provider_product_programme_specification, 20);
        $appends = $this->getAppends($form->provider_product_programme_specification);
        $data['appends'] = $appends;
        $data['provider_id'] = $provider_id;
        return $this->view('pages.provider.provider-product-programme.index', $data);
    }

    public function edit(Request $request, $provider_id, $id)
    {
        $data = [];
        if (!empty($id)) {
            $provider_product_programme_service = new ProviderProductProgrammeService();
            $data = $provider_product_programme_service->getProviderProductProgrammeInfo($id);
        }

        $provider_product_service = new ProviderProductService();
        $data['provider_product_lists'] = $provider_product_service->getProviderProductListByProviderIdAndStatus(
            $provider_id, ProviderProductStatus::STATUS_PASS
        );
        $data['provider_product_programme_status'] = ProviderProductProgrammeStatus::acceptableEnums();
        $data['provider_id'] = $provider_id;
        $data['id'] = $id;
        return $this->view('pages.provider.provider-product-programme.edit', $data);
    }

    /**
     * @param ProviderProductProgrammeSpecification $spec
     * @return array
     */
    public function getAppends(ProviderProductProgrammeSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        if ($spec->provider_id) {
            $appends['provider_id'] = $spec->provider_id;
            $provider_repository = new ProviderRepository();
            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($spec->provider_id);
            if (isset($provider_entity)) {
                $appends['company_name'] = $provider_entity->company_name;
            }
        }
        if ($spec->status) {
            $appends['status'] = $spec->status;
        }

        return $appends;
    }

    public function list(Request $request, ProviderProductProgrammeSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $provider_product_programme_service = new ProviderProductProgrammeService();
        $data = $provider_product_programme_service->getProviderProductProgrammeList($form->provider_product_programme_specification, 20);
        $appends = $this->getAppends($form->provider_product_programme_specification);
        $data['appends'] = $appends;
        $data['provider_product_programme_status'] = ProviderProductProgrammeStatus::acceptableEnums();
        return $this->view('pages.provider.provider-product-programme.list', $data);
    }

    public function audit(Request $request, $id)
    {
        if (!empty($id)) {
            $provider_product_programme_service = new ProviderProductProgrammeService();
            $data = $provider_product_programme_service->getProviderProductProgrammeInfo($id);
        }
        $data['id'] = $id;
        return $this->view('pages.provider.provider-product-programme.audit', $data);
    }
}

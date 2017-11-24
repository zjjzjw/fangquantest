<?php namespace App\Admin\Http\Controllers\Provider;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Provider\ProviderCertificate\ProviderCertificateSearchForm;
use App\Service\Provider\ProviderCertificateService;
use App\Src\Provider\Domain\Model\ProviderCertificateSpecification;
use App\Src\Provider\Domain\Model\ProviderCertificateStatus;
use App\Src\Provider\Domain\Model\ProviderCertificateType;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use Illuminate\Http\Request;

/**
 * 供应商企业证书表
 * Class ProviderServiceNetworkController
 * @package App\Admin\Http\Controllers\Provider
 */
class ProviderCertificateController extends BaseController
{
    /**
     * 供应商企业证书列表页
     * @param Request                       $request
     * @param ProviderCertificateSearchForm $form
     * @param                               $provider_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, ProviderCertificateSearchForm $form, $provider_id)
    {
        $data = [];
        $request->merge(['provider_id' => $provider_id]);
        $form->validate($request->all());
        $provider_certificate_service = new ProviderCertificateService();
        $data = $provider_certificate_service->getProviderCertificateList($form->provider_certificate_specification, 10);
        $appends = $this->getAppends($form->provider_certificate_specification);
        $data['provider_id'] = $provider_id;
        $data['appends'] = $appends;

        return $this->view('pages.provider.provider-certificate.index', $data);
    }

    public function edit(Request $request, $provider_id, $id)
    {
        $data = [];
        $provider_certificate_service = new ProviderCertificateService();
        if (!empty($id)) {
            $data = $provider_certificate_service->getProviderCertificateInfo($id);
        }
        $provider_certificate_types = ProviderCertificateType::acceptableEnums();
        $data['provider_certificate_types'] = $provider_certificate_types;
        $data['provider_id'] = $provider_id;
        $data['id'] = $id;

        return $this->view('pages.provider.provider-certificate.edit', $data);
    }

    /**
     * 企业证书审核列表页
     * @param Request                       $request
     * @param ProviderCertificateSearchForm $form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request, ProviderCertificateSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $provider_certificate_service = new ProviderCertificateService();
        $data = $provider_certificate_service->getProviderCertificateList(
            $form->provider_certificate_specification, 20);
        $provider_certificate_statuses = ProviderCertificateStatus::acceptableEnums();
        $data['provider_certificate_statues'] = $provider_certificate_statuses;
        $appends = $this->getAppends($form->provider_certificate_specification);
        $data['appends'] = $appends;
        return $this->view('pages.provider.provider-certificate.list', $data);
    }


    public function audit(Request $request, $id)
    {
        $data = [];
        $provider_certificate_service = new ProviderCertificateService();
        if (!empty($id)) {
            $data = $provider_certificate_service->getProviderCertificateInfo($id);
        }
        $data['id'] = $id;
        return $this->view('pages.provider.provider-certificate.audit', $data);
    }

    /**
     * @param ProviderCertificateSpecification $spec
     * @return array
     */
    public function getAppends(ProviderCertificateSpecification $spec)
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
            $appends['company_name'] = $provider_entity->company_name;
        }
        if ($spec->status) {
            $appends['status'] = $spec->status;
        }


        return $appends;
    }
}

<?php namespace App\Admin\Http\Controllers\Provider;


use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Provider\ProviderServiceNetwork\ProviderServiceNetworkSearchForm;
use App\Service\Provider\ProviderServiceNetworkService;
use App\Service\Surport\ProvinceService;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderServiceNetworkSpecification;
use App\Src\Provider\Domain\Model\ProviderServiceNetworkStatus;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use Illuminate\Http\Request;

/**
 * 企业服务网点
 * Class ProviderServiceNetworkController
 * @package App\Admin\Http\Controllers\Provider
 */
class ProviderServiceNetworkController extends BaseController
{
    public function index(Request $request, ProviderServiceNetworkSearchForm $form, $provider_id)
    {
        $data = [];
        $request->merge(['provider_id' => $provider_id]);
        $form->validate($request->all());

        $provider_service_network_service = new ProviderServiceNetworkService();
        $data = $provider_service_network_service->getProviderServiceNetworkList($form->provider_service_network_specification, 20);
        $appends = $this->getAppends($form->provider_service_network_specification);
        $data['provider_id'] = $provider_id;
        $data['appends'] = $appends;

        return $this->view('pages.provider.provider-service-network.index', $data);
    }

    public function edit(Request $request, $provider_id, $id)
    {
        $data = [];
        $provider_service_network_service = new ProviderServiceNetworkService();
        $province_service = new ProvinceService();

        if (!empty($id)) {
            $data = $provider_service_network_service->getProviderServiceNetworkInfo($id);
        }
        $areas = $province_service->getProvinceForSearch();
        $data['provider_id'] = $provider_id;
        $data['areas'] = $areas;
        $data['id'] = $id;
        return $this->view('pages.provider.provider-service-network.edit', $data);
    }


    public function list(Request $request, ProviderServiceNetworkSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $provider_service_network_service = new ProviderServiceNetworkService();
        $data = $provider_service_network_service->getProviderServiceNetworkList(
            $form->provider_service_network_specification, 20
        );
        $appends = $this->getAppends($form->provider_service_network_specification);
        $data['appends'] = $appends;
        $data['provider_service_network_status'] = ProviderServiceNetworkStatus::acceptableEnums();
        return $this->view('pages.provider.provider-service-network.list', $data);
    }


    public function audit(Request $request, $id)
    {
        $data = [];

        $provider_service_network_service = new ProviderServiceNetworkService();
        $province_service = new ProvinceService();

        if (!empty($id)) {
            $data = $provider_service_network_service->getProviderServiceNetworkInfo($id);
        }
        $areas = $province_service->getProvinceForSearch();
        $data['areas'] = $areas;
        $data['id'] = $id;
        return $this->view('pages.provider.provider-service-network.audit', $data);
    }


    public function getAppends(ProviderServiceNetworkSpecification $spec)
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
}

<?php namespace App\Admin\Http\Controllers\Provider;


use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Provider\ProviderPropaganda\ProviderPropagandaSearchForm;
use App\Service\Provider\ProviderPropagandaService;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderPropagandaSpecification;
use App\Src\Provider\Domain\Model\ProviderPropagandaStatus;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use Illuminate\Http\Request;

/**
 * 供应商宣传图片
 * Class ProviderPropagandaController
 * @package App\Admin\Http\Controllers\Provider
 */
class ProviderPropagandaController extends BaseController
{
    public function index(Request $request, ProviderPropagandaSearchForm $form, $provider_id)
    {
        $data = [];
        $request->merge(['provider_id' => $provider_id]);
        $form->validate($request->all());

        $provider_friend_service = new ProviderPropagandaService();
        $data = $provider_friend_service->getProviderPropagandaList($form->provider_propaganda_specification, 20);
        $appends = $this->getAppends($form->provider_propaganda_specification);
        $data['provider_id'] = $provider_id;
        $data['appends'] = $appends;
        return $this->view('pages.provider.provider-propaganda.index', $data);
    }

    public function edit(Request $request, $provider_id, $id)
    {
        $data = [];
        $provider_propaganda_service = new ProviderPropagandaService();
        if (!empty($id)) {
            $data = $provider_propaganda_service->getProviderPropagandaInfo($id);
        }
        $ProviderPropagandaStatus = ProviderPropagandaStatus::acceptableEnums();
        $data['provider_id'] = $provider_id;
        $data['id'] = $id;

        return $this->view('pages.provider.provider-propaganda.edit', $data);
    }

    /**
     * @param ProviderPropagandaSpecification $spec
     * @return array
     */
    public function getAppends(ProviderPropagandaSpecification $spec)
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

    public function list(Request $request, ProviderPropagandaSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());

        $provider_friend_service = new ProviderPropagandaService();
        $data = $provider_friend_service->getProviderPropagandaList($form->provider_propaganda_specification, 20);
        $appends = $this->getAppends($form->provider_propaganda_specification);
        $data['appends'] = $appends;
        $data['provider_propaganda_status'] = ProviderPropagandaStatus::acceptableEnums();
        return $this->view('pages.provider.provider-propaganda.list', $data);
    }

    public function audit(Request $request, $id)
    {
        $data = [];
        $provider_propaganda_service = new ProviderPropagandaService();
        if (!empty($id)) {
            $data = $provider_propaganda_service->getProviderPropagandaInfo($id);
        }
        $data['id'] = $id;

        return $this->view('pages.provider.provider-propaganda.audit', $data);
    }
}

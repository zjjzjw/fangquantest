<?php namespace App\Admin\Http\Controllers\Api\Provider;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Provider\ProviderServiceNetwork\ProviderServiceNetworkDeleteForm;
use App\Admin\Src\Forms\Provider\ProviderServiceNetwork\ProviderServiceNetworkStoreForm;
use app\Src\Provider\Domain\Model\ProviderServiceNetworkEntity;
use App\Src\Provider\Domain\Model\ProviderServiceNetworkStatus;
use App\Src\Provider\Infra\Repository\ProviderServiceNetworkRepository;
use Illuminate\Http\Request;

class ProviderServiceNetworkController extends BaseController
{
    /**
     * 添加供应商服务网点
     * @param Request                         $request
     * @param ProviderServiceNetworkStoreForm $form
     * @param                                 $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, ProviderServiceNetworkStoreForm $form, $id)
    {
        $data = [];
        $request->merge(['status' => ProviderServiceNetworkStatus::STATUS_PASS]);
        $form->validate($request->all());

        $provider_service_network_repository = new ProviderServiceNetworkRepository();
        $provider_service_network_repository->save($form->provider_service_network_entity);

        $data['id'] = $form->provider_service_network_entity->id;

        return response()->json($data, 200);
    }


    /**
     * 更新供应商服务网点
     * @param Request                         $request
     * @param ProviderServiceNetworkStoreForm $form
     * @param                                 $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, ProviderServiceNetworkStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }


    public function delete(Request $request, ProviderServiceNetworkDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $provider_service_network_repository = new ProviderServiceNetworkRepository();
        $provider_service_network_repository->delete($id);

        return response()->json($data, 200);
    }

    public function audit(Request $request, $id)
    {
        $data = [];
        $provider_service_network_repository = new ProviderServiceNetworkRepository();
        /** @var ProviderServiceNetworkEntity $provider_service_network_entity */
        $provider_service_network_entity = $provider_service_network_repository->fetch($id);
        $provider_service_network_entity->status = ProviderServiceNetworkStatus::STATUS_PASS;
        $provider_service_network_repository->save($provider_service_network_entity);
        return response()->json($data, 200);
    }

    public function reject(Request $request, $id)
    {
        $data = [];
        $provider_service_network_repository = new ProviderServiceNetworkRepository();
        /** @var ProviderServiceNetworkEntity $provider_service_network_entity */
        $provider_service_network_entity = $provider_service_network_repository->fetch($id);
        $provider_service_network_entity->status = ProviderServiceNetworkStatus::STATUS_REJECT;
        $provider_service_network_repository->save($provider_service_network_entity);
        return response()->json($data, 200);
    }
}
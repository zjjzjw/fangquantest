<?php namespace App\Admin\Http\Controllers\Api\Provider;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Provider\ProviderPropaganda\ProviderPropagandaDeleteForm;
use App\Admin\Src\Forms\Provider\ProviderPropaganda\ProviderPropagandaStoreForm;
use App\Src\Provider\Domain\Model\ProviderPictureEntity;
use App\Src\Provider\Domain\Model\ProviderPropagandaStatus;
use App\Src\Provider\Infra\Repository\ProviderPropagandaRepository;
use Illuminate\Http\Request;

class ProviderPropagandaController extends BaseController
{
    /**
     * 宣传图片
     * @param Request                        $request
     * @param  ProviderPropagandaStoreForm $form
     * @param                                $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, ProviderPropagandaStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());

        $provider_propaganda_repository = new ProviderPropagandaRepository();
        $provider_propaganda_repository->save($form->provider_propaganda_entity);

        $data['id'] = $form->provider_propaganda_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 宣传图片
     * @param Request                       $request
     * @param ProviderPropagandaStoreForm $form
     * @param                               $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, ProviderPropagandaStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 宣传图片
     * @param Request                       $request
     * @param ProviderPropagandaStoreForm $form
     * @param                               $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, ProviderPropagandaDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $provider_propaganda_repository = new ProviderPropagandaRepository();
        $provider_propaganda_repository->delete($id);

        return response()->json($data, 200);
    }

    public function audit(Request $request, $id)
    {
        $data = [];
        $provider_propaganda_repository = new ProviderPropagandaRepository();
        /** @var ProviderPictureEntity $provider_propaganda_entity */
        $provider_propaganda_entity = $provider_propaganda_repository->fetch($id);
        $provider_propaganda_entity->status = ProviderPropagandaStatus::STATUS_PASS;
        $provider_propaganda_repository->save($provider_propaganda_entity);
        return response()->json($data, 200);
    }

    public function reject(Request $request, $id)
    {
        $data = [];
        $provider_propaganda_repository = new ProviderPropagandaRepository();
        /** @var ProviderPictureEntity $provider_propaganda_entity */
        $provider_propaganda_entity = $provider_propaganda_repository->fetch($id);
        $provider_propaganda_entity->status = ProviderPropagandaStatus::STATUS_REJECT;
        $provider_propaganda_repository->save($provider_propaganda_entity);
        return response()->json($data, 200);
    }
}
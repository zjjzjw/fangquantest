<?php namespace App\Admin\Http\Controllers\Api\Provider;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Provider\ProviderProduct\ProviderProductDeleteForm;
use App\Admin\Src\Forms\Provider\ProviderProduct\ProviderProductStoreForm;
use App\Src\Provider\Domain\Model\ProviderProductEntity;
use App\Src\Provider\Domain\Model\ProviderProductStatus;
use App\Src\Provider\Infra\Repository\ProviderProductRepository;
use Illuminate\Http\Request;


class ProviderProductController extends BaseController
{
    public function store(Request $request, ProviderProductStoreForm $form, $id)
    {
        $data = [];
        $request->merge(['status' => ProviderProductStatus::STATUS_PASS]);
        $form->validate($request->all());

        $provider_product_repository = new ProviderProductRepository();
        $provider_product_repository->save($form->provider_product_entity);

        $data['id'] = $form->provider_product_entity->id;

        return response()->json($data, 200);
    }


    public function update(Request $request, ProviderProductStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }


    public function delete(Request $request, ProviderProductDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $provider_product_repository = new ProviderProductRepository();
        $provider_product_repository->delete($id);

        return response()->json($data, 200);
    }

    public function audit(Request $request, $id)
    {
        $data = [];
        $provider_product_repository = new ProviderProductRepository();
        /** @var ProviderProductEntity $provider_product_entity */
        $provider_product_entity = $provider_product_repository->fetch($id);
        $provider_product_entity->status = ProviderProductStatus::STATUS_PASS;
        $provider_product_repository->save($provider_product_entity);
        return response()->json($data, 200);
    }

    public function reject(Request $request, $id)
    {
        $data = [];
        $provider_product_repository = new ProviderProductRepository();
        /** @var ProviderProductEntity $provider_product_entity */
        $provider_product_entity = $provider_product_repository->fetch($id);
        $provider_product_entity->status = ProviderProductStatus::STATUS_REJECT;
        $provider_product_repository->save($provider_product_entity);
        return response()->json($data, 200);
    }
}
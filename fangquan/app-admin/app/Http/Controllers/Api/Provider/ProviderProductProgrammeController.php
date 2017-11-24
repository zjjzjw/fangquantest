<?php namespace App\Admin\Http\Controllers\Api\Provider;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Provider\ProviderProductProgramme\ProviderProductProgrammeDeleteForm;
use App\Admin\Src\Forms\Provider\ProviderProductProgramme\ProviderProductProgrammeStoreForm;
use App\Src\Provider\Domain\Model\ProviderProductProgrammeEntity;
use App\Src\Provider\Domain\Model\ProviderProductProgrammeStatus;
use App\Src\Provider\Infra\Repository\ProviderProductProgrammeRepository;
use Illuminate\Http\Request;


class ProviderProductProgrammeController extends BaseController
{
    public function store(Request $request, ProviderProductProgrammeStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());

        $provider_product_programme_repository = new ProviderProductProgrammeRepository();
        $provider_product_programme_repository->save($form->provider_product_programme_entity);

        $data['id'] = $form->provider_product_programme_entity->id;

        return response()->json($data, 200);
    }


    public function update(Request $request, ProviderProductProgrammeStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }


    public function delete(Request $request, ProviderProductProgrammeDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $provider_product_programme_repository = new ProviderProductProgrammeRepository();
        $provider_product_programme_repository->delete($id);

        return response()->json($data, 200);
    }

    public function audit(Request $request, $id)
    {
        $data = [];
        $provider_product_programme_repository = new ProviderProductProgrammeRepository();
        /** @var ProviderProductProgrammeEntity $provider_product_programme_entity */
        $provider_product_programme_entity = $provider_product_programme_repository->fetch($id);
        $provider_product_programme_entity->status = ProviderProductProgrammeStatus::STATUS_PASS;
        $provider_product_programme_repository->save($provider_product_programme_entity);
        return response()->json($data, 200);
    }

    public function reject(Request $request, $id)
    {
        $data = [];
        $provider_product_programme_repository = new ProviderProductProgrammeRepository();
        /** @var ProviderProductProgrammeEntity $provider_product_programme_entity */
        $provider_product_programme_entity = $provider_product_programme_repository->fetch($id);
        $provider_product_programme_entity->status = ProviderProductProgrammeStatus::STATUS_REJECT;
        $provider_product_programme_repository->save($provider_product_programme_entity);
        return response()->json($data, 200);
    }
}
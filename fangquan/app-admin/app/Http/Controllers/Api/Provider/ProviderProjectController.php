<?php namespace App\Admin\Http\Controllers\Api\Provider;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Provider\ProviderProject\ProviderProjectDeleteForm;
use App\Admin\Src\Forms\Provider\ProviderProject\ProviderProjectStoreForm;
use App\Src\Provider\Domain\Model\ProviderProjectEntity;
use App\Src\Provider\Infra\Repository\ProviderProjectRepository;
use App\Src\Provider\Domain\Model\ProviderProjectStatus;
use Illuminate\Http\Request;

class ProviderProjectController extends BaseController
{

    public function store(Request $request, ProviderProjectStoreForm $form, $id)
    {
        $data = [];
        $request->merge(['status' => ProviderProjectStatus::STATUS_PASS]);
        $form->validate($request->all());

        $provider_project_repository = new ProviderProjectRepository();
        $provider_project_repository->save($form->provider_project_entity);

        $data['id'] = $form->provider_project_entity->id;

        return response()->json($data, 200);
    }


    public function update(Request $request, ProviderProjectStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }


    public function delete(Request $request, ProviderProjectDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $provider_project_repository = new ProviderProjectRepository();
        $provider_project_repository->delete($id);

        return response()->json($data, 200);
    }

    public function audit(Request $request, $id)
    {
        $data = [];
        $provider_project_repository = new ProviderProjectRepository();
        /** @var ProviderProjectEntity $provider_project_entity */
        $provider_project_entity = $provider_project_repository->fetch($id);
        $provider_project_entity->status = ProviderProjectStatus::STATUS_PASS;
        $provider_project_repository->save($provider_project_entity);
        return response()->json($data, 200);
    }

    public function reject(Request $request, $id)
    {
        $data = [];
        $provider_project_repository = new ProviderProjectRepository();
        /** @var ProviderProjectEntity $provider_project_entity */
        $provider_project_entity = $provider_project_repository->fetch($id);
        $provider_project_entity->status = ProviderProjectStatus::STATUS_REJECT;
        $provider_project_repository->save($provider_project_entity);
        return response()->json($data, 200);
    }
}
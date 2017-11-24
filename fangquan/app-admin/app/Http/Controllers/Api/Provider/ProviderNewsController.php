<?php namespace App\Admin\Http\Controllers\Api\Provider;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Provider\ProviderNews\ProviderNewsDeleteForm;
use App\Admin\Src\Forms\Provider\ProviderNews\ProviderNewsStoreForm;
use App\Src\Provider\Domain\Model\ProviderNewsEntity;
use App\Src\Provider\Infra\Repository\ProviderNewsRepository;
use App\Src\Provider\Domain\Model\ProviderNewsStatus;
use Illuminate\Http\Request;

class ProviderNewsController extends BaseController
{

    public function store(Request $request, ProviderNewsStoreForm $form, $id)
    {
        $data = [];
        $request->merge(['status' => ProviderNewsStatus::STATUS_PASS]);
        $form->validate($request->all());

        $provider_news_repository = new ProviderNewsRepository();
        $provider_news_repository->save($form->provider_news_entity);

        $data['id'] = $form->provider_news_entity->id;

        return response()->json($data, 200);
    }


    public function update(Request $request, ProviderNewsStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }


    public function delete(Request $request, ProviderNewsDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $provider_news_repository = new ProviderNewsRepository();
        $provider_news_repository->delete($id);

        return response()->json($data, 200);
    }

    public function audit(Request $request, $id)
    {
        $data = [];
        $provider_news_repository = new ProviderNewsRepository();
        /** @var ProviderNewsEntity $provider_news_entity */
        $provider_news_entity = $provider_news_repository->fetch($id);
        $provider_news_entity->status = ProviderNewsStatus::STATUS_PASS;
        $provider_news_repository->save($provider_news_entity);
        return response()->json($data, 200);
    }

    public function reject(Request $request, $id)
    {
        $data = [];
        $provider_news_repository = new ProviderNewsRepository();
        /** @var ProviderNewsEntity $provider_news_entity */
        $provider_news_entity = $provider_news_repository->fetch($id);
        $provider_news_entity->status = ProviderNewsStatus::STATUS_REJECT;
        $provider_news_repository->save($provider_news_entity);
        return response()->json($data, 200);
    }
}
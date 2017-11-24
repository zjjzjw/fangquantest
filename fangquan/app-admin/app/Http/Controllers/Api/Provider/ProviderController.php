<?php namespace App\Admin\Http\Controllers\Api\Provider;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Provider\ProviderBrandStoreForm;
use App\Admin\Src\Forms\Provider\ProviderDeleteForm;
use App\Admin\Src\Forms\Provider\ProviderStoreForm;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use Illuminate\Http\Request;

class ProviderController extends BaseController
{

    /**
     * 新增供应商信息
     * @param Request                  $request
     * @param ProviderStoreForm        $form
     * @param                          $id
     */
    public function store(Request $request, ProviderStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $personal_return_repository = new ProviderRepository();
        $personal_return_repository->save($form->provider_entity);

        $data['id'] = $form->provider_entity->id;

        return response()->json($data, 200);

    }


    public function brandStore(Request $request, ProviderBrandStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $personal_return_repository = new ProviderRepository();
        $personal_return_repository->save($form->provider_entity);

        $data['id'] = $form->provider_entity->id;

        return response()->json($data, 200);
    }


    public function brandUpdate(Request $request, ProviderBrandStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $personal_return_repository = new ProviderRepository();
        $personal_return_repository->save($form->provider_entity);

        $data['id'] = $form->provider_entity->id;

        return response()->json($data, 200);

    }

    /**
     * 修改供应商信息
     * @param Request                  $request
     * @param ProviderStoreForm        $form
     * @param                          $id
     */
    public function update(Request $request, ProviderStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除供应商信息
     * @param Request                    $request
     * @param ProviderDeleteForm         $form
     * @param                            $id
     */
    public function delete(Request $request, ProviderDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $personal_return_repository = new ProviderRepository();
        $personal_return_repository->delete($id);

        return response()->json($data, 200);
    }


    public function getProviderByKeyword(Request $request)
    {
        $data = [];
        $keyword = $request->get('keyword', '');
        if ($keyword) {
            $personal_return_repository = new ProviderRepository();
            $personal_models = $personal_return_repository->getProviderByKeyword($keyword);
            foreach ($personal_models as $personal_model) {
                $item = [];
                $item['id'] = $personal_model->id;
                $item['name'] = $personal_model->brand_name;
                $data[] = $item;
            }
        }
        return $data;
    }

}
<?php namespace App\Admin\Http\Controllers\Api\Provider;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Provider\ProviderAduitdetails\ProviderAduitdetailsDeleteForm;
use App\Admin\Src\Forms\Provider\ProviderAduitdetails\ProviderAduitdetailsStoreForm;
use App\Src\Provider\Infra\Repository\ProviderAduitdetailsRepository;
use Illuminate\Http\Request;

class ProviderAduitdetailsController extends BaseController
{
    /**
     * 添加验厂报告
     * @param Request                        $request
     * @param  ProviderAduitdetailsStoreForm $form
     * @param                                $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, ProviderAduitdetailsStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());

        $provider_aduitdetails_repository = new ProviderAduitdetailsRepository();
        $provider_aduitdetails_repository->save($form->provider_aduitdetails_entity);

        $data['id'] = $form->provider_aduitdetails_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 更新验厂报告
     * @param Request                       $request
     * @param ProviderAduitdetailsStoreForm $form
     * @param                               $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, ProviderAduitdetailsStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除验厂报告
     * @param Request                       $request
     * @param ProviderAduitdetailsStoreForm $form
     * @param                               $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, ProviderAduitdetailsDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $provider_aduitdetails_repository = new ProviderAduitdetailsRepository();
        $provider_aduitdetails_repository->delete($id);

        return response()->json($data, 200);
    }

}
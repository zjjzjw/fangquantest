<?php namespace App\Admin\Http\Controllers\Api\Provider;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Provider\ProviderRankCategory\ProviderRankCategoryDeleteForm;
use App\Admin\Src\Forms\Provider\ProviderRankCategory\ProviderRankCategoryStoreForm;
use App\Src\Provider\Infra\Repository\ProviderRankCategoryRepository;
use Illuminate\Http\Request;

class ProviderRankCategoryController extends BaseController
{

    /**
     * 新增供应商排名
     * @param Request                       $request
     * @param ProviderRankCategoryStoreForm $form
     * @param                               $id
     */
    public function store(Request $request, ProviderRankCategoryStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $provider_rank_category_repository = new ProviderRankCategoryRepository();
        $provider_rank_category_repository->save($form->provider_rank_category_entity);

        $data['id'] = $form->provider_rank_category_entity->id;

        return response()->json($data, 200);

    }

    /**
     * 修改供应商排名
     * @param Request                       $request
     * @param ProviderRankCategoryStoreForm $form
     * @param                               $id
     */
    public function update(Request $request, ProviderRankCategoryStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除供应商排名
     * @param Request                        $request
     * @param ProviderRankCategoryDeleteForm $form
     * @param                                $id
     */
    public function delete(Request $request, ProviderRankCategoryDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $personal_return_repository = new ProviderRankCategoryRepository();
        $personal_return_repository->delete($id);

        return response()->json($data, 200);
    }

}
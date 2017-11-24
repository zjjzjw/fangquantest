<?php namespace App\Admin\Http\Controllers\Api\Brand;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Brand\BrandSupplementary\BrandSupplementaryDeleteForm;
use App\Admin\Src\Forms\Brand\BrandSupplementary\BrandSupplementaryStoreForm;
use App\Src\Brand\Infra\Repository\BrandSupplementaryRepository;
use Illuminate\Http\Request;

class BrandSupplementaryController extends BaseController
{
    /**
     * 添加品牌补充资料
     * @param Request                     $request
     * @param BrandSupplementaryStoreForm $form
     * @param                             $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, BrandSupplementaryStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $brand_supplementary_repository = new BrandSupplementaryRepository();
        $brand_supplementary_repository->save($form->brand_supplementary_entity);
        $data['id'] = $form->brand_supplementary_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改品牌补充资料
     * @param Request                     $request
     * @param BrandSupplementaryStoreForm $form
     * @param                             $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, BrandSupplementaryStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除品牌补充资料
     * @param Request                      $request
     * @param BrandSupplementaryDeleteForm $form
     * @param                              $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, BrandSupplementaryDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $brand_supplementary_repository = new BrandSupplementaryRepository();
        $brand_supplementary_repository->delete($id);

        return response()->json($data, 200);
    }
}

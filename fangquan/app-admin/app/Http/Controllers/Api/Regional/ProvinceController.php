<?php namespace App\Admin\Http\Controllers\Api\Regional;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Regional\Province\ProvinceDeleteForm;
use App\Admin\Src\Forms\Regional\Province\ProvinceStoreForm;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use Illuminate\Http\Request;

class ProvinceController extends BaseController
{

    /**
     * 新增省份
     * @param Request            $request
     * @param ProvinceStoreForm  $form
     * @param                    $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, ProvinceStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $province_repository = new ProvinceRepository();
        $province_repository->save($form->province_entity);

        $data['id'] = $form->province_entity->id;

        return response()->json($data, 200);

    }

    /**
     * 修改省份
     * @param Request                  $request
     * @param ProvinceStoreForm        $form
     * @param                          $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, ProvinceStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除省份
     * @param Request                    $request
     * @param ProvinceDeleteForm         $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, ProvinceDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $province_repository = new ProvinceRepository();
        $province_repository->delete($id);

        return response()->json($data, 200);
    }

}
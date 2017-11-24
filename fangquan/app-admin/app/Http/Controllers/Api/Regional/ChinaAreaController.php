<?php namespace App\Admin\Http\Controllers\Api\Regional;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Regional\ChinaArea\ChinaAreaDeleteForm;
use App\Admin\Src\Forms\Regional\ChinaArea\ChinaAreaStoreForm;
use App\Src\Surport\Infra\Repository\ChinaAreaRepository;
use Illuminate\Http\Request;

class ChinaAreaController extends BaseController
{

    /**
     * 新增区域
     * @param Request            $request
     * @param ChinaAreaStoreForm $form
     * @param                    $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, ChinaAreaStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $china_area_repository = new ChinaAreaRepository();
        $china_area_repository->save($form->china_area_entity);

        $data['id'] = $form->china_area_entity->id;

        return response()->json($data, 200);

    }

    /**
     * 修改区域
     * @param Request                  $request
     * @param ChinaAreaStoreForm       $form
     * @param                          $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, ChinaAreaStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除区域
     * @param Request                    $request
     * @param ChinaAreaDeleteForm        $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, ChinaAreaDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $china_area_repository = new ChinaAreaRepository();
        $china_area_repository->delete($id);

        return response()->json($data, 200);
    }

}
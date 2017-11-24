<?php namespace App\Admin\Http\Controllers\Api\Regional;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Regional\City\CityDeleteForm;
use App\Admin\Src\Forms\Regional\City\CityStoreForm;
use App\Src\Surport\Infra\Repository\CityRepository;
use Illuminate\Http\Request;

class CityController extends BaseController
{

    /**
     * 新增城市
     * @param Request            $request
     * @param CityStoreForm      $form
     * @param                    $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, CityStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $city_repository = new CityRepository();
        $city_repository->save($form->city_entity);

        $data['id'] = $form->city_entity->id;

        return response()->json($data, 200);

    }

    /**
     * 修改城市
     * @param Request                  $request
     * @param CityStoreForm            $form
     * @param                          $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, CityStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除城市
     * @param Request                    $request
     * @param CityDeleteForm             $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, CityDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $city_repository = new CityRepository();
        $city_repository->delete($id);

        return response()->json($data, 200);
    }

}
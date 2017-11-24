<?php namespace App\Admin\Http\Controllers\Api\Category;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Category\AttributeDeleteForm;
use App\Admin\Src\Forms\Category\AttributeStoreForm;
use App\Src\Category\Infra\Repository\AttributeRepository;
use Illuminate\Http\Request;

class AttributeController extends BaseController
{
    /**
     * 添加属性
     * @param Request            $request
     * @param AttributeStoreForm  $form
     * @param                    $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, AttributeStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $attribute_repository = new AttributeRepository();
        $attribute_repository->save($form->attribute_entity);
        $data['id'] = $form->attribute_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改属性
     * @param Request                  $request
     * @param AttributeStoreForm        $form
     * @param                          $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, AttributeStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除属性
     * @param Request                    $request
     * @param AttributeDeleteForm         $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, AttributeDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $attribute_repository = new AttributeRepository();
        $attribute_repository->delete($id);
        return response()->json($data, 200);
    }

}

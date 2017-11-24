<?php namespace App\Admin\Http\Controllers\Api\Category;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Category\CategoryDeleteForm;
use App\Admin\Src\Forms\Category\CategoryStoreForm;
use App\Service\Category\CategoryService;
use App\Src\Category\Domain\Model\CategoryEntity;
use App\Src\Category\Infra\Repository\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    /**
     * 添加品类
     * @param Request            $request
     * @param CategoryStoreForm  $form
     * @param                    $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, CategoryStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $category_repository = new CategoryRepository();
        $category_repository->save($form->category_entity);
        $data['id'] = $form->category_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改品类
     * @param Request                  $request
     * @param CategoryStoreForm        $form
     * @param                          $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, CategoryStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除品类
     * @param Request                    $request
     * @param CategoryDeleteForm         $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, CategoryDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $category_repository = new CategoryRepository();
        $category_repository->delete($id);

        return response()->json($data, 200);
    }

    public function attribute(Request $request, $id)
    {
        $data = [];
        $category_service = new CategoryService();
        $data = $category_service->getCategoryAndAttributeInfo($id);
        return response()->json($data, 200);
    }

    public function secondLevel(Request $request, $id)
    {
        $data = [];
        $category_repository = new CategoryRepository();
        $category_entities = $category_repository->getLevelCategorys($id);
        /** @var CategoryEntity $category_entity */
        foreach ($category_entities as $category_entity) {
            $item = $category_entity->toArray();
            $data[] = $item;
        }
        return response()->json($data, 200);
    }
}

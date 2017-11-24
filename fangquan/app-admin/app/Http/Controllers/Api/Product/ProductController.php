<?php namespace App\Admin\Http\Controllers\Api\Product;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Product\ProductDeleteForm;
use App\Admin\Src\Forms\Product\ProductStoreForm;
use App\Src\Product\Domain\Model\ProductEntity;
use App\Src\Product\Infra\Repository\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    /**
     * 添加产品
     * @param Request            $request
     * @param ProductStoreForm   $form
     * @param                    $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, ProductStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $product_repository = new ProductRepository();
        $product_repository->save($form->product_entity);
        $data['id'] = $form->product_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改产品
     * @param Request                  $request
     * @param ProductStoreForm         $form
     * @param                          $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, ProductStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除产品
     * @param Request                    $request
     * @param ProductDeleteForm          $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, ProductDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $product_repository = new ProductRepository();
        $product_repository->delete($id);

        return response()->json($data, 200);
    }

    public function keyword(Request $request)
    {
        $data = [];
        $keyword = $request->get('keyword');
        if ($keyword) {
            $product_repository = new ProductRepository();
            $product_entities = $product_repository->getProductListByProductModel($keyword);
            /** @var ProductEntity $product_entity */
            foreach ($product_entities as $product_entity) {
                $brand = $product_entity->toArray();
                $item['id'] = $brand['id'];
                $item['name'] = $brand['product_model'];
                $data[] = $item;
            }
        }
        return response()->json($data, 200);
    }
}

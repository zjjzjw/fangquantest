<?php namespace App\Admin\Http\Controllers\Api\Product;

use App\Admin\Src\Forms\Product\ProductCategoryStoreForm;
use App\Admin\Http\Controllers\BaseController;
use App\Service\Product\ProductCategoryService;
use App\Src\Product\Infra\Repository\ProductCategoryRepository;
use Illuminate\Http\Request;


class ProductCategoryController extends BaseController
{
    public function store(Request $request, ProductCategoryStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());

        $product_category_repository = new ProductCategoryRepository();
        $product_category_repository->save($form->product_category_entity);

        $data['id'] = $form->product_category_entity->id;
        return response()->json($data, 200);
    }

    public function update(Request $request, ProductCategoryStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

}
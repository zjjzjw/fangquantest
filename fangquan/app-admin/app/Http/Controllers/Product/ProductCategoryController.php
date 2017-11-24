<?php namespace App\Admin\Http\Controllers\Product;


use App\Admin\Src\Forms\Product\ProductCategorySearchForm;
use App\Service\Product\ProductCategoryService;
use App\Admin\Http\Controllers\BaseController;
use App\Src\Product\Domain\Model\ProductCategorySpecification;
use Illuminate\Http\Request;

/**
 * 产品分类
 * Class ProductCategoryController
 * @package App\Admin\Http\Controllers\Product
 */
class ProductCategoryController extends BaseController
{
    public function index(Request $request, ProductCategorySearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $product_category_service = new ProductCategoryService();
        $data['items'] = $product_category_service->getAllProviderCategoryTreeList();
        return $this->view('pages.product.product-category.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $product_category_service = new ProductCategoryService();
            $data = $product_category_service->getProductCategoryInfo($id);
        }
        $data['level'] = $request->get('level');
        $data['parent_id'] = $request->get('parent_id');
        return $this->view('pages.product.product-category.edit', $data);
    }

    public function getAppends(ProductCategorySpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }

        return $appends;
    }

}

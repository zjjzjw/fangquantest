<?php namespace App\Admin\Http\Controllers\Product;

use App\Admin\Src\Forms\Comment\CommentSearchForm;
use App\Admin\Src\Forms\Product\ProductSearchForm;
use App\Service\Brand\BrandService;
use App\Service\Category\CategoryService;
use App\Service\Comment\CommentService;
use App\Service\Product\ProductService;
use App\Src\Brand\Domain\Model\CommentType;
use App\Src\Category\Domain\Model\CategoryEntity;
use App\Src\Category\Infra\Repository\CategoryRepository;
use App\Src\FqUser\Domain\Model\FqUserRoleType;
use App\Src\Product\Domain\Model\ProductGrade;
use App\Src\Product\Domain\Model\ProductSpecification;
use App\Src\Product\Domain\Model\ProductType;
use App\Src\Product\Domain\Model\ProductHotType;
use App\Src\Role\Domain\Model\UserType;
use Illuminate\Http\Request;
use App\Admin\Http\Controllers\BaseController;

class ProductController extends BaseController
{
    public function index(Request $request, ProductSearchForm $form)
    {
        $data = [];
        $product_service = new ProductService();
        $user_entity = $this->getUserEntity();
        if ($user_entity->role_type == FqUserRoleType::PROVIDER) {
            $request->merge(['brand_ids' => [$user_entity->role_id]]);
        }
        $form->validate($request->all());
        $data = $product_service->getProductList($form->product_specification, 20);
        $appends = $this->getAppends($form->product_specification);
        $data['appends'] = $appends;
        $data['product_hot_types'] = ProductHotType::acceptableEnums();
        $category_service = new CategoryService();
        $data['category_lists'] = $category_service->getCategoryLists();
        return $this->view('pages.product.product.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $product_service = new ProductService();
            $data = $product_service->getProductInfo($id);
        }
        $category_service = new CategoryService();
        $data['category_lists'] = $category_service->getCategoryLists();
        $data['product_types'] = ProductType::acceptableEnums();
        $data['product_hot_types'] = ProductHotType::acceptableEnums();
        $data['product_grades'] = ProductGrade::acceptableEnums();
        return $this->view('pages.product.product.edit', $data);
    }

    public function comments(Request $request, $pid, CommentSearchForm $form)
    {
        $data = [];
        $comment_service = new CommentService();
        $request->merge(['type' => CommentType::PRODUCT]);
        if (!empty($pid)) {
            $request->merge(['p_id' => $pid]);
        }
        $form->validate($request->all());
        $data = $comment_service->getCommentList($form->comment_specification, 20);
        return $this->view('pages.product.product.comments', $data);
    }

    public function getAppends(ProductSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        if ($spec->brand_id) {
            $appends['brand_id'] = $spec->brand_id;
        }
        if ($spec->product_category_id) {
            $category_repository = new CategoryRepository();
            /** @var CategoryEntity $category_entity */
            $category_entity = $category_repository->fetch($spec->product_category_id);
            if (isset($category_entity)) {
                $appends['product_category_name'] = $category_entity->name;
            }
            $appends['product_category_id'] = $spec->product_category_id;
        }
        return $appends;
    }
}

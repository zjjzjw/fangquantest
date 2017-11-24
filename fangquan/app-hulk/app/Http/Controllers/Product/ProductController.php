<?php

namespace App\Hulk\Http\Controllers\Product;

use App\Hulk\Http\Controllers\BaseController;
use App\Hulk\Service\Comment\CommentHulkService;
use App\Hulk\Service\Information\InformationHulkService;
use App\Hulk\Service\Product\ProductHulkService;
use App\Hulk\Service\Theme\ThemeHulkService;
use App\Hulk\Src\Forms\Product\ProductSearchForm;
use App\Src\Brand\Domain\Model\CommentType;
use App\Src\Product\Domain\Model\ProductHotType;
use App\Src\Product\Domain\Model\ProductSpecification;
use App\Src\Theme\Domain\Model\ThemeType;
use Illuminate\Http\Request;

class ProductController extends BaseController
{

    public function index(Request $request, ProductSearchForm $form)
    {
        $product_hulk_service = new ProductHulkService();
        $form->validate($request->all());
        $data = $product_hulk_service->getProductList($form->product_specification, 20);
        $theme_hulk_service = new ThemeHulkService();
        $data['theme_list'] = $theme_hulk_service->getInformationTopThemes(ThemeType::PRODUCT);
        $appends = $this->getAppends($form->product_specification);
        $data['appends'] = $appends;
        return response()->json($data, 200);
    }

    public function theme()
    {
        $data = [];
        $theme_hulk_service = new ThemeHulkService();
        $data = $theme_hulk_service->getInformationTopThemes(ThemeType::PRODUCT, 20);
        return response()->json($data, 200);
    }

    public function detail(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $product_hulk_service = new ProductHulkService();
            $information_hulk_service = new InformationHulkService();
            $data = $product_hulk_service->getProductInfo($id);
            $data['category_information_list'] = $information_hulk_service->getInformationListByCategoryId($data['product_category_id'], 10);
            $data['product_information_list'] = $information_hulk_service->getInformationListByProductId($id, $data['product_category_id'], 10);
        }
        return response()->json($data, 200);
    }

    public function comment(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $comment_hulk_service = new CommentHulkService();
            $data = $comment_hulk_service->getCommentListByPidAndType($id, CommentType::PRODUCT);
        }
        return response()->json($data, 200);
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
            $appends['product_category_id'] = $spec->product_category_id;
        }
        if ($spec->company_type) {
            $appends['company_type'] = $spec->company_type;
        }
        if ($spec->product_type) {
            $appends['product_type'] = $spec->product_type;
        }
        if ($spec->attributes) {
            $appends['attributes'] = $spec->attributes;
        }
        return $appends;
    }
}



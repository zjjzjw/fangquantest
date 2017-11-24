<?php

namespace App\Hulk\Http\Controllers\Brand;

use App\Hulk\Http\Controllers\BaseController;
use App\Hulk\Service\Brand\BrandHulkService;
use App\Hulk\Service\Comment\CommentHulkService;
use App\Hulk\Service\Information\InformationHulkService;
use App\Hulk\Service\Product\ProductHulkService;
use App\Hulk\Src\Forms\Brand\BrandProductSearchForm;
use App\Hulk\Src\Forms\Brand\BrandSearchForm;
use App\Src\Brand\Domain\Model\CommentType;
use App\Src\Product\Domain\Model\ProductSpecification;
use Illuminate\Http\Request;

class BrandController extends BaseController
{

    public function index(Request $request, BrandSearchForm $form){
        $data = [];
        $brand_service = new BrandHulkService();
        $form->validate($request->all());
        $data = $brand_service->getBrandList($form->brand_specification, 20);
        return response()->json($data, 200);
    }

    public function detail(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $brand_api_service = new BrandHulkService();
            $information_api_service = new InformationHulkService();

            $data = $brand_api_service->getBrandInfo($id);
            $data['brand_information'] = $information_api_service->getInformationListByBrandId($id);
        }
        return response()->json($data, 200);
    }

    public function product(Request $request, $id, BrandProductSearchForm $form)
    {
        $product_service = new ProductHulkService();
        $request->merge(['brand_id' => $id]);
        $form->validate($request->all());
        $data = $product_service->getProductList($form->product_specification, 20);

        $appends = $this->getAppends($form->product_specification);
        $data['appends'] = $appends;
        $data['brand_category'] = $product_service->getBrandCategorys($id);
        return response()->json($data, 200);
    }

    public function comment(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $comment_api_service = new CommentHulkService();
            $data = $comment_api_service->getCommentListByPidAndType($id, CommentType::BRAND);
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
        return $appends;
    }
}



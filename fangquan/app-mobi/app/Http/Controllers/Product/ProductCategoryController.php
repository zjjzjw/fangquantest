<?php

namespace App\Mobi\Http\Controllers\Product;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Product\ProductCategoryMobiService;
use App\Src\Product\Domain\Model\ProductCategoryStatus;
use Illuminate\Http\Request;

class ProductCategoryController extends BaseController
{
    /**
     * 获取某一分类下面的分类列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function productCategory(Request $request)
    {
        $data = [];
        $category_id = $request->get('category_id', 0);
        $product_category_mobi_service = new ProductCategoryMobiService();
        $product_categories = $product_category_mobi_service->getProductCategoryByParentId(
            $category_id, ProductCategoryStatus::STATUS_ONLINE);

        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $product_categories;
        return response()->json($data, 200);
    }


    /**
     * 获取首页6个分类
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function productCategoryTop5(Request $request)
    {
        $data = [];
        $product_category_list = [
            [
                'id'   => 3,
                'icon' => 'http://img-dev.fq960.com/product_category/top6/weiyu.png',
                'name' => '卫浴',
            ],
            [
                'id'   => 4,
                'icon' => 'http://img-dev.fq960.com/product_category/top6/chuju.png',
                'name' => '橱柜',
            ],
            [
                'id'   => 5,
                'icon' => 'http://img-dev.fq960.com/product_category/top6/chufang.png',
                'name' => '厨房电器',
            ],
            [
                'id'   => 6,
                'icon' => 'http://img-dev.fq960.com/product_category/top6/rumeng.png',
                'name' => '入户门',
            ],
            [
                'id'   => 7,
                'icon' => 'http://img-dev.fq960.com/product_category/top6/peidian.png',
                'name' => '配电箱',
            ],
            [
                'id'   => 8,
                'icon' => 'http://img-dev.fq960.com/product_category/top6/weiyu.png',
                'name' => '木地板',
            ],
        ];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $product_category_list;
        return response()->json($data, 200);
    }

    /**
     * 获取一级、二级分类列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function productCategoryList()
    {
        $data = [];
        $product_category_mobi_service = new ProductCategoryMobiService();
        $product_category_list = $product_category_mobi_service->getProductCategoryList();

        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $product_category_list;
        return response()->json($data, 200);
    }


    /**
     * 获取主营的26分类
     * @return \Illuminate\Http\JsonResponse
     */
    public function productSecondCategoryList()
    {
        $data = [];
        $product_category_mobi_service = new ProductCategoryMobiService();
        $product_category_list = $product_category_mobi_service->getCategoryList($icon = true);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $product_category_list;
        return response()->json($data, 200);
    }


}



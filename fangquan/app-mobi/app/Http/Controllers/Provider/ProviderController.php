<?php

namespace App\Mobi\Http\Controllers\Provider;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Provider\ProviderMobiService;
use App\Mobi\Service\Provider\ProviderProductMobiService;
use App\Mobi\Src\Forms\Provider\ProviderSearchForm;
use App\Src\Provider\Domain\Model\OperationModelType;
use App\Src\Provider\Infra\Eloquent\ProviderModel;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Http\Request;

class ProviderController extends BaseController
{
    /**
     * 供应商列表
     * @param Request            $request
     * @param ProviderSearchForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, ProviderSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $provider_mobi_service = new ProviderMobiService();
        $result = $provider_mobi_service->getProviderList($form->provider_specification, 20);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $result;
        return response()->json($data, 200);
    }

    /**
     * 供应商详情
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(Request $request, $id)
    {
        $data = [];
        $provider_mobi_service = new ProviderMobiService();
        $provider = $provider_mobi_service->getProviderById($id);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $provider;

        return response()->json($data, 200);
    }

    /**
     * 供应商公司详情
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function companyInfo(Request $request, $id)
    {
        $data = [];
        $provider_mobi_service = new ProviderMobiService();
        $provider = $provider_mobi_service->getCompanyInfo($id);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $provider;
        return response()->json($data, 200);
    }

    /**
     * 得到供应商联系方式
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function providerContact(Request $request, $id)
    {
        $data = [];
        $provider_mobi_service = new ProviderMobiService();
        $provider_contact = $provider_mobi_service->getProviderContact($id);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $provider_contact;
        return response()->json($data, 200);
    }

    /**
     * 获取某一供应商下的产品分类
     * @param Request $request
     * @param         $id
     */
    public function providerCategory(Request $request, $id)
    {
        $data = [];
        $provider_mobi_service = new ProviderMobiService();
        $provider_main_categories = $provider_mobi_service->getProductCategoryByProviderId($id);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $provider_main_categories;

        return response()->json($data, 200);
    }


    public function categoryProvider(Request $request, ProviderSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $provider_mobi_service = new ProviderMobiService();
        $providers = $provider_mobi_service->getProviderByProductCategoryId($form->provider_specification, 10);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $providers;
        return response()->json($data, 200);
    }


    /**
     * 得到二级分类下面的供应商产品
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function categoryProduct(Request $request)
    {
        $data = [];
        $product_category_id = $request->get('product_category_id');
        $provider_product_mobi_service = new ProviderProductMobiService();
        $provider_products = $provider_product_mobi_service->getProductBySecondCategoryId($product_category_id);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $provider_products;

        return response()->json($data, 200);

    }

    /**
     * 供应商品牌排行
     * @param Request $request
     */
    public function providerBrandRank(Request $request)
    {
        $data = [];
        $category_id = $request->get('category_id');
        $provider_mobi_service = new ProviderMobiService();
        $providers = $provider_mobi_service->getProviderBrandRank($category_id, 10);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $providers;

        return response()->json($data, 200);
    }

    /**
     * 供应商对比
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function contrast(Request $request)
    {
        $data = [];
        $provider_ids = $request->get('provider_id');
        $provider_mobi_service = new ProviderMobiService();
        $providers = $provider_mobi_service->getProviderByIds($provider_ids);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $providers;

        return response()->json($data, 200);
    }
}



<?php

namespace App\Web\Http\Controllers\Provider;

use App\Service\Provider\ProviderProductProgrammeService;
use App\Src\Provider\Domain\Model\ProviderProductProgrammeStatus;
use App\Src\Provider\Domain\Model\ProviderProductSpecification;
use App\Web\Service\Provider\ProviderCommonWebService;
use App\Web\Src\Forms\Provider\ProviderProductProgrammeSearchForm;
use App\Web\Src\Forms\Provider\ProviderProductSearchForm;
use App\Service\Provider\ProviderProductService;
use App\Service\Product\ProductCategoryService;
use App\Web\Http\Controllers\BaseController;
use Illuminate\Http\Request;


/**
 * 供应商产品方案
 * Class ProviderProductController
 * @package App\Web\Http\Controllers\Provider
 */
class ProviderProductSchemeController extends BaseController
{
    /**
     * 产品列表
     * @param Request                   $request
     * @param ProviderProductSearchForm $form
     * @param                           $provider_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productList(Request $request, ProviderProductSearchForm $form, $provider_id)
    {
        $data = [];
        $search_categories = [];
        $request->merge(['provider_id' => $provider_id]);
        $form->validate($request->all());

        $provider_product_service = new ProviderProductService();
        $product_category_service = new ProductCategoryService();

        $category_ids = $provider_product_service->getProviderMainCategory($provider_id) ?? [];
        $product_categories = $product_category_service->getProductCategoryByCategoryIds($category_ids);
        $search_categories[0] = '全部';
        foreach ($product_categories as $provider_main_category) {
            $search_categories[$provider_main_category['id']] = $provider_main_category['name'];
        }

        $data = $provider_product_service->getProviderProductList($form->provider_product_specification, 8);
        $data['provider_id'] = $provider_id;
        $data['product_categories'] = $product_categories;
        $data['categories_for_search'] = $search_categories;
        $data['appends'] = $this->getAppends($form->provider_product_specification);
        $data['common_data'] = $this->getCommonData($provider_id);

        return $this->view('pages.provider.product-scheme.product-list', $data);
    }

    /**
     * 产品详情
     * @param Request $request
     * @param         $provider_id
     * @param         $provider_product_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productDetail(Request $request, $provider_id, $provider_product_id)
    {
        $data = [];
        $provider_product_service = new ProviderProductService();
        $data = $provider_product_service->getProviderProductInfo($provider_product_id);
        $data['attrib_array'] = json_decode($data['attrib'], true);
        $data['provider_id'] = $provider_id;
        $data['common_data'] = $this->getCommonData($provider_id);

        return $this->view('pages.provider.product-scheme.product-detail', $data);
    }

    /**
     * 方案列表
     * @param Request                            $request
     * @param ProviderProductProgrammeSearchForm $form
     * @param                                    $provider_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function schemeList(Request $request, ProviderProductProgrammeSearchForm $form, $provider_id)
    {
        $data = [];
        $request->merge(['provider_id' => $provider_id]);
        $request->merge(['status' => ProviderProductProgrammeStatus::STATUS_PASS]);
        $form->validate($request->all());

        $provider_product_programme_service = new ProviderProductProgrammeService();
        $data = $provider_product_programme_service->getProviderProductProgrammeList($form->provider_product_programme_specification, 20);
        $data['provider_id'] = $provider_id;
        $data['common_data'] = $this->getCommonData($provider_id);

        return $this->view('pages.provider.product-scheme.scheme-list', $data);
    }

    /**
     * 方案详情
     * @param Request $request
     * @param         $provider_id
     * @param         $provider_scheme_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function schemeDetail(Request $request, $provider_id, $provider_scheme_id)
    {
        $data = [];
        $provider_scheme_service = new ProviderProductProgrammeService();
        $data = $provider_scheme_service->getProviderProductProgrammeInfo($provider_scheme_id);

        /** 轮播图待完善.. */
        $data['image_url'] = current($data['programme_images'])['url'];
        $data['provider_id'] = $provider_id;
        $data['common_data'] = $this->getCommonData($provider_id);

        return $this->view('pages.provider.product-scheme.scheme-detail', $data);
    }

    public function getAppends(ProviderProductSpecification $spec)
    {
        $appends = [];
        if ($spec->second_product_category_id) {
            $appends['second_product_category_id'] = $spec->second_product_category_id;
        }
        if ($spec->provider_id) {
            $appends['provider_id'] = $spec->provider_id;
        }

        return $appends;
    }


    public function getCommonData($provider_id)
    {
        $provider_common_service = new ProviderCommonWebService();
        $common_data = $provider_common_service->getProviderCommonByProviderId($provider_id);
        return $common_data;
    }
}

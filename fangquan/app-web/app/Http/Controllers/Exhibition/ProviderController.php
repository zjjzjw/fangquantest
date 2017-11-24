<?php

namespace App\Web\Http\Controllers\Exhibition;

use App\Service\Brand\BrandCertificateService;
use App\Service\Product\ProductService;
use App\Service\Provider\ProviderService;
use App\Src\Brand\Infra\Repository\BrandCertificateRepository;
use App\Src\Product\Domain\Model\ProductSpecification;
use App\Src\Provider\Domain\Model\ProviderMainCategoryEntity;
use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Src\Provider\Domain\Model\ProviderStatus;
use App\Src\Provider\Infra\Repository\ProviderMainCategoryRepository;
use App\Web\Http\Controllers\BaseController;
use App\Web\Service\Provider\ProviderWebService;
use App\Web\Src\Forms\Product\ProductSearchForm;
use App\Web\Src\Forms\Provider\ProviderSearchForm;
use App\Web\Src\Forms\Provider\ProviderSignListSearchForm;
use App\Service\Category\CategoryService;
use App\Src\Category\Domain\Model\CategoryEntity;
use App\Src\Category\Infra\Repository\CategoryRepository;
use App\Service\Brand\BrandSaleService;
use App\Service\Brand\BrandSignListService;
use App\Service\Brand\BrandService;
use App\Service\Brand\BrandServiceService;
use App\Src\Brand\Domain\Model\ServiceType;
use App\Src\Brand\Domain\Model\BrandSignListSpecification;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use Illuminate\Http\Request;

class ProviderController extends BaseController
{
    /**
     * 展会供应商列表
     * @param Request            $request
     * @param ProviderSearchForm $form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function providerList(Request $request, ProviderSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $provider_service = new ProviderService();
        /** @var CategoryEntity $category_entity */
        $data = $provider_service->getExProviderList($form->provider_specification, 20);
        $data['appends'] = $this->getProviderAppends($form->provider_specification);
        return $this->view('pages.exhibition.provider-list', $data);
    }

    /**
     * 一级分类
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newProviderList(Request $request)
    {
        $data = [];
        $category_service = new CategoryService();
        $data['categories'] = $category_service->getCategoriesByParentId(0);

        return $this->view('pages.exhibition.new-provider-list', $data);
    }

    /**
     * 二级分类
     * @param Request $request
     */
    public function secondLevel(Request $request)
    {
        $data = [];
        $parent_id = $request->get('parent_id');
        $second_level = $request->get('second_level');
        $category_service = new CategoryService();
        $second_categories = $category_service->getCategoriesByParentId($parent_id);
        if (empty($second_categories)) {
            $category_repository = new CategoryRepository();
            $category_entity = $category_repository->fetch($parent_id);
            $second_categories[] = $category_entity->toArray();
        }
        if (!$second_level) {
            $second_category = current($second_categories);
            $second_level = $second_category['id'] ?? 0;
        }
        $data['second_categories'] = $second_categories;
        $provider_main_category_repository = new ProviderMainCategoryRepository();
        $main_category_entities = $provider_main_category_repository->getProviderMainCategoryByProductCategoryId($second_level);

        $provider_ids = [];
        /** @var ProviderMainCategoryEntity $main_category_entity */
        foreach ($main_category_entities as $main_category_entity) {
            $provider_ids[] = $main_category_entity->provider_id;
        }
        $providers = [];
        if (!empty($provider_ids)) {
            $provider_service = new ProviderService();
            $providers = $provider_service->getProvidersByIds($provider_ids, [ProviderStatus::YES_CERTIFIED]);
        }
        $data['providers'] = $providers;
        $data['parent_id'] = $parent_id;
        $data['second_level'] = $second_level;
        return $this->view('pages.exhibition.second-level-list', $data);
    }


    /**
     * 展会供应商详情
     * @param Request            $request
     * @param ProviderSearchForm $form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function providerDetail(Request $request, $id)
    {
        $data = [];
        //基本信息
        $provider_web_service = new ProviderWebService();
        $provider = $provider_web_service->getProviderDetailById($id);
        $data['provider'] = $provider;

        //联系方式
        $brand_sale_service = new BrandSaleService();
        $data['brand_sales'] = $brand_sale_service->getBrandSalesByBrandId($id);

        //获取证书
        $brand_certificate_service = new BrandCertificateService();

        $certificate_images = $brand_certificate_service->getBrandCertificateImagesByBrandId($id);

        $data['certificate_images'] = $certificate_images;

        return $this->view('pages.exhibition.provider.enterprise-info', $data);
    }


    /**
     * 工程案例
     * @param Request                    $request
     * @param ProviderSignListSearchForm $form
     * @param                            $provider_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cases(Request $request, ProviderSignListSearchForm $form, $provider_id)
    {
        $data = [];

        $request->merge(['brand_id' => $provider_id]);
        $form->validate($request->all());

        //基本信息
        $provider_web_service = new ProviderWebService();
        $data['provider'] = $provider_web_service->getProviderDetailById($provider_id);

        //联系方式
        $brand_sale_service = new BrandSaleService();
        $data['brand_sales'] = $brand_sale_service->getBrandSalesByBrandId($provider_id);

        //项目清单
        $brand_sign_list_service = new BrandSignListService();
        $data['provider_sign_list'] = $brand_sign_list_service->getBrandSignListList($form->brand_sign_list_specification, 6);

        $appends = $this->getProviderSignAppends($form->brand_sign_list_specification);
        $data['appends'] = $appends;
        $data['provider_id'] = $provider_id;

        return $this->view('pages.exhibition.provider.engineer-case', $data);
    }

    /**
     * 产品展示
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function display(Request $request, ProductSearchForm $form, $provider_id)
    {
        $data = [];

        $request->merge(['brand_id' => $provider_id]);
        $form->validate($request->all());

        //基本信息
        $provider_web_service = new ProviderWebService();
        $data['provider'] = $provider_web_service->getProviderDetailById($provider_id);

        //联系方式
        $brand_sale_service = new BrandSaleService();
        $data['brand_sales'] = $brand_sale_service->getBrandSalesByBrandId($provider_id);

        //得到分类
        $category_ids = [];
        $provider_main_category_repository = new ProviderMainCategoryRepository();
        $provider_main_category_entities = $provider_main_category_repository->getProviderMainCategoriesByProviderId($provider_id);
        /** @var ProviderMainCategoryEntity $provider_main_category_entity */
        foreach ($provider_main_category_entities as $provider_main_category_entity) {
            $category_ids[] = $provider_main_category_entity->product_category_id;
        }


        $category_service = new CategoryService();
        $categories = $category_service->getCategoriesByIds($category_ids);
        $data['categories'] = $categories;


        $product_service = new ProductService();
        $products = $product_service->getProductList($form->product_specification, 9);
        $data['products'] = $products;

        $appends = $this->getProviderProductAppends($form->product_specification);
        $data['appends'] = $appends;
        $data['provider_id'] = $provider_id;

        return $this->view('pages.exhibition.provider.product-display', $data);
    }


    /**
     * @param ProductSpecification $spec
     * @return array
     */
    public function getProviderProductAppends(ProductSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        if ($spec->product_category_id) {
            $appends['product_category_id'] = $spec->product_category_id;
        }
        return $appends;
    }

    public function getProviderSignAppends(BrandSignListSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        if ($spec->brand_id) {
            $appends['brand_id'] = $spec->brand_id;
        }
        return $appends;
    }


    //服务网点
    public function serviceNetwork(Request $request, $provider_id)
    {
        $data = [];
        //基本信息
        $provider_web_service = new ProviderWebService();
        $data['provider'] = $provider_web_service->getProviderDetailById($provider_id);

        //联系方式
        $brand_sale_service = new BrandSaleService();
        $data['brand_sales'] = $brand_sale_service->getBrandSalesByBrandId($provider_id);

        $brand_service_service = new BrandServiceService();
        $data['brand_service'] = $brand_service_service->getBrandServiceInfo($provider_id);


        return $this->view('pages.exhibition.provider.service-network', $data);
    }


    public function getProviderAppends(ProviderSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        if ($spec->product_category_id) {
            $appends['product_category_id'] = $spec->product_category_id;
        }
        if ($spec->user_id) {
            $appends['keyword'] = $spec->user_id;
        }
        if ($spec->status) {
            $appends['status'] = $spec->status;
        }
        return $appends;
    }


}
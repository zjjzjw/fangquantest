<?php

namespace App\Web\Http\Controllers\Provider;

use App\Service\Product\ProductCategoryService;
use App\Service\Provider\ProviderService;
use App\Src\Product\Domain\Model\ProductCategoryStatus;
use App\Src\Product\Domain\Model\ProductCategoryType;
use App\Src\Provider\Domain\Model\ProviderStatus;
use App\Web\Service\Provider\ProviderWebService;
use App\Web\Src\Forms\Provider\ProviderRankCategory\ProviderRankCategorySearchForm;
use App\Service\Advertisement\AdvertisementService;
use App\Src\Advertisement\Domain\Model\AdvertisementType;
use App\Src\Provider\Domain\Model\ProviderRankCategorySpecification;
use App\Service\Provider\ProviderRankCategoryService;
use App\Web\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class ProviderListController extends BaseController
{
    /**
     * @param Request                        $request
     * @param ProviderRankCategorySearchForm $form
     * @return $this
     */
    public function index(Request $request, ProviderRankCategorySearchForm $form)
    {
        $data = [];
        $form->validate($request->all());

        $product_category_service = new ProductCategoryService();
        $product_categories = $product_category_service->getProductCategoryByParentId(
            ProductCategoryType::FURNISHINGS, ProductCategoryStatus::STATUS_ONLINE
        );

        $data['product_category_info'] = $product_category_service->getProductCategoryInfo(
            $form->provider_rank_category_specification->category_id
        );
        $data['product_categories'] = $product_categories;
        $data['appends'] = $this->getAppends($form->provider_rank_category_specification);

        $provider_web_service = new ProviderWebService();
        $providers = $provider_web_service->getWebFormatProviders(
            $form->provider_rank_category_specification->category_id,
            20
        );
        $data['providers'] = $providers;
        $provider_service = new ProviderService();
        //广告最多显示7个
        $ad_providers = $provider_service->getAdProviderList(ProviderStatus::YES_CERTIFIED, 7);
        $data['ad_providers'] = $ad_providers;

        \Cookie::unqueue('c_category_id');
        $cookie = \Cookie::make('c_category_id', $form->provider_rank_category_specification->category_id, 6 * 24 * 60);
        \Cookie::queue($cookie);

        return $this->view('pages.provider.list', $data);


    }

    public function getAppends(ProviderRankCategorySpecification $spec)
    {
        $appends = [];
        //默认值为2
        $appends['category_id'] = $spec->category_id ? (string)$spec->category_id : 2;
        return $appends;
    }


}

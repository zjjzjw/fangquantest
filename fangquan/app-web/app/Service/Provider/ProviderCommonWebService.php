<?php

namespace App\Web\Service\Provider;

use App\Src\Provider\Infra\Repository\ProviderRankCategoryRepository;
use App\Src\Provider\Infra\Repository\ProviderFavoriteRepository;
use App\Src\Provider\Infra\Repository\ProviderProductRepository;
use App\Src\Provider\Domain\Model\ProviderRankCategoryEntity;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use App\Service\Provider\ProviderAduitdetailsService;
use App\Src\Surport\Infra\Repository\CityRepository;
use App\Service\Product\ProductCategoryService;
use App\Service\Provider\ProviderNewsService;
use App\Service\Provider\ProviderService;
use Auth;
use Carbon\Carbon;

/**
 * 供应商共用信息
 * Class ProviderCommonWebService
 * @package App\Web\Service\Provider
 */
class ProviderCommonWebService
{
    /**
     * @param $provider_id
     * @return array
     */
    public function getProviderCommonByProviderId($provider_id)
    {
        $data = [];
        $rank_category_data = [];
        $provider_rank_category_repository = new ProviderRankCategoryRepository();
        $provider_aduitdetails_service = new ProviderAduitdetailsService();
        $provider_product_repository = new ProviderProductRepository();
        $product_category_service = new ProductCategoryService();
        $provider_news_service = new ProviderNewsService();
        $province_repository = new ProvinceRepository();
        $provider_service = new ProviderService();
        $city_repository = new CityRepository();

        if ($provider_info = $provider_service->getProviderInfo($provider_id)) {
            $logo_url = current($provider_info['logo_images'])['url'] ?? '';
            $brand_name = $provider_info['brand_name'] ?? '';
            $company_name = $provider_info['company_name'] ?? '';
            // 主营品类
            $category_category_ids = $provider_product_repository->getProviderMainCategoryIds($provider_id);
            $product_categories = $product_category_service->getProductCategoryByCategoryIds($category_category_ids);
            /** @var ProvinceEntity $province_entity */
            $province_entity = $province_repository->fetch($provider_info['province_id']);
            $province = [];
            if (isset($province_entity)) {
                $province = $province_entity->toArray();
            }
            /** @var CityEntity $city_entity */
            $city_entity = $city_repository->fetch($provider_info['city_id']);
            $city = [];
            if (isset($city_entity)) {
                $city = $city_entity->toArray();
            }
            // 分类排名
            $provider_rank_categories = $provider_rank_category_repository->getProviderRankCategoryByProviderId($provider_id);
            /** @var ProviderRankCategoryEntity $provider_rank_category */
            foreach ($provider_rank_categories as $key => $provider_rank_category) {
                $rank_category_data[] = $provider_rank_category->toArray();
                $product_category_info = $product_category_service->getProductCategoryInfo($provider_rank_category->category_id);
                $rank_category_data[$key]['category_name'] = $product_category_info['name'] ?? '';
            }

            $provider_aduitdetails = $provider_aduitdetails_service->getProviderAduitdetailsByProviderId($provider_id);
            $provider_news = $provider_news_service->getProviderNewsByProviderId($provider_id, null, 3);

            $data['logo_url'] = $logo_url;
            $data['brand_name'] = $brand_name;
            $data['company_name'] = $company_name;
            $data['rank_category'] = $rank_category_data;
            $data['product_categories'] = $product_categories;
            $data['province'] = $province;
            $data['city'] = $city;
            $data['aduitdetails'] = $provider_aduitdetails;
            $data['news'] = $provider_news;

            //综合实力
            $data['fraction'] = [
                $provider_info['score_scale'] ?? 0,
                $provider_info['score_qualification'] ?? 0,
                $provider_info['score_credit'] ?? 0,
                $provider_info['score_service'] ?? 0,
                $provider_info['score_innovation'] ?? 0,
            ];
        }

        $data['has_collected'] = false; // 显示收藏按钮(未收藏)
        if (!empty($user_id = Auth::id())) {
            $provider_favorite_repository = new ProviderFavoriteRepository();
            $provider_favorite_entities = $provider_favorite_repository->getProviderFavoriteByUserIdAndProviderId(
                $user_id, $provider_id
            )->toArray();
            if (!empty($provider_favorite_entities)) {
                $data['has_collected'] = true;
            }
        }

        $contact = [];
        $contact['contact'] = $provider_info['contact'] ?? '';
        $contact['telphone'] = $provider_info['telphone'] ?? '';
        $contact['fax'] = $provider_info['fax'] ?? '';
        $contact['service_telphone'] = $provider_info['service_telphone'] ?? '';
        $data['has_contact'] = false; // 点击查看联系人(false=没有联系人)

        foreach ($contact as $value) {
            if (!empty($value)) {
                $data['has_contact'] = true;
            }
        }

        return $data;
    }

}
<?php

namespace App\Hulk\Service\Brand;


use App\Src\Brand\Domain\Model\BrandCompanyType;
use App\Src\Brand\Domain\Model\BrandEntity;
use App\Src\Brand\Domain\Model\BrandManagementType;
use App\Src\Brand\Domain\Model\BrandSpecification;
use App\Src\Brand\Domain\Model\BrandType;
use App\Src\Brand\Infra\Repository\BrandRepository;
use App\Src\Category\Domain\Model\CategoryEntity;
use App\Src\Category\Infra\Repository\CategoryRepository;
use App\Src\Product\Infra\Repository\ProductRepository;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderImageType;
use App\Src\Provider\Domain\Model\ProviderPictureEntity;
use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Src\Provider\Infra\Repository\ProviderMainCategoryRepository;
use App\Src\Provider\Infra\Repository\ProviderPictureRepository;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\CityRepository;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class BrandHulkService
{

    /**
     * @param ProviderSpecification $spec
     * @param int                   $per_page
     * @return array
     */
    public function getBrandList(ProviderSpecification $spec, $per_page)
    {
        $data = [];
        $brand_repository = new ProviderRepository();
        $resource_repository = new ResourceRepository();
        $city_repository = new CityRepository();
        $category_repository = new CategoryRepository();
        $product_repository = new ProductRepository();
        $brand_company_type = BrandCompanyType::acceptableEnums();
        $paginate = $brand_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var int                  $key
         * @var ProviderEntity       $brand_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $brand_entity) {
            $item['id'] = $brand_entity->id;
            $item['brand_name'] = $brand_entity->brand_name;
            $item['company_name'] = $brand_entity->company_name;

            $brand_product_count = $product_repository->getProductCountByBrandId($brand_entity->id);
            $item['avg_price'] = 0;
            if ($brand_product_count > 10) {
                $brand_product_avg = $product_repository->getProductAvgPriceByBrandId($brand_entity->id);
                $item['avg_price'] = round($brand_product_avg, 2);
            }
            //得到缩略图
            //获取图片信息
            $provider_picture_repository = new ProviderPictureRepository();
            $resource_repository = new ResourceRepository();
            $provider_picture_entities = $provider_picture_repository->getImageByProviderId($brand_entity->id);

            $image_ids = [];
            /** @var ProviderPictureEntity $provider_picture_entity */
            foreach ($provider_picture_entities as $provider_picture_entity) {
                $image_ids[] = $provider_picture_entity->image_id;
            }
            $resource_entities = $resource_repository->getResourceUrlByIds($image_ids);
            /** @var ResourceEntity $resource_entity */
            $images = [];
            foreach ($provider_picture_entities as $provider_picture_entity) {
                $image = $provider_picture_entity->toArray();
                foreach ($resource_entities as $resource_entity) {
                    if ($provider_picture_entity->image_id == $resource_entity->id) {
                        $image['id'] = $provider_picture_entity->image_id;
                        $image['url'] = $resource_entity->url;
                    }
                }
                $images[] = $image;
            }
            $item['logo_url'] = '';
            $logo_url = collect($images)->where('type', ProviderImageType::LOGO)->toArray();
            if (!empty($logo_url)) {
                $item['logo_url'] = $logo_url[0]['url'];
            }
            $item['company_type_name'] = $brand_company_type[$brand_entity->company_type] ?? '未知';
            /** @var CityEntity $city_entity */
            $city_entity = $city_repository->fetch($brand_entity->city_id);
            $item['city_name'] = $city_entity->name ?? '';
            $item['brand_category'] = [];
            foreach (($brand_entity->provider_main_category ?? []) as $value) {
                /** @var CategoryEntity $category_entity */
                $category_entity = $category_repository->fetch($value);
                $item['brand_category'][] = $category_entity->name;
            }
            //得到选中二级分类
            $provider_main_category_repository = new ProviderMainCategoryRepository();
            $provider_main_category_models = $provider_main_category_repository->getProviderMainCategoriesByProviderId($brand_entity->id);
            $product_category_ids = [];
            foreach ($provider_main_category_models as $provider_main_category_model) {
                $product_category_ids[] = $provider_main_category_model->product_category_id;
            }
            $data['product_category_ids'] = $product_category_ids;

            //得到主营产品的名称
            $product_category_names = [];
            if (!empty($data['product_category_ids'])) {
                $category_repository = new CategoryRepository();
                $product_category_models = $category_repository->getProductCategoryByIds($data['product_category_ids']);
                $product_category_names = [];
                foreach ($product_category_models as $product_category_model) {
                    $product_category_names[] = $product_category_model->name;
                }
            }
            $item['brand_category'] = $product_category_names;
            $items[] = $item;
        }
        $data['list'] = $items;
        $data['count'] = $paginate->total();
        return $data;
    }

    /**
     * @param $id
     * @return array
     */
    public function getBrandInfo($id)
    {
        $data = [];
        $brand_repository = new ProviderRepository();
        $resource_repository = new ResourceRepository();
        $category_repository = new CategoryRepository();
        $province_repository = new ProvinceRepository();
        $product_repository = new ProductRepository();
        $city_repository = new CityRepository();
        $brand_company_type = BrandCompanyType::acceptableEnums();
        $brand_management_type = BrandManagementType::acceptableEnums();
        $brand_type = BrandType::acceptableEnums();
        /** @var ProviderEntity $brand_entity */
        $brand_entity = $brand_repository->fetch($id);
        if (isset($brand_entity)) {
            //$data = $brand_entity->toArray();
            $data['id'] = $brand_entity->id;
            //得到缩略图
            //获取图片信息
            $provider_picture_repository = new ProviderPictureRepository();
            $resource_repository = new ResourceRepository();
            $provider_picture_entities = $provider_picture_repository->getImageByProviderId($id);

            $image_ids = [];
            /** @var ProviderPictureEntity $provider_picture_entity */
            foreach ($provider_picture_entities as $provider_picture_entity) {
                $image_ids[] = $provider_picture_entity->image_id;
            }
            $resource_entities = $resource_repository->getResourceUrlByIds($image_ids);
            /** @var ResourceEntity $resource_entity */
            $images = [];
            foreach ($provider_picture_entities as $provider_picture_entity) {
                $image = $provider_picture_entity->toArray();
                foreach ($resource_entities as $resource_entity) {
                    if ($provider_picture_entity->image_id == $resource_entity->id) {
                        $image['id'] = $provider_picture_entity->image_id;
                        $image['url'] = $resource_entity->url;
                    }
                }
                $images[] = $image;
            }

            $data['logo_url'] = '';
            $logo_url = collect($images)->where('type', ProviderImageType::LOGO)->toArray();
            if (!empty($logo_url)) {
                $data['logo_url'] = $logo_url[0]['url'];
            }
            //得到选中二级分类
            $provider_main_category_repository = new ProviderMainCategoryRepository();
            $provider_main_category_models = $provider_main_category_repository->getProviderMainCategoriesByProviderId($brand_entity->id);
            $product_category_ids = [];
            foreach ($provider_main_category_models as $provider_main_category_model) {
                $product_category_ids[] = $provider_main_category_model->product_category_id;
            }
            $data['product_category_ids'] = $product_category_ids;

            //得到主营产品的名称
            $product_category_names = [];
            if (!empty($data['product_category_ids'])) {
                $category_repository = new CategoryRepository();
                $product_category_models = $category_repository->getProductCategoryByIds($data['product_category_ids']);
                $product_category_names = [];
                foreach ($product_category_models as $product_category_model) {
                    $product_category_names[] = $product_category_model->name;
                }
            }
            $data['product_category_names'] = $product_category_names;
            $brand_product_count = $product_repository->getProductCountByBrandId($brand_entity->id);
            $data['avg_price'] = 0;
            if ($brand_product_count > 10) {
                $brand_product_avg = $product_repository->getProductAvgPriceByBrandId($brand_entity->id);
                $data['avg_price'] = round($brand_product_avg, 2);
            }
            $data['company_type_name'] = $brand_company_type[$brand_entity->company_type] ?? '未知';
            $data['company_name'] = $brand_entity->company_name;
            $data['brand_name'] = $brand_entity->brand_name;
            /** @var ProvinceEntity $province_entity */
            $province_entity = $province_repository->fetch($brand_entity->province_id);
            $data['province_name'] = $province_entity->name ?? '';
            /** @var CityEntity $city_entity */
            $city_entity = $city_repository->fetch($brand_entity->city_id);
            $data['city_name'] = $city_entity->name ?? '';
            $data['corp'] = $brand_entity->corp ?? '';
            $data['operation_mode_name'] = $brand_management_type[$brand_entity->operation_mode] ?? '';
            $data['domestic_import_name'] = [];
            foreach ($brand_entity->provider_domestic_imports as $brand_domestic_import) {
                $data['domestic_import_name'][] = $brand_type[$brand_domestic_import] ?? '';
            }
            $data['founding_time'] = Carbon::parse($brand_entity->founding_time)->format('Y');
            $data['registered_capital'] = floatval($brand_entity->registered_capital) ?? 0;
            $data['registered_capital_unit'] = $brand_entity->registered_capital_unit ?? '';
            $data['turnover'] = $brand_entity->turnover ?? 0;
            $data['worker_count'] = $brand_entity->worker_count ?? 0;
            $data['produce_address'] = $brand_entity->produce_address ?? '';
            $data['operation_address'] = $brand_entity->operation_address ?? '';
            $data['summary'] = $brand_entity->summary ?? '';
            $data['comment_count'] = $brand_entity->comment_count ?? 0;
            $data['telphone'] = $brand_entity->telphone ?? '';
            $data['brand_friends'] = $brand_entity->brand_friends;

            $data['brand_friends'] = [];
            foreach ($brand_entity->brand_friends as $value) {
                /** @var ProviderEntity $brand_friend_entity */
                $brand_friend_entity = $brand_repository->fetch($value);
                $brand_friends['id'] = $brand_friend_entity->id;
                //得到缩略图
                //获取图片信息
                $provider_picture_repository = new ProviderPictureRepository();
                $resource_repository = new ResourceRepository();
                $provider_picture_entities = $provider_picture_repository->getImageByProviderId($brand_friend_entity->id);

                $image_ids = [];
                /** @var ProviderPictureEntity $provider_picture_entity */
                foreach ($provider_picture_entities as $provider_picture_entity) {
                    $image_ids[] = $provider_picture_entity->image_id;
                }
                $resource_entities = $resource_repository->getResourceUrlByIds($image_ids);
                /** @var ResourceEntity $resource_entity */
                $images = [];
                foreach ($provider_picture_entities as $provider_picture_entity) {
                    $image = $provider_picture_entity->toArray();
                    foreach ($resource_entities as $resource_entity) {
                        if ($provider_picture_entity->image_id == $resource_entity->id) {
                            $image['id'] = $provider_picture_entity->image_id;
                            $image['url'] = $resource_entity->url;
                        }
                    }
                    $images[] = $image;
                }
                $brand_friends['logo_url'] = [];
                $friend_logo = collect($images)->where('type', ProviderImageType::LOGO)->toArray();
                if (!empty($friend_logo)) {
                    $brand_friends['logo_url'][] = $friend_logo[0]['url'];
                }

                $data['brand_friends'][] = $brand_friends;
            }
            $data['product_count'] = $product_repository->getProductCountByBrandId($brand_entity->id) ?? 0;
        }
        return $data;
    }
}


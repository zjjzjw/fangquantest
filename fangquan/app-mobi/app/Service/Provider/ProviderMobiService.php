<?php

namespace App\Mobi\Service\Provider;

use App\Service\FqUser\CheckTokenService;
use App\Service\Provider\ProviderPropagandaService;
use App\Service\Provider\ProviderService;
use App\Src\Advertisement\Infra\Repository\AdvertisementRepository;
use App\Src\Product\Domain\Model\ProductCategoryEntity;
use App\Src\Product\Infra\Repository\ProductCategoryRepository;
use App\Src\Provider\Domain\Model\OperationModelType;
use App\Src\Provider\Domain\Model\ProviderCertificateEntity;
use App\Src\Provider\Domain\Model\ProviderCertificateStatus;
use App\Src\Provider\Domain\Model\ProviderCertificateType;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderImageType;
use App\Src\Provider\Domain\Model\ProviderMainCategoryEntity;
use App\Src\Provider\Domain\Model\ProviderPictureEntity;
use App\Src\Provider\Domain\Model\ProviderPropagandaStatus;
use App\Src\Provider\Domain\Model\ProviderRankCategoryEntity;
use App\Src\Provider\Domain\Model\ProviderServiceNetworkStatus;
use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Src\Provider\Infra\Repository\ProviderCertificateRepository;
use App\Src\Provider\Infra\Repository\ProviderFavoriteRepository;
use App\Src\Provider\Infra\Repository\ProviderMainCategoryRepository;
use App\Src\Provider\Infra\Repository\ProviderPictureRepository;
use App\Src\Provider\Infra\Repository\ProviderRankCategoryRepository;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\CityRepository;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProviderMobiService
{
    public function getProviderById($id)
    {
        $data = [];
        $city_repository = new CityRepository();
        $provider_service = new ProviderService();
        $provider = $provider_service->getProviderInfo($id);
        if (!empty($provider['city_id'])) {
            /** @var CityEntity $city_entity */
            $city_entity = $city_repository->fetch($provider['city_id']);
            $data['address'] = $city_entity->name;
        } else {
            $data['address'] = '';
        }
        $data['logo'] = '';
        if (!empty($provider['logo_images'])) {
            $data['logo'] = current($provider['logo_images'])['url'];
        }
        $data['company_name'] = $provider['company_name'];
        $data['brand_name'] = $provider['brand_name'];
        $data['main_categories'] = $provider_service->getProviderMainCategory($id);
        $data['main_categories_rank'] = $this->providerCategoryRank($id);
        $data['score_scale'] = $provider['score_scale'];
        $data['score_qualification'] = $provider['score_qualification'];
        $data['score_credit'] = $provider['score_credit'];
        $data['score_innovation'] = $provider['score_innovation'];
        $data['score_service'] = $provider['score_service'];
        $data['provider_aduitdetails'] = $provider_service->getProviderAduitdetails($id);
        $data['publicity'] = [];

        $provider_propaganda_service = new ProviderPropagandaService();
        $provider_propagandaes = $provider_propaganda_service->getProviderPropagandaByProviderIdAndStatus(
            $id,
            ProviderPropagandaStatus::STATUS_PASS
        );
        foreach ($provider_propagandaes as $provider_propaganda) {
            $item = [];
            $item['image'] = $provider_propaganda['url'] ?? '';
            $item['link'] = $provider_propaganda['link'] ?? '';
            $data['publicity'][] = $item;
        }

        $data['has_collected'] = false;
        if (CheckTokenService::isLogin()) {
            $user_id = CheckTokenService::getUserId();
            $provider_favorite_repository = new ProviderFavoriteRepository();
            $provider_favorite_entities = $provider_favorite_repository->getProviderFavoriteByUserIdAndProviderId(
                $user_id, $id
            );
            if (!$provider_favorite_entities->isEmpty()) {
                $data['has_collected'] = true;
            }
        }
        return $data;
    }

    /**
     * @param $provider_id
     * @return array
     */
    public function providerCategoryRank($provider_id)
    {
        $data = [];
        $provider_rank_category = new ProviderRankCategoryRepository();
        $product_repository = new ProductCategoryRepository();
        $provider_rank_category_entity = $provider_rank_category->getProviderRankCategoryByProviderId($provider_id);
        foreach ($provider_rank_category_entity as $value) {
            $product_repository_entity = $product_repository->fetch($value->category_id);
            $provider_category['name'] = $product_repository_entity->name;
            $provider_category['rank'] = $value->rank;
            $data[] = $provider_category;
        }
        return $data;
    }

    public function getProviderList(ProviderSpecification $spec, $per_page = 20)
    {

        $result = [];
        $provider_repository = new ProviderRepository();
        $paginate = $provider_repository->search($spec, $per_page);
        $provider_service = new ProviderService();
        $items = [];
        /**
         * @var int                  $key
         * @var ProviderEntity       $provider_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $provider_entity) {

            $item = [];
            //获取图片信息
            $provider_picture_repository = new ProviderPictureRepository();
            $resource_repository = new ResourceRepository();
            $provider_picture_entities = $provider_picture_repository->getImageByProviderId($provider_entity->id);
            $image_ids = [];
            /** @var ProviderPictureEntity $provider_picture_entity */
            foreach ($provider_picture_entities as $provider_picture_entity) {
                $image_ids[] = $provider_picture_entity->image_id;
            }
            $resource_entities = $resource_repository->getResourceUrlByIds($image_ids);
            /** @var ResourceEntity $resource_entity */
            $images = [];
            $logo_images = [];
            $structure_images = [];
            $sub_structure_images = [];
            $factory_images = [];
            $device_images = [];

            foreach ($provider_picture_entities as $provider_picture_entity) {
                $image = $provider_picture_entity->toArray();
                foreach ($resource_entities as $resource_entity) {
                    if ($provider_picture_entity->image_id == $resource_entity->id) {
                        $image['url'] = $resource_entity->url;
                    }
                }
                $images[] = $image;
            }

            $logo_images = collect($images)->where('type', ProviderImageType::LOGO)->toArray();
            $license_images = collect($images)->where('type', ProviderImageType::LICENSE)->toArray();
            $structure_images = collect($images)->where('type', ProviderImageType::STRUCTURE)->toArray();
            $sub_structure_images = collect($images)->where('type', ProviderImageType::SUB_STRUCTURE)->toArray();
            $factory_images = collect($images)->where('type', ProviderImageType::FACTORY)->toArray();
            $device_images = collect($images)->where('type', ProviderImageType::DEVICE)->toArray();

            $item['id'] = $provider_entity->id;
            $item['main_categories'] = $provider_service->getProductCategory($item['id']);
            if (!empty(($logo_images))) {
                $item['logo'] = current($logo_images)['url'];
            }
            $item['founding_time'] = $provider_entity->founding_time;
            $item['company_name'] = $provider_entity->company_name;
            $item['registered_capital'] = $provider_entity->registered_capital;
            $item['address'] = $provider_entity->operation_address;
            $item['product_count'] = $provider_entity->project_count;
            $item['history_project_count'] = $provider_entity->project_count;
            $items[] = $item;
        }
        $result['list'] = $items;
        $result['count'] = $paginate->total();
        return $result;
    }


    public function getCompanyInfo($provider_id)
    {
        $data = [];
        $provider_service = new ProviderService();
        $provider = $provider_service->getProviderInfo($provider_id);
        $operation_mode_types = OperationModelType::acceptableEnums();

        $data['operation_mode'] = $operation_mode_types[$provider['operation_mode']] ?? '';
        $data['founding_time'] = $provider['founding_time'];
        $data['company_name'] = $provider['company_name'];
        $data['brand_name'] = $provider['brand_name'];

        $data['main_categories'] = $provider_service->getProductCategory($provider_id);
        $data['registered_capital'] = $provider['registered_capital'];
        $data['turnover'] = $provider['turnover'];
        $data['produce_address'] = $provider['produce_address'];
        $data['operation_address'] = $provider['operation_address'];
        $data['worker_count'] = $provider['worker_count'];
        $data['summary'] = $provider['summary'];
        $data['corp'] = $provider['corp'];
        $data['license'] = '';
        if (!empty($provider['license_images'])) {
            $data['license'] = current($provider['license_images'])['url'];
        }
        //images_device 工厂和设备图片
        $data['images_device'] = [];
        foreach ($provider['factory_images'] as $image) {
            $data['images_device'][] = ['image' => $image['url']];
        }
        foreach ($provider['device_images'] as $image) {
            $data['images_device'][] = ['image' => $image['url']];
        }

        //images_structure 结构图片
        $data['images_structure'] = [];
        foreach ($provider['structure_images'] as $image) {
            $data['images_structure'][] = ['image' => $image['url']];
        }
        foreach ($provider['sub_structure_images'] as $image) {
            $data['images_structure'][] = ['image' => $image['url']];
        }
        //企业证书
        $certificate = $this->getProviderCertificate($provider_id);
        $data['certificate'] = $certificate;
        return $data;
    }


    public function getProviderCertificate($provider_id)
    {
        $certificate = [];
        $certificate['qualification'] = [];
        $certificate['patent'] = [];
        $certificate['glory'] = [];
        $provider_certificate_repository = new ProviderCertificateRepository();
        $provider_certificate_entities = $provider_certificate_repository->getProviderCertificateByProviderIdAndStatus(
            $provider_id, ProviderCertificateStatus::STATUS_PASS
        );
        $image_ids = [];
        /** @var ProviderCertificateEntity $provider_certificate_entity */
        foreach ($provider_certificate_entities as $provider_certificate_entity) {
            $image_ids[] = $provider_certificate_entity->image_id;
        }
        $resource_repository = new ResourceRepository();
        $resource_entities = $resource_repository->getResourceUrlByIds($image_ids);
        foreach ($provider_certificate_entities as $provider_certificate_entity) {
            if ($provider_certificate_entity->type == ProviderCertificateType::QUALIFICATION) {
                if (isset($resource_entities[$provider_certificate_entity->image_id])) {
                    $certificate['qualification'][] = ['image' => $resource_entities[$provider_certificate_entity->image_id]->url];
                }
            } else if ($provider_certificate_entity->type == ProviderCertificateType::HONOR) {
                $certificate['glory'][] = ['image' => $resource_entities[$provider_certificate_entity->image_id]->url];
            } else if ($provider_certificate_entity->type == ProviderCertificateType::PATENT) {
                $certificate['patent'][] = ['image' => $resource_entities[$provider_certificate_entity->image_id]->url];
            }
        }
        return $certificate;
    }


    public function getProviderContact($provider_id)
    {
        $data = [];
        $provider_service = new ProviderService();
        $provider = $provider_service->getProviderInfo($provider_id);
        $data['telphone'] = $provider['telphone'];
        $data['fax'] = $provider['fax'];
        $data['service_telphone'] = $provider['service_telphone'];
        $data['website'] = $provider['website'];

        return $data;
    }


    public function getProductCategoryByProviderId($provider_id)
    {
        $items = [];
        $provider_main_category = new ProviderMainCategoryRepository();
        $provider_main_category_entities = $provider_main_category->getProviderMainCategoriesByProviderId(
            $provider_id
        );
        $provider_category_ids = [];
        /** @var ProviderMainCategoryEntity $provider_main_category_entity */
        foreach ($provider_main_category_entities as $provider_main_category_entity) {
            $provider_category_ids[] = $provider_main_category_entity->product_category_id;
        }
        if (!empty($provider_category_ids)) {
            $product_category_repository = new ProductCategoryRepository();
            $product_category_entities = $product_category_repository->getProductCategoryByIds($provider_category_ids);
            /** @var ProductCategoryEntity $product_category_entity */
            foreach ($product_category_entities as $product_category_entity) {
                $item = [];
                $item['product_category_id'] = $product_category_entity->id;
                $item['name'] = $product_category_entity->name;
                $items[] = $item;
            }
        }
        return $items;
    }

    /**
     * 供应商列表
     * @param ProviderSpecification $spec
     * @param int                   $per_page
     * @return array
     */
    public function getProviderByProductCategoryId(ProviderSpecification $spec, $per_page = 10)
    {
        $items = [];
        $provider_rank_category = new ProviderRankCategoryRepository();
        $provider_rank_category_entities = $provider_rank_category->getProviderRankCategoryByProductCategoryId($spec->product_category_id);
        $provider_ids = [];
        /** @var ProviderRankCategoryEntity $provider_rank_category_entity */
        foreach ($provider_rank_category_entities->toArray() as $provider_rank_category_entity) {
            $provider_ids[] = $provider_rank_category_entity->provider_id;
        }
        //如果不存在供应室ID直接返回空
        if (empty($provider_ids)) {
            return $items;
        }
        //重新赋值
        $spec->provider_id = $provider_ids;

        $provider_repository = new ProviderRepository();

        $provider_entities = $provider_repository->getProviderByCategory($spec, $per_page);

        $provider_items = $this->getProviderListByCategory($provider_entities, $spec->product_category_id);

        $items = $provider_items;

        return $items;
    }

    /**
     * @param $advertisement_entity
     * @return array
     */
    public function adPictureList($advertisement_entity)
    {
        $data = [];
        $resource_repository = new ResourceRepository();
        foreach ($advertisement_entity as $advertisement) {
            if (isset($advertisement->image_id)) {
                $resource_entities = $resource_repository->getResourceUrlByIds($advertisement->image_id);
            } else {
                $resource_entities = '';
            }
            $ad['image_url'] = $resource_entities ? current($resource_entities)->url : '';
            $ad['link'] = $advertisement->link;
            $ad['is_ad'] = true;
            $ad['is_picture_ad'] = true;
            $data[] = $ad;
        }
        return $data;
    }

    /**
     * 新增广告
     * @param $array
     * @param $position
     * @param $value
     * @return array
     */
    public function addAdProvider($array, $position, $value)
    {
        $provider_entities_arr = [];
        for ($i = 0; $i <= count($array); $i++) {
            if ($i == $position) {
                $provider_entities_arr[$position] = $value;
            } elseif ($i < $position) {
                $provider_entities_arr[$i] = $array[$i];
            } else {
                $provider_entities_arr[$i] = $array[$i - 1];
            }
        }
        return $provider_entities_arr;
    }


    /**
     * 获取分类下的供应商列表
     * @param      $provider_entities
     * @param      $provider_category_id
     * @param bool $is_ad
     * @return array
     */
    public function getProviderListByCategory($provider_entities, $provider_category_id, $is_ad = false)
    {
        $items = [];
        //获取图片信息
        $provider_picture_repository = new ProviderPictureRepository();
        $resource_repository = new ResourceRepository();
        $provider_service = new ProviderService();
        $city_repository = new CityRepository();
        /** @var ProviderEntity $provider_entity */
        foreach ($provider_entities as $provider_entity) {
            $resource_entities = '';
            $provider_picture_entities = $provider_picture_repository->getLogoByProviderId($provider_entity->id);
            if (isset($provider_picture_entities)) {
                $resource_entities = $resource_repository->getResourceUrlByIds($provider_picture_entities->image_id);
            }
            $city_id = $provider_entity->city_id;
            /** @var CityEntity $city_entity */
            if (isset($city_id)) {
                $city_entity = $city_repository->fetch($provider_entity->city_id);
            }
            $item = [];
            $item['is_ad'] = false;
            $item['provider_id'] = $provider_entity->id;
            //供应商排名
            $provider_rank_category = new ProviderRankCategoryRepository();
            $provider_rank_category_entities = $provider_rank_category->getProviderRankCategoryByProductCategoryId($provider_category_id, $item['provider_id']);
            $provider_rank_category = current($provider_rank_category_entities->toArray());
            if (!empty($provider_rank_category)) {
                $item['rank'] = $provider_rank_category->rank;
            }
            $item['brand_name'] = $provider_entity->brand_name;
            $item['company_name'] = $provider_entity->company_name;
            $item['logo'] = $resource_entities ? current($resource_entities)->url : '';
            $main_categories = $provider_service->getProviderMainCategory($provider_entity->id);
            $item['main_categories'] = $main_categories;
            $item['city'] = $city_entity ? $city_entity->name : '';
            $items[] = $item;
        }
        return $items;

    }

    public function getProviderBrandRank($category_id, $limit = 10)
    {
        $items = [];
        $provider_repository = new ProviderRepository();
        $provider_entities = $provider_repository->getProviderBrandRank($category_id, 10);
        //获取图片信息
        $provider_picture_repository = new ProviderPictureRepository();
        $resource_repository = new ResourceRepository();

        /** @var ProviderEntity $provider_entity */
        foreach ($provider_entities as $provider_entity) {
            $item = [];
            $provider_picture_entities = $provider_picture_repository->getImageByProviderId($provider_entity->id);
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
                        $image['url'] = $resource_entity->url;
                    }
                }
                $images[] = $image;
            }
            $logo_images = collect($images)->where('type', ProviderImageType::LOGO)->toArray();
            $license_images = collect($images)->where('type', ProviderImageType::LICENSE)->toArray();
            $structure_images = collect($images)->where('type', ProviderImageType::STRUCTURE)->toArray();
            $sub_structure_images = collect($images)->where('type', ProviderImageType::SUB_STRUCTURE)->toArray();
            $factory_images = collect($images)->where('type', ProviderImageType::FACTORY)->toArray();
            $device_images = collect($images)->where('type', ProviderImageType::DEVICE)->toArray();
            //获取主营产品信息
            $item['id'] = $provider_entity->id;
            if (!empty($logo_images)) {
                $item['logo'] = current($logo_images)['url'];
            } else {
                $item['logo'] = '';
            }
            $item['name'] = $provider_entity->company_name;
            $items[] = $item;
        }
        return $items;
    }


    public function getProviderByIds($provider_ids)
    {
        $provider_ids = explode(',', $provider_ids);
        $provider_repository_repository = new ProviderRepository();
        $provider_service_network_mobi_service = new ProviderServiceNetworkMobiService();
        $provider_certificate_repository = new ProviderCertificateRepository();
        /** @var ProviderEntity $provider_repository_entities */
        $provider_repository_entities = $provider_repository_repository->getProviderByIds($provider_ids);
        $items = [];
        foreach ($provider_repository_entities as $provider_repository_entity) {
            if (isset($provider_repository_entity)) {
                //获取图片信息
                $provider_picture_repository = new ProviderPictureRepository();
                $resource_repository = new ResourceRepository();
                $provider_picture_entities = $provider_picture_repository->getImageByProviderId($provider_repository_entity->id);
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
                            $image['url'] = $resource_entity->url;
                        }
                    }
                    $images[] = $image;
                }
                $logo_images = collect($images)->where('type', ProviderImageType::LOGO)->toArray();
                //获取主营产品信息
                $item['logo'] = '';
                if (!empty($logo_images)) {
                    $item['logo'] = current($logo_images)['url'];
                }
                //品牌名
                $item['brand_name'] = $provider_repository_entity->brand_name;
                //企业规模分数
                $item['score_scale'] = $provider_repository_entity->score_scale;
                //行业资质分数
                $item['score_qualification'] = $provider_repository_entity->score_qualification;
                //企业信用分数
                $item['score_credit'] = $provider_repository_entity->score_credit;
                //创新能力分数
                $item['score_innovation'] = $provider_repository_entity->score_innovation;
                //服务体系分数
                $item['score_service'] = $provider_repository_entity->score_service;
                //企业规模
                $item['worker_count'] = $provider_repository_entity->worker_count;
                //专利数
                $item['patent_count'] = $provider_repository_entity->patent_count;
                //行业资质证书
                $item['qualification'] = [];
                $provider_certificate_entities = $provider_certificate_repository->getProviderCertificateByProviderIdAndStatus(
                    $provider_repository_entity->id, ProviderCertificateStatus::STATUS_PASS
                );
                foreach ($provider_certificate_entities as $provider_certificate_entity) {
                    $item['qualification'][] = $provider_certificate_entity->name;
                }
                //服务网点集合
                $item['provider_service_network'] = $provider_service_network_mobi_service->getProviderServiceNetworkCount($provider_repository_entity->id, ProviderServiceNetworkStatus::STATUS_PASS);
                //好评率
                $item['praise_rate'] = '';
                $items[] = $item;
            }
        }
        return $items;
    }
}


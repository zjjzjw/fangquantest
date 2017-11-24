<?php

namespace App\Service\Provider;


use App\Src\FqUser\Domain\Model\FqUserRoleType;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use App\Src\Product\Domain\Model\ProductCategoryEntity;
use App\Src\Product\Domain\Model\ProductCategoryType;
use App\Src\Product\Infra\Repository\ProductCategoryRepository;
use App\Src\Provider\Domain\Model\ProviderCertificateEntity;
use App\Src\Provider\Domain\Model\ProviderCertificateStatus;
use App\Src\Provider\Domain\Model\ProviderCertificateType;
use App\Src\Provider\Domain\Model\ProviderFriendStatus;
use App\Src\Provider\Domain\Model\ProviderImageType;
use App\Src\Provider\Domain\Model\ProviderCompanyType;
use App\Src\Category\Domain\Model\CategoryEntity;
use App\Src\Category\Infra\Repository\CategoryRepository;
use App\Src\Provider\Domain\Model\ProviderPictureEntity;
use App\Src\Provider\Domain\Model\ProviderProductStatus;
use App\Src\Provider\Domain\Model\ProviderProjectStatus;
use App\Src\Provider\Domain\Model\ProviderServiceNetworkStatus;
use App\Src\Provider\Domain\Model\ProviderStatus;
use App\Src\Provider\Infra\Eloquent\ProviderModel;
use App\Src\Provider\Infra\Repository\ProviderAduitdetailsRepository;
use App\Src\Provider\Infra\Repository\ProviderCertificateRepository;
use App\Src\Provider\Infra\Repository\ProviderFriendRepository;
use App\Src\Provider\Infra\Repository\ProviderPictureRepository;
use App\Src\Provider\Infra\Repository\ProviderProductProgrammeRepository;
use App\Src\Provider\Infra\Repository\ProviderProductRepository;
use App\Src\Provider\Infra\Repository\ProviderProjectRepository;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Src\Provider\Infra\Repository\ProviderServiceNetworkRepository;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\CityRepository;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Pagination\LengthAwarePaginator;


class ProviderService
{
    /**
     * @param ProviderSpecification $spec
     * @param int $per_page
     * @return array
     */
    public function getProviderList(ProviderSpecification $spec, $per_page)
    {
        $data = [];
        $provider_repository = new ProviderRepository();
        $paginate = $provider_repository->search($spec, $per_page);
        $provider_status = ProviderStatus::acceptableEnums();
        $items = [];
        /**
         * @var int $key
         * @var ProviderEntity $provider_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $provider_entity) {
            $item = $provider_entity->toArray();
            if (isset($item['status'])) {
                $item['status_name'] = $provider_status[$item['status']] ?? '';
            }
            $item['provider_main_category'] = $this->getProviderCategoryNameById($item['id']);
            $fq_user_entity = $this->getProviderUsers($item['id']);
            if (!empty($fq_user_entity)) {
                $item['account_status'] = $fq_user_entity['account_status'];
                $item['expire'] = $fq_user_entity['expire'];
                $item['account'] = $fq_user_entity['account'];
            }
            $items[] = $item;
        }
        $data['paginate'] = $paginate;
        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }

    public function getProviderMoreList($skip = 0, $limit = 20)
    {
        $data = [];
        $provider_repository = new ProviderRepository();
        $paginate = $provider_repository->getProviderMoreList($skip, $limit);
        $city_repository = new CityRepository();
        $province_repository = new ProvinceRepository();
        $provider_mode_types = ProviderCompanyType::acceptableEnums();

        //获取图片信息
        $provider_picture_repository = new ProviderPictureRepository();
        $resource_repository = new ResourceRepository();
        $provider_product_repository = new ProviderProductRepository();
        $provider_product_programme_repository = new ProviderProductProgrammeRepository();
        $items = [];
        /**
         * @var int $key
         * @var ProviderEntity $provider_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $provider_entity) {
            $item['id'] = $provider_entity->id;
            $item['registered_capital'] = (int)$provider_entity->registered_capital;
            $item['company_name'] = $provider_entity->company_name;
            $item['brand_name'] = $provider_entity->brand_name;
            /** @var CityEntity $city_entity */
            $city_entity = $city_repository->fetch($provider_entity->city_id);
            if (isset($city_entity)) {
                $item['city_name'] = $city_entity->name;
            }
            $item['company_type_name'] = $provider_mode_types[$provider_entity->company_type] ?? '';

            /** @var ProvinceEntity $province_entity */
            $province_entity = $province_repository->fetch($provider_entity->province_id);
            if (isset($province_entity)) {
                $item['province_name'] = $province_entity->name;
            }
            $provider_product_entities = $provider_product_repository->getProviderProductByProviderIdAndStatus(
                $provider_entity->province_id, ProviderProductStatus::STATUS_PASS
            );
            $item['product_count'] = count($provider_product_entities);
            $provider_product_programme_entities = $provider_product_programme_repository->getProviderProductProgrammeByProviderId($provider_entity->province_id);
            $item['programme_count'] = count($provider_product_programme_entities);
            $item['provider_main_category'] = $this->getProviderCategoryName($provider_entity->id);
            $item['provider_main_categorys'] = $this->getProviderMainCategory($provider_entity->id);
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
            $item['logo_url'] = '/www/images/provider/default_logo.png';
            if (!empty(($logo_images))) {
                $item['logo_url'] = current($logo_images)['url'] ?? '/www/images/provider/default_logo.png';
            }
            $items[] = $item;
        }
        $data['paginate'] = $paginate;
        $data['items'] = $items;

        return $data;
    }

    /**
     * @param ProviderSpecification $spec
     * @param int $per_page
     * @return array
     */
    public function getExProviderList(ProviderSpecification $spec, $per_page)
    {
        $data = [];
        $provider_repository = new ProviderRepository();
        $paginate = $provider_repository->search($spec, $per_page);
        $city_repository = new CityRepository();
        $province_repository = new ProvinceRepository();
        $provider_mode_types = ProviderCompanyType::acceptableEnums();

        //获取图片信息
        $provider_picture_repository = new ProviderPictureRepository();
        $resource_repository = new ResourceRepository();
        $provider_product_repository = new ProviderProductRepository();
        $provider_product_programme_repository = new ProviderProductProgrammeRepository();
        $items = [];
        /**
         * @var int $key
         * @var ProviderEntity $provider_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $provider_entity) {
            $item['id'] = $provider_entity->id;
            $item['registered_capital'] = (int)$provider_entity->registered_capital;
            $item['company_name'] = $provider_entity->company_name;
            $item['brand_name'] = $provider_entity->brand_name;
            /** @var CityEntity $city_entity */
            $city_entity = $city_repository->fetch($provider_entity->city_id);
            if (isset($city_entity)) {
                $item['city_name'] = $city_entity->name;
            }
            $item['company_type_name'] = $provider_mode_types[$provider_entity->company_type] ?? '';

            /** @var ProvinceEntity $province_entity */
            $province_entity = $province_repository->fetch($provider_entity->province_id);
            if (isset($province_entity)) {
                $item['province_name'] = $province_entity->name;
            }
            $provider_product_entities = $provider_product_repository->getProviderProductByProviderIdAndStatus(
                $provider_entity->province_id, ProviderProductStatus::STATUS_PASS
            );
            $item['product_count'] = count($provider_product_entities);
            $provider_product_programme_entities = $provider_product_programme_repository->getProviderProductProgrammeByProviderId($provider_entity->province_id);
            $item['programme_count'] = count($provider_product_programme_entities);
            $item['provider_main_category'] = $this->getProviderCategoryName($provider_entity->id);
            $item['provider_main_categorys'] = $this->getProviderMainCategory($provider_entity->id);
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
            $item['logo_url'] = '/www/images/provider/default_logo.png';
            if (!empty(($logo_images))) {
                $item['logo_url'] = current($logo_images)['url'] ?? '/www/images/provider/default_logo.png';
            }
            $items[] = $item;
        }
        $data['paginate'] = $paginate;
        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }

    /**
     * 得到供应商主营类别名称
     * @return string
     */
    public function getProviderCategoryName($id)
    {
        $category_names = [];
        /** @var ProviderModel $provider_model */
        $provider_model = ProviderModel::find($id);
        if (isset($provider_model)) {
            $product_category_repository = new ProductCategoryRepository();
            foreach ($provider_model->provider_main_categories as $value) {
                /** @var ProductCategoryEntity $product_category_entity */
                $product_category_entity = $product_category_repository->fetch($value->product_category_id);
                if (isset($product_category_entity)) {
                    $category_names[] = $product_category_entity->name;
                }
            }
        }
        return implode(',', $category_names);
    }

    /**
     * 得到供应商主营类别名称新版Category
     * @return string
     */
    public function getProviderCategoryNameById($id)
    {
        $category_names = [];
        /** @var ProviderModel $provider_model */
        $provider_model = ProviderModel::find($id);
        if (isset($provider_model)) {
            $category_repository = new CategoryRepository();
            foreach ($provider_model->provider_main_categories as $value) {
                /** @var ProductCategoryEntity $product_category_entity */
                $category_entity = $category_repository->fetch($value->product_category_id);
                if (isset($category_entity)) {
                    $category_names[] = $category_entity->name;
                }
            }
        }
        return implode(',', $category_names);
    }

    /**
     * 获取主营分类信息
     * @param $id
     * @return string
     */
    public function getProductCategory($id)
    {
        $category_names = [];
        /** @var ProviderModel $provider_model */
        $provider_model = ProviderModel::find($id);
        if (isset($provider_model)) {
            $product_category_repository = new ProductCategoryRepository();
            foreach ($provider_model->provider_main_categories as $value) {
                /** @var ProductCategoryEntity $product_category_entity */
                $product_category_entity = $product_category_repository->fetch($value->product_category_id);
                if (isset($product_category_entity)) {
                    $category_names[] = $product_category_entity->name;
                }
            }
        }
        return implode(',', $category_names);
    }

    /**
     * @param $id
     * @return array
     */
    public function getProviderMainCategory($id)
    {
        $category_names = [];

        /** @var ProviderModel $provider_model */
        $provider_model = ProviderModel::find($id);

        if (isset($provider_model)) {
            $category_repository = new CategoryRepository();
            $category_colour = ProductCategoryType::acceptableAppColourEnums();
            foreach ($provider_model->provider_main_categories as $value) {
                $color = $this->randrgb();
                /** @var ProductCategoryEntity $product_category_entity */
                $product_category_entity = $category_repository->fetch($value->product_category_id);
                if (isset($product_category_entity)) {
                    $category_name['colour'] = $category_colour[$product_category_entity->id] ?? '';
                    $category_name['name'] = $product_category_entity->name;
                    $category_name['color'] = $color;
                    $category_names[] = $category_name;
                }
            }
        }
        return $category_names;
    }

    /**随机颜色
     * @param $id
     * @return array
     */
    public function randrgb()
    {
        $colors = array('#10766E', '#B87336', '#9CAC4D', '#625718', '#12B785');
        $i = rand(0, 4);
        $color = $colors[$i];

        return $color;
    }

    /**
     * 获取供应商验厂报告数量
     * @param $id
     * @return int
     */
    public function getProviderAduitdetails($id)
    {
        $provider_aduitdetails_repository = new ProviderAduitdetailsRepository();
        $provider_aduitdetails_entities = $provider_aduitdetails_repository->getProviderAduitdetailsByProviderId($id);
        return $provider_aduitdetails_entities->count();
    }

    /**
     * 获取供应商账号信息
     * @param     $id
     * @param int $type
     * @return array
     */
    public function getProviderUsers($id, $type = FqUserRoleType::PROVIDER)
    {
        $users_repository = new FqUserRepository();
        $fq_user_entity = $users_repository->getFqUserByRoleId($id, $type);
        return $fq_user_entity;
    }

    /**
     * 得到供应商信息
     * @param $id
     * @return array
     */
    public function getProviderInfo($id)
    {
        $data = [];
        $provider_repository_repository = new ProviderRepository();
        /** @var ProviderEntity $provider_entity */
        $provider_entity = $provider_repository_repository->fetch($id);

        if (isset($provider_entity)) {

            $data = $provider_entity->toArray();
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

            $data['logo_images'] = collect($images)->where('type', ProviderImageType::LOGO)->toArray();
            $data['license_images'] = collect($images)->where('type', ProviderImageType::LICENSE)->toArray();
            $data['structure_images'] = collect($images)->where('type', ProviderImageType::STRUCTURE)->toArray();
            $data['sub_structure_images'] = collect($images)->where('type', ProviderImageType::SUB_STRUCTURE)->toArray();
            $data['factory_images'] = collect($images)->where('type', ProviderImageType::FACTORY)->toArray();
            $data['device_images'] = collect($images)->where('type', ProviderImageType::DEVICE)->toArray();
        }
        return $data;
    }


    /**
     * 计算供应商资料完整度
     * @param int $id
     * @return int
     */
    public function calculateIntegrity($id)
    {
        $total = 30;
        $provider = $this->getProviderInfo($id);
        $provider_certificate_repository = new ProviderCertificateRepository();
        $provider_certificate_entities = $provider_certificate_repository->getProviderCertificateByProviderIdAndStatus(
            $id, ProviderCertificateStatus::STATUS_PASS);
        //资质证书、专利证书、荣誉证书
        /** @var ProviderCertificateEntity $provider_certificate_entity */
        foreach ($provider_certificate_entities as $provider_certificate_entity) {
            if ($provider_certificate_entity->type == ProviderCertificateType::QUALIFICATION) {
                $provider_certificates[ProviderCertificateType::QUALIFICATION][] = $provider_certificate_entity->toArray();
            } else if ($provider_certificate_entity->type == ProviderCertificateType::PATENT) {
                $provider_certificates[ProviderCertificateType::PATENT][] = $provider_certificate_entity->toArray();
            } else if ($provider_certificate_entity->type == ProviderCertificateType::HONOR) {
                $provider_certificates[ProviderCertificateType::HONOR][] = $provider_certificate_entity->toArray();
            }
        }
        if (isset($provider_certificates[ProviderCertificateType::HONOR])) {
            $total += 5;
        }
        if (isset($provider_certificates[ProviderCertificateType::PATENT])) {
            $total += 5;
        }
        if (isset($provider_certificates[ProviderCertificateType::QUALIFICATION])) {
            $total += 5;
        }
        //企业架构，人员架构
        if (!empty($provider['structure_images'])) {
            $total += 5;
        }
        if (!empty($provider['sub_structure_images'])) {
            $total += 5;
        }
        $provider_service_network_repository = new ProviderServiceNetworkRepository();
        $provider_service_network_entities = $provider_service_network_repository->getProviderServiceNetworkByProviderIdAndStatus(
            $id, ProviderServiceNetworkStatus::STATUS_PASS);
        if ($provider_service_network_entities->count() > 0 && $provider_service_network_entities->count() <= 5) {
            $total += 5;
        } else if ($provider_service_network_entities->count() > 5) {
            $total += 10;
        }
        $provider_project_repository = new ProviderProjectRepository();
        $provider_project_entities = $provider_project_repository->getProviderProjectByProviderIdAndStatus(
            $id, ProviderProjectStatus::STATUS_PASS);
        if ($provider_project_entities->count() > 0 && $provider_project_entities->count() <= 5) {
            $total += 10;
        } else if ($provider_project_entities->count() > 5) {
            $total += 10;
        }
        $provider_product_repository = new ProviderProductRepository();
        $provider_product_entities = $provider_product_repository->getProviderProductByProviderIdAndStatus(
            $id, ProviderProductStatus::STATUS_PASS);
        if ($provider_product_entities->count() > 0 && $provider_product_entities->count() <= 5) {
            $total += 5;
        } else if ($provider_product_entities->count() > 5) {
            $total += 10;
        }
        $provider_friend_repository = new ProviderFriendRepository();
        $provider_friend_entities = $provider_friend_repository->getProviderFriendByProviderAndStatus(
            $id, ProviderFriendStatus::STATUS_PASS
        );
        if ($provider_friend_entities->count() > 0) {
            $total += 5;
        }
        return $total;
    }


    public function getAdProviderList($status, $limit)
    {
        $items = [];
        $provider_repository = new ProviderRepository();
        $provider_picture_repository = new ProviderPictureRepository();
        $resource_repository = new ResourceRepository();

        $provider_entities = $provider_repository->getAdProviderList($status, $limit);
        foreach ($provider_entities as $provider_entity) {
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
            $item['id'] = $provider_entity->id;
            $item['logo_url'] = '/www/images/provider/default_logo.png';
            if (!empty(($logo_images))) {
                $item['logo_url'] = current($logo_images)['url'] ?? '/www/images/provider/default_logo.png';
            }
            $items[] = $item;
        }
        return $items;
    }

    /**
     * @param int|array $ids
     */
    public function getProvidersByIds($ids, $statuses = null)
    {
        $items = [];
        $provider_repository = new ProviderRepository();
        $provider_picture_repository = new ProviderPictureRepository();
        $resource_repository = new ResourceRepository();
        $provider_entities = $provider_repository->getProviderByIds($ids);
        /** @var ProviderEntity $provider_entity */
        foreach ($provider_entities as $provider_entity) {
            $item = $provider_entity->toArray();
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
            $item['id'] = $provider_entity->id;
            $item['logo_url'] = '/www/images/provider/default_logo.png';

            if (!empty(($logo_images))) {
                $item['logo_url'] = current($logo_images)['url'] ?? '/www/images/provider/default_logo.png';
            }
            $items[] = $item;
        }
        return $items;
    }


}


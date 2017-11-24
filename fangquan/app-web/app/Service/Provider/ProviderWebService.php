<?php

namespace App\Web\Service\Provider;

use App\Service\Provider\ProviderRankCategoryService;
use App\Src\Provider\Domain\Model\ProviderCompanyType;
use App\Src\Provider\Domain\Model\ProviderImageType;
use App\Src\Provider\Domain\Model\ProviderManagementType;
use App\Src\Provider\Domain\Model\ProviderPictureEntity;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Src\Provider\Infra\Repository\ProviderCertificateRepository;
use App\Src\Provider\Domain\Model\ProviderCertificateEntity;
use App\Src\Provider\Domain\Model\ProviderCertificateStatus;
use App\Src\Provider\Domain\Model\ProviderPropagandaStatus;
use App\Src\Provider\Domain\Model\ProviderCertificateType;
use App\Src\Provider\Infra\Repository\ProviderPictureRepository;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\CityRepository;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use App\Src\Provider\Domain\Model\OperationModelType;
use App\Service\Provider\ProviderPropagandaService;
use App\Service\Provider\ProviderService;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class ProviderWebService
{

    public function getProviderList(ProviderSpecification $spec, $per_page)
    {
        $data = [];
        $provider_repository = new ProviderRepository();
        $paginate = $provider_repository->search($spec, $per_page);
        $provider_service = new ProviderService();
        $provider_picture_repository = new ProviderPictureRepository();
        $resource_repository = new ResourceRepository();
        $province_repository = new ProvinceRepository();
        $city_repository = new CityRepository();
        $items = [];
        /**
         * @var int                  $key
         * @var ProviderEntity       $provider_product_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $provider_product_entity) {
            $item = $provider_product_entity->toArray();
            $item['provider_main_category'] = $provider_service->getProductCategory($item['id']);
            $provider_picture_entities = $provider_picture_repository->getImageByProviderId($item['id']);
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
            $province_id = $item['produce_province_id'] ?? 0;
            $city_id = $item['produce_city_id'] ?? 0;
            $item['produce_province_name'] = $province_repository->fetch($province_id)->name ?? '';
            $item['produce_city_name'] = $city_repository->fetch($city_id)->name ?? '';
            $item['logo_images'] = collect($images)->where('type', ProviderImageType::LOGO)->toArray();
            $items[] = $item;
        }
        $data['paginate'] = $paginate;
        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }


    public function getProviderDetailById($provider_id)
    {
        $data = [];
        $provider_service = new ProviderService();

        $province_repository = new ProvinceRepository();
        $city_repository = new CityRepository();

        if ($provider = $provider_service->getProviderInfo($provider_id)) {
            $data = $provider;

            //旧的经营模式
            $operation_mode_types = OperationModelType::acceptableEnums();
            $data['operation_mode'] = $operation_mode_types[$provider['operation_mode']] ?? '';

            //新的经营模式
            $provider_management_types = ProviderManagementType::acceptableEnums();
            $management_type_names = [];
            foreach ($data['provider_management_modes'] as $management_type) {
                $management_type_names[] = $provider_management_types[$management_type] ?? '';
            }
            $data['provider_management_type_name'] = implode('、', $management_type_names);


            $provider_propaganda_service = new ProviderPropagandaService();
            $provider_propagandaes = $provider_propaganda_service->getProviderPropagandaByProviderIdAndStatus(
                $provider_id,
                ProviderPropagandaStatus::STATUS_PASS
            );
            $data['product_category_names'] = $provider_service->getProductCategory($provider_id);

            $data['provider_main_category_name'] = $provider_service->getProviderCategoryNameById($provider_id);
            /** @var ProvinceEntity $province_entity */
            $province_entity = $province_repository->fetch($provider['province_id']);
            $province = [];
            if (isset($province_entity)) {
                $province = $province_entity->toArray();
            }
            $data['province'] = $province;
            /** @var CityEntity $city_entity */
            $city_entity = $city_repository->fetch($provider['city_id']);
            $city = [];
            if (isset($city_entity)) {
                $city = $city_entity->toArray();
            }
            $data['city'] = $city;

            //公司类型
            $provider_company_types = ProviderCompanyType::acceptableEnums();
            $data['provider_company_type_name'] = $provider_company_types[$provider['company_type']] ?? '';

            $data['logo_url'] = '/www/images/provider/default_logo.png';
            $logo_image = current($provider['logo_images']);
            if (!empty($logo_image)) {
                $data['logo_url'] = $logo_image['url'];
            }

            foreach ($provider_propagandaes as $provider_propaganda) {
                $item = [];
                $item['image'] = $provider_propaganda['url'] ?? '';
                $item['link'] = $provider_propaganda['link'] ?? '';
                $data['publicity'][] = $item;
            }
        }
        return $data;
    }


    public function getWebFormatProviders($category_id, $limit)
    {
        $data = [];
        $provider_rank_category_service = new ProviderRankCategoryService();
        $providers = $provider_rank_category_service->getProviderRankByCategoryId($category_id, 20);
        if (!empty($providers)) {
            $data['1-10'] = array_slice($providers, 0, 10);
            $data['11-20'] = array_slice($providers, 10, 10);
        }
        return $data;
    }


}
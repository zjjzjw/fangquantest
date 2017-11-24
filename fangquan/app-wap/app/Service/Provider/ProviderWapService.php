<?php

namespace App\Wap\Service\Provider;

use App\Service\Provider\ProviderRankCategoryService;
use App\Src\Provider\Domain\Model\ProviderImageType;
use App\Src\Provider\Domain\Model\ProviderPictureEntity;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Src\Provider\Infra\Repository\ProviderCertificateRepository;
use App\Src\Provider\Domain\Model\ProviderCertificateEntity;
use App\Src\Provider\Domain\Model\ProviderCertificateStatus;
use App\Src\Provider\Domain\Model\ProviderPropagandaStatus;
use App\Src\Provider\Domain\Model\ProviderCertificateType;
use App\Src\Provider\Domain\Model\ProviderManagementType;
use App\Src\Provider\Infra\Repository\ProviderPictureRepository;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Provider\Domain\Model\ProviderCompanyType;
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

class ProviderWapService
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
        $provider_mode_types = ProviderCompanyType::acceptableEnums();
        $provider_service = new ProviderService();

        $items = [];
        /**
         * @var int                  $key
         * @var ProviderEntity       $provider_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $provider_entity) {
            $item = $provider_entity->toArray();
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

            /** @var CityEntity $city_entity */
            $city_entity = $city_repository->fetch($provider_entity->city_id);
            if (isset($city_entity)) {
                $item['city_name'] = $city_entity->name;
            }

            $item['company_type_name'] = $provider_mode_types[$item['company_type']] ?? '';
            $item['provider_main_categories'] = $provider_service->getProviderMainCategory($provider_entity->id);
            $province_id = $item['produce_province_id'] ?? 0;
            $city_id = $item['produce_city_id'] ?? 0;
            $item['produce_province_name'] = $province_repository->fetch($province_id)->name ?? '';
            $item['produce_city_name'] = $city_repository->fetch($city_id)->name ?? '';
            $item['logo_images'] = collect($images)->where('type', ProviderImageType::LOGO)->toArray();

            $item['logo_url'] = '/www/images/provider/default_logo.png';
            if (!empty($item['logo_images'])) {
                $item['logo_url'] = current($item['logo_images'])['url'] ?? '/www/images/provider/default_logo.png';
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


    public function getProviderDetailById($provider_id)
    {

        $data = [];
        $provider_management_mode_names=[];
        $provider_service = new ProviderService();
        if ($provider = $provider_service->getProviderInfo($provider_id)) {
            $data = $provider;
            $operation_mode_types = OperationModelType::acceptableEnums();
            $provider_mode_types = ProviderCompanyType::acceptableEnums();
            $provider_management_types = ProviderManagementType::acceptableEnums();
            $data['operation_mode'] = $operation_mode_types[$provider['operation_mode']] ?? '';
            $data['company_type_name'] = $provider_mode_types[$provider['company_type']] ?? '';

            $provider_propaganda_service = new ProviderPropagandaService();
            $provider_propagandaes = $provider_propaganda_service->getProviderPropagandaByProviderIdAndStatus(
                $provider_id,
                ProviderPropagandaStatus::STATUS_PASS
            );
            foreach($data['provider_management_modes'] as $provider_management_mode){
                $provider_management_mode_names[] = $provider_management_types[$provider_management_mode] ?? '';
            }
            $data['provider_management_mode_names']=implode(',',$provider_management_mode_names);
            $data['product_category_names'] = $provider_service->getProviderMainCategory($provider_id);
            foreach ($provider_propagandaes as $provider_propaganda) {
                $item = [];
                $item['image'] = $provider_propaganda['url'] ?? '';
                $item['link'] = $provider_propaganda['link'] ?? '';
                $data['publicity'][] = $item;
            }
        }

        return $data;
    }


}
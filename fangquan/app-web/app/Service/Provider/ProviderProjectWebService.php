<?php

namespace App\Web\Service\Provider;

use App\Src\Provider\Domain\Model\MeasureunitEntity;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderProjectSpecification;
use App\Src\Provider\Domain\Model\ProviderProjectStatus;
use App\Src\Provider\Infra\Repository\MeasureunitRepository;
use App\Src\Provider\Infra\Repository\ProviderProjectRepository;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use App\Src\Provider\Domain\Model\ProviderProjectEntity;
use App\Src\Surport\Infra\Repository\CityRepository;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Src\Surport\Domain\Model\CityEntity;


class ProviderProjectWebService
{
    /**
     * @param ProviderProjectSpecification $spec
     * @param int                          $per_page
     * @return array
     */
    public function getProviderProjectList(ProviderProjectSpecification $spec, $per_page = 20)
    {
        $data = [];
        $items = [];
        $provider_project_repository = new ProviderProjectRepository();
        $provider_repository = new ProviderRepository();
        $resource_repository = new ResourceRepository();
        $province_repository = new ProvinceRepository();
        $city_repository = new CityRepository();
        $measureunit_repository = new MeasureunitRepository();
        $provider_project_status = ProviderProjectStatus::acceptableEnums();

        $paginate = $provider_project_repository->search($spec, $per_page);

        /**
         * @var int                   $key
         * @var ProviderProjectEntity $provider_project_entity
         * @var LengthAwarePaginator  $paginate
         */
        foreach ($paginate as $key => $provider_project_entity) {
            $provider_project_picture_ids = [];
            $item = $provider_project_entity->toArray();

            /** @var CityEntity $city_entity */
            $city_entity = $city_repository->fetch($provider_project_entity->city_id);
            if (isset($city_entity)) {
                $item['city'] = $city_entity->toArray();
            }
            /** @var ProvinceEntity $province_entity */
            $province_entity = $province_repository->fetch($provider_project_entity->province_id);
            if (isset($province_entity)) {
                $item['province'] = $province_entity->toArray();
            }
            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($provider_project_entity->provider_id);
            if (isset($provider_entity)) {
                $item['brand_name'] = $provider_entity->brand_name;
            }
            $project_picture_ids = $item['provider_project_picture_ids'] ?? [];

            $resource_entities = $resource_repository->getResourceUrlByIds($project_picture_ids);
            /** @var ResourceEntity $resource_entity */
            foreach ($resource_entities as $resource_entity) {
                $provider_project_picture_id = [];
                $provider_project_picture_id['image_id'] = $resource_entity->id;
                $provider_project_picture_id['url'] = $resource_entity->url;
                $provider_project_picture_ids[] = $provider_project_picture_id;
            }
            $item['provider_project_pictures'] = $provider_project_picture_ids;
            $item['thumb_pictures'] = current($provider_project_picture_ids)['url'] ?? '';

            foreach ($item['provider_project_products'] as &$provider_project_product) {
                /** @var MeasureunitEntity $measureunit_entity */
                $measureunit_entity = $measureunit_repository->fetch($provider_project_product['measureunit_id'] ?? 0);
                $provider_project_product['measureunit'] = $measureunit_entity->name ?? '';
            }

            $item['status_name'] = $provider_project_status[$provider_project_entity->status];

            $items[] = $item;
        }

        $data['paginate'] = $paginate;
        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }


}


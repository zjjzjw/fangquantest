<?php namespace App\Service\Provider;

use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderProjectSpecification;
use App\Src\Provider\Domain\Model\ProviderProjectStatus;
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


class ProviderProjectService
{
    /**
     * @param ProviderProjectSpecification $spec
     * @param int                          $per_page
     * @return array
     */
    public function getProviderProjectList(ProviderProjectSpecification $spec, $per_page = 20)
    {
        $data = [];
        $provider_project_repository = new ProviderProjectRepository();
        $provider_repository = new ProviderRepository();
        $resource_repository = new ResourceRepository();
        $province_repository = new ProvinceRepository();
        $city_repository = new CityRepository();
        $provider_project_status = ProviderProjectStatus::acceptableEnums();
        $paginate = $provider_project_repository->search($spec, $per_page);

        $items = [];
        /**
         * @var int                   $key
         * @var ProviderProjectEntity $provider_project_entity
         * @var LengthAwarePaginator  $paginate
         */
        foreach ($paginate as $key => $provider_project_entity) {
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
            $thumb_image_id = $item['provider_project_picture_ids'] ? current($item['provider_project_picture_ids']) : 0;
            /** @var ResourceEntity $resource_entity */
            $resource_entity = current($resource_repository->getResourceUrlByIds($thumb_image_id));
            if ($resource_entity) {
                $item['thumb_url'] = $resource_entity->url ?? '';
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

    /**
     * @param $id
     * @return array
     */
    public function getProviderProjectInfo($id)
    {
        $data = [];
        $provider_project_repository = new ProviderProjectRepository();
        $resource_repository = new ResourceRepository();
        $province_repository = new ProvinceRepository();
        $provider_repository = new ProviderRepository();
        $city_repository = new CityRepository();

        /** @var ProviderProjectEntity $provider_project_entity */
        $provider_project_entity = $provider_project_repository->fetch($id);
        if (isset($provider_project_entity)) {
            $data = $provider_project_entity->toArray();
            $provider_project_picture_ids = [];
            $image_ids = $provider_project_entity->provider_project_picture_ids;
            $resource_entities = $resource_repository->getResourceUrlByIds($image_ids);
            /** @var ResourceEntity $resource_entity */
            foreach ($resource_entities as $resource_entity) {
                $provider_project_picture_id = [];
                $provider_project_picture_id['image_id'] = $resource_entity->id;
                $provider_project_picture_id['url'] = $resource_entity->url;
                $provider_project_picture_ids[] = $provider_project_picture_id;
            }
            $data['provider_project_pictures'] = $provider_project_picture_ids;

            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($provider_project_entity->provider_id);
            if (isset($provider_entity)) {
                $data['brand_name'] = $provider_entity->brand_name;
                $data['company_name'] = $provider_entity->company_name;
            }
            /** @var CityEntity $city_entity */
            $city_entity = $city_repository->fetch($provider_project_entity->city_id);
            if (isset($city_entity)) {
                $data['city'] = $city_entity->toArray();
            }
            /** @var ProvinceEntity $province_entity */
            $province_entity = $province_repository->fetch($provider_project_entity->province_id);
            if (isset($province_entity)) {
                $data['province'] = $province_entity->toArray();
            }
        }
        return $data;
    }


}


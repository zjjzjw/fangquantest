<?php

namespace App\Service\Provider;


use App\Src\Provider\Domain\Model\ProviderAduitdetailsEntity;
use App\Src\Provider\Domain\Model\ProviderAduitdetailsSpecification;
use App\Src\Provider\Domain\Model\ProviderAduitdetailsType;
use App\Src\Provider\Infra\Repository\ProviderAduitdetailsRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProviderAduitdetailsService
{
    /**
     * @param ProviderAduitdetailsSpecification $spec
     * @param int                               $per_page
     * @return array
     */
    public function getProviderAduitdetailsList(ProviderAduitdetailsSpecification $spec, $per_page = 10)
    {

        $data = [];
        $provider_Aduitdetails_repository = new ProviderAduitdetailsRepository();
        $resource_repository = new ResourceRepository();
        $paginate = $provider_Aduitdetails_repository->search($spec, $per_page);

        $items = [];
        /**
         * @var int                        $key
         * @var ProviderAduitdetailsEntity $ProviderAduitdetailsEntity
         * @var LengthAwarePaginator       $paginate
         */
        foreach ($paginate as $key => $provider_Aduitdetails_entity) {
            $item = $provider_Aduitdetails_entity->toArray();
            $ProviderAduitdetailsType = ProviderAduitdetailsType::acceptableEnums();
            $item['type'] = $ProviderAduitdetailsType[$provider_Aduitdetails_entity->type] ?? '';
            $items[] = $item;
        }

        $data['paginate'] = $paginate;
        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }

    public function getProviderAduitdetailsInfo($id)
    {
        $data = [];
        $ProviderAduitdetailsRepository = new ProviderAduitdetailsRepository();
        $resource_repository = new ResourceRepository();

        /** @var ProviderAduitdetailsEntity $provider_aduitdetails_entity */
        $provider_Aduitdetails_entity = $ProviderAduitdetailsRepository->fetch($id);
        if (isset($provider_Aduitdetails_entity)) {
            $data = $provider_Aduitdetails_entity->toArray();
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($provider_Aduitdetails_entity->link);
            if (isset($resource_entity)) {
                $images = [];
                $image = [];
                $image['image_id'] = $provider_Aduitdetails_entity->link;
                $image['url'] = '/www/images/file.png';
                $images[] = $image;
                $data['images'] = $images;
                $data['image_url'] = $resource_entity->url;
            }
        }
        return $data;
    }

    /**
     * @param $provider_id
     * @return array
     */
    public function getProviderAduitdetailsByProviderId($provider_id)
    {
        $items = [];
        $provider_aduitdetails_repository = new ProviderAduitdetailsRepository();
        $resource_repository = new ResourceRepository();
        $provider_aduitdetails_entities = $provider_aduitdetails_repository->getProviderAduitdetailsByProviderId($provider_id);
        /** @var ProviderAduitdetailsEntity $provider_aduitdetails_entity */
        foreach ($provider_aduitdetails_entities as $provider_aduitdetails_entity) {
            $item = [];
            $item = $provider_aduitdetails_entity->toArray();
            $resource_entity = $resource_repository->getResourceUrlByIds($item['link']);
            $aduitdetails_type_array = ProviderAduitdetailsType::acceptableEnums();
            $item['type_name'] = $aduitdetails_type_array[$provider_aduitdetails_entity->type] ?? '';
            $item['link_url'] = current($resource_entity)->url ?? '';
            $items[] = $item;
        }

        return $items;
    }


}


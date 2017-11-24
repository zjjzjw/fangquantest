<?php

namespace App\Service\Provider;


use App\Src\Provider\Domain\Model\ProviderAduitdetailsEntity;
use App\Src\Provider\Domain\Model\ProviderAduitdetailsSpecification;
use App\Src\Provider\Domain\Model\ProviderPropagandaSpecification;
use App\Src\Provider\Domain\Model\ProviderPropagandaStatus;
use App\Src\Provider\Infra\Repository\ProviderPropagandaRepository;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProviderPropagandaService
{
    /**
     * @param ProviderAduitdetailsSpecification $spec
     * @param int                               $per_page
     * @return array
     */
    public function getProviderPropagandaList(ProviderPropagandaSpecification $spec, $per_page = 10)
    {

        $data = [];
        $provider_propaganda_repository = new ProviderPropagandaRepository();
        $resource_repository = new ResourceRepository();
        $provider_repository = new ProviderRepository();
        $paginate = $provider_propaganda_repository->search($spec, $per_page);

        $items = [];
        /**
         * @var int                        $key
         * @var ProviderAduitdetailsEntity $provider_propaganda_entity
         * @var LengthAwarePaginator       $paginate
         */
        foreach ($paginate as $key => $provider_propaganda_entity) {
            $item = $provider_propaganda_entity->toArray();
            $providerPropagandaStatus = ProviderPropagandaStatus::acceptableEnums();
            $item['status_name'] = $providerPropagandaStatus[$provider_propaganda_entity->status] ?? '';
            $resource_entity = $resource_repository->fetch($provider_propaganda_entity->image_id);
            if (isset($resource_entity)) {
                $item['image_url'] = $resource_entity->url;
            }
            $provider_entity = $provider_repository->fetch($provider_propaganda_entity->provider_id);
            if (isset($provider_entity)) {
                $item['brand_name'] = $provider_entity->brand_name;
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

    public function getProviderPropagandaInfo($id)
    {
        $data = [];
        $ProviderPropagandaRepository = new ProviderPropagandaRepository();
        $resource_repository = new ResourceRepository();
        $provider_repository = new ProviderRepository();

        /** @var ProviderAduitdetailsEntity $provider_aduitdetails_entity */
        $provider_propaganda_entity = $ProviderPropagandaRepository->fetch($id);
        if (isset($provider_propaganda_entity)) {
            $data = $provider_propaganda_entity->toArray();
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($provider_propaganda_entity->image_id);
            if (isset($resource_entity)) {
                $images = [];
                $image = [];
                $image['image_id'] = $provider_propaganda_entity->image_id;
                $image['url'] = $resource_entity->url;
                $images[] = $image;
                $data['images'] = $images;
            }
            $provider_entity = $provider_repository->fetch($provider_propaganda_entity->provider_id);
            if (isset($provider_entity)) {
                $data['brand_name'] = $provider_entity->brand_name;
            }
        }
        return $data;
    }

    public function getProviderPropagandaByProviderIdAndStatus($provider_id, $status = ProviderPropagandaStatus::STATUS_PASS)
    {
        $items = [];
        $provider_propaganda_repository = new  ProviderPropagandaRepository();
        $resource_repository = new ResourceRepository();
        $provider_propaganda_entities = $provider_propaganda_repository->getProviderProviderPropagandaByProviderId(
            $provider_id, $status
        );
        foreach ($provider_propaganda_entities as $provider_propaganda_entity) {
            $item = $provider_propaganda_entity->toArray();
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($provider_propaganda_entity->image_id);
            if (isset($resource_entity)) {
                $item['url'] = $resource_entity->url;
            }
            $items[] = $item;
        }
        return $items;
    }



}


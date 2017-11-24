<?php

namespace App\Service\Provider;


use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderFriendEntity;
use App\Src\Provider\Domain\Model\ProviderFriendSpecification;
use App\Src\Provider\Domain\Model\ProviderFriendStatus;
use App\Src\Provider\Infra\Repository\ProviderFriendRepository;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProviderFriendService
{
    /**
     * @param ProviderFriendSpecification $spec
     * @param int                         $per_page
     * @return array
     */
    public function getProviderFriendList(ProviderFriendSpecification $spec, $per_page = 10)
    {

        $data = [];
        $provider_friend_repository = new ProviderFriendRepository();
        $resource_repository = new ResourceRepository();
        $provider_repository = new ProviderRepository();
        $provider_friend_status = ProviderFriendStatus::acceptableEnums();
        $paginate = $provider_friend_repository->search($spec, $per_page);

        $items = [];
        /**
         * @var int                  $key
         * @var ProviderFriendEntity $ProviderAduitdetailsEntity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $provider_friend_entity) {
            $item = $provider_friend_entity->toArray();
            $item['status_name'] = $provider_friend_status[$provider_friend_entity->status] ?? '';
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($provider_friend_entity->logo);
            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($provider_friend_entity->provider_id);
            if (isset($resource_entity)) {
                $item['image_url'] = $resource_entity->url;
            }
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

    public function getProviderFriendInfo($id)
    {
        $data = [];
        $ProviderFriendRepository = new ProviderFriendRepository();
        $resource_repository = new ResourceRepository();
        $provider_repository = new ProviderRepository();
        /** @var ProviderFriendEntity $provider_friend_entity */
        $provider_friend_entity = $ProviderFriendRepository->fetch($id);
        if (isset($provider_friend_entity)) {
            $data = $provider_friend_entity->toArray();
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($provider_friend_entity->logo);
            if (isset($resource_entity)) {
                $images = [];
                $image = [];
                $image['image_id'] = $provider_friend_entity->logo;
                $image['url'] = $resource_entity->url;
                $images[] = $image;
                $data['logo'] = $images;
            }

            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($provider_friend_entity->provider_id);
            if (isset($provider_entity)) {
                $data['company_name'] = $provider_entity->company_name;
                $data['brand_name'] = $provider_entity->brand_name;
            }
        }
        return $data;
    }


    /**
     * @param $provider_id
     * @return array
     */
    public function getProviderFriendByProviderId($provider_id)
    {
        $data = [];
        $ProviderFriendRepository = new ProviderFriendRepository();
        $resource_repository = new ResourceRepository();
        /** @var ProviderFriendEntity $provider_friend_entity */
        $provider_friend_entities = $ProviderFriendRepository->getProviderFriendByProviderAndStatus($provider_id, ProviderFriendStatus::STATUS_PASS);

        foreach ($provider_friend_entities as $key => $provider_friend_entity) {
            $data[] = $provider_friend_entity->toArray();
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($provider_friend_entity->logo);
            $data[$key]['logo_url'] = $resource_entity->url ?? '';
        }

        return $data;
    }


}


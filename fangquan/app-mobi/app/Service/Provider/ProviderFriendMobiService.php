<?php

namespace App\Mobi\Service\Provider;


use App\Src\Provider\Domain\Model\ProviderFriendEntity;
use App\Src\Provider\Domain\Model\ProviderNewsEntity;
use App\Src\Provider\Infra\Repository\ProviderFriendRepository;
use App\Src\Provider\Infra\Repository\ProviderNewsRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;

class ProviderFriendMobiService
{
    public function getProviderFriendByProviderIdAndStatus($provider_id, $status)
    {
        $items = [];
        $provider_friend_repository = new ProviderFriendRepository();
        $provider_friend_entities = $provider_friend_repository->getProviderFriendByProviderAndStatus(
            $provider_id, $status);
        $resource_repository = new ResourceRepository();
        /** @var ProviderFriendEntity $provider_friend_entity */
        foreach ($provider_friend_entities as $provider_friend_entity) {
            $item = [];
            $item['id'] = $provider_friend_entity->id;
            $item['name'] = $provider_friend_entity->name;
            $item['link'] = $provider_friend_entity->link;
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($provider_friend_entity->logo);
            if (isset($resource_entity)) {
                $item['logo'] = $resource_entity->url;
            } else {
                $item['logo'] = '';
            }
            $items[] = $item;
        }
        return $items;
    }


    public function getProviderFriendById($id)
    {
        $data = [];
        $provider_friend_repository = new ProviderFriendRepository();
        $resource_repository = new ResourceRepository();
        /** @var ProviderFriendEntity $provider_friend_entity */
        $provider_friend_entity = $provider_friend_repository->fetch($id);
        if (isset($provider_friend_repository)) {
            $data['id'] = $provider_friend_entity->id;
            $data['name'] = $provider_friend_entity->name;
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($provider_friend_entity->logo);
            if (isset($resource_entity)) {
                $item['logo'] = $resource_entity->url;
            } else {
                $item['logo'] = '';
            }
            $data['link'] = $provider_friend_entity->link;
        }
        return $data;
    }
}
<?php

namespace App\Mobi\Service\Provider;


use App\Src\Provider\Domain\Model\ProviderNewsEntity;
use App\Src\Provider\Infra\Repository\ProviderNewsRepository;

class ProviderNewsMobiService
{
    public function getProviderNewsByProviderIdAndStatus($provider_id, $status)
    {
        $items = [];
        $provider_news_repository = new ProviderNewsRepository();
        $provider_news_entities = $provider_news_repository->getProviderNewsByProviderId($provider_id, $status);
        /** @var ProviderNewsEntity $provider_news_entity */
        foreach ($provider_news_entities as $provider_news_entity) {
            $item = [];
            $item['id'] = $provider_news_entity->id;
            $item['title'] = $provider_news_entity->title;
            $item['time'] = $provider_news_entity->created_at->format('Y-m-d');
            $items[] = $item;
        }
        return $items;
    }


    public function getProviderNewsById($id)
    {
        $data = [];
        $provider_news_repository = new ProviderNewsRepository();
        /** @var ProviderNewsEntity $provider_news_entity */
        $provider_news_entity = $provider_news_repository->fetch($id);
        if (isset($provider_news_entity)) {
            $data['title'] = $provider_news_entity->title;
            $data['time'] = $provider_news_entity->created_at->toDateTimeString();
            $data['content'] = $provider_news_entity->content;
        }
        return $data;
    }
}
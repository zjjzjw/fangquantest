<?php namespace App\Service\Provider;

use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderNewsEntity;
use App\Src\Provider\Domain\Model\ProviderNewsSpecification;
use App\Src\Provider\Domain\Model\ProviderNewsStatus;
use App\Src\Provider\Infra\Repository\ProviderNewsRepository;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProviderNewsService
{
    /**
     * @param ProviderNewsSpecification $spec
     * @param int                       $per_page
     * @return array
     */
    public function getProviderNewsList(ProviderNewsSpecification $spec, $per_page = 20)
    {
        $data = [];
        $provider_news_repository = new ProviderNewsRepository();
        $provider_repository = new ProviderRepository();
        $paginate = $provider_news_repository->search($spec, $per_page);
        $provider_news_status = ProviderNewsStatus::acceptableEnums();
        $items = [];
        /**
         * @var int                  $key
         * @var ProviderNewsEntity   $provider_news_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $provider_news_entity) {
            $item = $provider_news_entity->toArray();
            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($item['provider_id']);
            if (isset($provider_entity)) {
                $item['brand_name'] = $provider_entity->brand_name;
            }
            $item['status_name'] = $provider_news_status[$item['status']];
            $item['time_ago'] = time_ago($item['created_at']);
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
    public function getProviderNewsInfo($id)
    {
        $data = [];
        $provider_news_repository = new ProviderNewsRepository();
        $provider_repository = new ProviderRepository();

        /** @var ProviderNewsEntity $provider_news_entity */
        $provider_news_entity = $provider_news_repository->fetch($id);
        if (isset($provider_news_entity)) {
            $data = $provider_news_entity->toArray();
            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($data['provider_id']);
            if (isset($provider_entity)) {
                $data['company_name'] = $provider_entity->company_name;
                $data['brand_name'] = $provider_entity->brand_name;
            }
        }
        return $data;
    }

    /**
     * @param     $provider_id
     * @param int $status
     * @param     $limit
     * @return array
     */
    public function getProviderNewsByProviderId($provider_id, $status = ProviderNewsStatus::STATUS_PASS, $limit)
    {
        $items = [];
        $provider_news_repository = new ProviderNewsRepository();
        $provider_news_entities = $provider_news_repository->getProviderNewsByProviderId($provider_id, $status, $limit);
        /** @var ProviderNewsEntity $provider_news_entity */
        foreach ($provider_news_entities as $provider_news_entity) {
            $item = [];
            $item['id'] = $provider_news_entity->id;
            $item['title'] = $provider_news_entity->title;
            $item['content'] = $provider_news_entity->content;
            $item['created_at'] = $provider_news_entity->created_at->format('Y.m.d');

            $items[] = $item;
        }

        return $items;
    }

}


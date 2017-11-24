<?php

namespace App\Web\Service\Developer;

use App\Src\Developer\Domain\Model\DeveloperEntity;
use App\Src\Developer\Domain\Model\DeveloperSpecification;
use App\Src\Developer\Domain\Model\DeveloperStatus;
use App\Src\Developer\Infra\Repository\DeveloperRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class DeveloperWebService
{
    public function getDeveloperList(DeveloperSpecification $spec, $per_page)
    {
        $data = [];
        $items = [];
        $developer_repository = new DeveloperRepository();
        $paginate = $developer_repository->search($spec, $per_page);
        $resource_repository = new ResourceRepository();
        /** @var DeveloperEntity $developer_entity */
        foreach ($paginate as $developer_entity) {
        }
        return $data;
    }

    public function geHotDeveloperList()
    {
        $items = [];
        $developer_repository = new DeveloperRepository();
        $developer_entities = $developer_repository->geHotDeveloperList();
        /** @var DeveloperEntity $developer_entity */
        foreach ($developer_entities as $developer_entity) {
            $item = [];
            $item['id'] = $developer_entity->id;
            $item['name'] = $developer_entity->name;
            $logo = $developer_entity->logo;
            $item['logo_url'] = '/www/images/provider/default_logo.png';
            $item['logo'] = $logo;
            if ($logo) {
                $resource_repository = new ResourceRepository();
                $resource_entities = $resource_repository->getResourceUrlByIds($logo);
                /** @var ResourceEntity $resource_entity */
                foreach ($resource_entities as $resource_entity) {
                    $item['logo_url'] = $resource_entity->url;
                }
            }
            $items[] = $item;
        }
        return $items;
    }


    public function getAllDeveloperList()
    {
        $items = [];
        $developer_repository = new DeveloperRepository();
        $developer_entities = $developer_repository->getAllDeveloperList(DeveloperStatus::YES);
        /** @var DeveloperEntity $developer_entity */
        foreach ($developer_entities as $developer_entity) {
            $item = $developer_entity->toArray();
            $item['logo_url'] = '/www/images/provider/default_logo.png';
            if ($developer_entity->logo) {
                $resource_repository = new ResourceRepository();
                $resource_entities = $resource_repository->getResourceUrlByIds($developer_entity->logo);
                /** @var ResourceEntity $resource_entity */
                foreach ($resource_entities as $resource_entity) {
                    $item['logo_url'] = $resource_entity->url;
                }
            }
            $items[] = $item;
        }
        return $items;
    }

    public function formatDevelopersForWeb($providers)
    {
        $items = [];
        $i = 0;
        while (!empty(array_slice($providers, $i * 10, 10))) {
            $items[$i] = array_slice($providers, $i * 10, 10);
            $i++;
        }
        return $items;
    }


}
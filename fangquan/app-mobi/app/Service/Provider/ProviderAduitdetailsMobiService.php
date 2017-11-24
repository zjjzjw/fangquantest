<?php

namespace App\Mobi\Service\Provider;


use App\Src\Provider\Domain\Model\ProviderAduitdetailsEntity;
use App\Src\Provider\Infra\Repository\ProviderAduitdetailsRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;

class ProviderAduitdetailsMobiService
{


    /**
     * 验厂报告列表
     * @param $id
     * @return array
     */
    public function getProviderAduitdetailsByProviderId($id)
    {
        $data = [];
        $provider_aduitdetails_repository = new ProviderAduitdetailsRepository();
        /** @var ProviderAduitdetailsEntity $provider_aduitdetails_entity */
        $provider_anuitdetails_entity = $provider_aduitdetails_repository->getProviderAduitdetailsByProviderId($id);
        foreach ($provider_anuitdetails_entity as $value) {
            $resource_repository = new ResourceRepository();
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($value->link);
            $aduitdetails['id'] = $value->id;
            $aduitdetails['name'] = $value->name;
            $aduitdetails['link'] = $resource_repository->getDownloadUrl($resource_entity, ['download/']);
            $data[] = $aduitdetails;
        }
        return $data;
    }


    /**
     * 验厂报告详情
     * @param $id
     * @return array
     */
    public function getProviderAduitdetailsById($id)
    {
        $data = [];
        $provider_aduitdetails_repository = new ProviderAduitdetailsRepository();
        $resource_repository = new ResourceRepository();
        /** @var ProviderAduitdetailsEntity $provider_anuitdetails_entity */
        $provider_anuitdetails_entity = $provider_aduitdetails_repository->fetch($id);
        if (isset($provider_anuitdetails_entity)) {
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($provider_anuitdetails_entity->link);
            $data['id'] = $id;
            $data['name'] = $provider_anuitdetails_entity->name;
            if (isset($resource_entity)) {
                $file_size = $resource_repository->getUrlSize($resource_entity->hash);
                $data['size'] = ceil($file_size / 1024) . 'KB';
                if ($data['size'] > 1024) {
                    $data['size'] = ceil($data['size'] / 1024) . 'MB';
                }
            }
        }
        return $data;
    }


}
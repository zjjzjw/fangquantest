<?php

namespace App\Service\Brand;


use App\Src\Brand\Domain\Model\BrandSaleAreaType;
use App\Src\Brand\Domain\Model\BrandSaleEntity;
use App\Src\Brand\Domain\Model\BrandSaleSpecification;
use App\Src\Brand\Domain\Model\BrandServiceEntity;
use App\Src\Brand\Domain\Model\ServiceType;
use App\Src\Brand\Infra\Repository\BrandSaleRepository;
use App\Src\Brand\Infra\Repository\BrandServiceRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;

class BrandServiceService
{
    /**
     * @param $id
     * @return array
     */
    public function getBrandServiceInfo($id)
    {
        $data = [];
        $brand_service_repository = new BrandServiceRepository();
        $resource_repository = new ResourceRepository();
        /** @var BrandServiceEntity $brand_service_entity */
        $brand_service_entity = $brand_service_repository->getBrandServiceByBrandId($id);
        if (isset($brand_service_entity)) {
            $data = $brand_service_entity->toArray();
            //得到缩略图
            /** @var ResourceEntity $resource_entity */
            $files = $brand_service_entity->file;

            $resource_entities = $resource_repository->getResourceUrlByIds($files);
            /** @var ResourceEntity $resource_entity */
            $chatfiles = [];
            foreach ($resource_entities as $resource_entity) {
                $chatfile['url'] = $resource_entity->url;
                $chatfile['image_id'] = $resource_entity->id;
                $chatfiles[] = $chatfile;
            }
            $data['files'] = $chatfiles;

            $service_model_names = [];
            $service_types = ServiceType::acceptableEnums();
            foreach ($data['service_model'] as $type) {
                $service_model_names[] = $service_types[$type] ?? '';
            }
            $data['service_model_name'] = implode('、', $service_model_names);
        }
        return $data;
    }

}




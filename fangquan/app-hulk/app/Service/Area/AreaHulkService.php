<?php

namespace App\Hulk\Service\Area;


use App\Src\Surport\Domain\Model\ChinaAreaEntity;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Infra\Repository\ChinaAreaRepository;
use App\Src\Surport\Infra\Repository\ProvinceRepository;


class AreaHulkService
{
    public function getChinaAreaList()
    {
        $data = [];
        $china_area_repository = new ChinaAreaRepository();
        $province_repository = new ProvinceRepository();
        $china_area_entities = $china_area_repository->all();
        /** @var ChinaAreaEntity $china_area_entity */
        foreach ($china_area_entities as $china_area_entity) {
            $item['id'] = $china_area_entity->id;
            $item['value'] = $china_area_entity->name;
            $province_entities = $province_repository->getProvinceByAreaId($china_area_entity->id);
            $province = [];
            /** @var ProvinceEntity $province_entity */
            foreach ($province_entities as $province_entity) {
                $province_data['id'] = $province_entity->id;
                $province_data['value'] = $province_entity->name;
                $province[$province_entity->id] = $province_data;
            }

            $item['nodes'] = $province;
            $data[$china_area_entity->id] = $item;
        }
        return $data;
    }
}


<?php

namespace App\Wap\Service\Surport;

use App\Src\Surport\Domain\Model\ChinaAreaEntity;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Infra\Repository\ChinaAreaRepository;
use App\Src\Surport\Infra\Repository\ProvinceRepository;

class ChinaAreaWebService
{
    public function getChinaAreaWithProvince()
    {
        $items = [];
        $area_repository = new ChinaAreaRepository();
        $area_entities = $area_repository->all();
        $province_repository = new ProvinceRepository();
        $province_entities = $province_repository->all();
        /** @var ChinaAreaEntity $area_entity */
        foreach ($area_entities as $area_entity) {
            $item = [];
            $item['id'] = $area_entity->id;
            $item['name'] = $area_entity->name;
            $item['provinces'] = [];
            /** @var ProvinceEntity $province_entity */
            foreach ($province_entities as $province_entity) {
                if ($province_entity->area_id == $area_entity->id) {
                    $province = [];
                    $province['id'] = $province_entity->id;
                    $province['name'] = $province_entity->name;
                    $item['provinces'][] = $province;
                }
            }
            $items[] = $item;
        }
        return $items;
    }

}
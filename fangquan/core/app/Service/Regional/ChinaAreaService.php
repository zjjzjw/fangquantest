<?php

namespace App\Service\Regional;


use App\Src\Surport\Domain\Model\ChinaAreaEntity;
use App\Src\Surport\Domain\Model\ChinaAreaSpecification;
use App\Src\Surport\Infra\Repository\ChinaAreaRepository;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Infra\Repository\ProvinceRepository;

use Illuminate\Pagination\LengthAwarePaginator;

class ChinaAreaService
{
    /**
     * @param ChinaAreaSpecification $spec
     * @param int                    $per_page
     * @return array
     */
    public function getChinaAreaList(ChinaAreaSpecification $spec, $per_page)
    {
        $data = [];
        $china_area_repository = new ChinaAreaRepository();
        $paginate = $china_area_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var int                  $key
         * @var ChinaAreaEntity      $china_area_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $china_area_entity) {
            $item = $china_area_entity->toArray();
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
    public function getChinaAreaInfo($id)
    {
        $data = [];
        $china_area_repository = new ChinaAreaRepository();
        $china_area_entity = $china_area_repository->fetch($id);
        if (isset($china_area_entity)) {
            $data = $china_area_entity->toArray();
        }
        return $data;
    }

    public function getAllChinaArea()
    {
        $china_area_repository = new ChinaAreaRepository();
        $china_area_entities = $china_area_repository->all();
        $items = [];
        foreach ($china_area_entities as $china_area_entity) {
            $item = $china_area_entity->toArray();
            $items[] = $item;
        }
        return $items;
    }

}


<?php

namespace App\Service\Regional;


use App\Src\Surport\Domain\Model\ChinaAreaEntity;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Domain\Model\ProvinceSpecification;
use App\Src\Surport\Infra\Repository\ChinaAreaRepository;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProvinceService
{
    /**
     * @param ProvinceSpecification $spec
     * @param int                   $per_page
     * @return array
     */
    public function getProvinceList(ProvinceSpecification $spec, $per_page)
    {
        $data = [];
        $province_repository = new ProvinceRepository();
        $china_area_repository = new ChinaAreaRepository();
        $paginate = $province_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var int                  $key
         * @var ProvinceEntity       $province_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $province_entity) {
            $item = $province_entity->toArray();
            /** @var ChinaAreaEntity $china_area_entity */
            $china_area_entity = $china_area_repository->fetch($item['area_id']);
            if (isset($china_area_entity)) {
                $item['area_name'] = $china_area_entity->name;
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


    /**
     * @param $id
     * @return array
     */
    public function getProvinceInfo($id)
    {
        $data = [];
        $province_repository = new ProvinceRepository();
        $province_entity = $province_repository->fetch($id);
        if (isset($province_entity)) {
            $data = $province_entity->toArray();
        }
        return $data;
    }

    public function getAllProvince()
    {
        $province_repository = new ProvinceRepository();
        $province_entities = $province_repository->all();
        $items = [];
        foreach ($province_entities as $province_entity) {
            $item = $province_entity->toArray();
            $items[] = $item;
        }
        return $items;
    }
}


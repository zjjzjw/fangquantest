<?php

namespace App\Service\Regional;


use App\Src\Surport\Domain\Model\ChinaAreaEntity;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Surport\Domain\Model\CitySpecification;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Infra\Repository\ChinaAreaRepository;
use App\Src\Surport\Infra\Repository\CityRepository;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class CityService
{
    /**
     * @param CitySpecification $spec
     * @param int               $per_page
     * @return array
     */
    public function getCityList(CitySpecification $spec, $per_page)
    {
        $data = [];
        $city_repository = new CityRepository();
        $province_repository = new ProvinceRepository();
        $paginate = $city_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var int                  $key
         * @var CityEntity           $city_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $city_entity) {
            $item = $city_entity->toArray();
            /** @var ProvinceEntity $province_entity */
            $province_entity = $province_repository->fetch($item['province_id']);
            if (isset($province_entity)) {
                $item['province_name'] = $province_entity->name;
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
    public function getCityInfo($id)
    {
        $data = [];
        $city_repository = new CityRepository();
        $city_entity = $city_repository->fetch($id);
        if (isset($city_entity)) {
            $data = $city_entity->toArray();
        }
        return $data;
    }
}


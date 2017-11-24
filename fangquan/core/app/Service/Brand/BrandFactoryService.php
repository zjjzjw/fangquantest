<?php

namespace App\Service\Brand;


use App\Src\Brand\Domain\Model\BrandFactoryEntity;
use App\Src\Brand\Domain\Model\BrandFactoryModelType;
use App\Src\Brand\Domain\Model\BrandFactorySpecification;
use App\Src\Brand\Domain\Model\BrandFactoryType;
use App\Src\Brand\Infra\Repository\BrandFactoryRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Infra\Repository\CityRepository;
use App\Src\Surport\Infra\Repository\ProvinceRepository;

class BrandFactoryService
{
    /**
     * @param BrandFactorySpecification $spec
     * @param int                       $per_page
     * @return array
     */
    public function getBrandFactoryList(BrandFactorySpecification $spec, $per_page)
    {
        $data = [];
        $brand_factory_repository = new BrandFactoryRepository();
        $city_repository = new CityRepository();
        $province_repository = new ProvinceRepository();
        $brand_factory_type = BrandFactoryType::acceptableEnums();
        $paginate = $brand_factory_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var int                  $key
         * @var BrandFactoryEntity   $brand_factory_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $brand_factory_entity) {
            $item = $brand_factory_entity->toArray();
            $item['factory_type_name'] = $brand_factory_type[$item['factory_type']];
            /** @var CityEntity $city_entity */
            $city_entity = $city_repository->fetch($item['city_id']);
            if (isset($city_entity)) {
                $item['city_name'] = $city_entity->name;
            }

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
    public function getBrandFactoryInfo($id)
    {
        $data = [];
        $brand_factory_repository = new BrandFactoryRepository();
        /** @var BrandFactoryEntity $brand_factory_entity */
        $brand_factory_entity = $brand_factory_repository->fetch($id);
        if (isset($brand_factory_entity)) {
            $data = $brand_factory_entity->toArray();
        }
        return $data;
    }
}


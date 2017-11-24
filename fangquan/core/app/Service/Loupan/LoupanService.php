<?php

namespace App\Service\Loupan;


use App\Src\Loupan\Infra\Repository\LoupanRepository;
use App\Src\Loupan\Domain\Model\LoupanEntity;
use App\Src\Loupan\Domain\Model\LoupanSpecification;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Surport\Infra\Repository\CityRepository;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use App\Src\Developer\Infra\Repository\DeveloperRepository;
use App\Src\Developer\Domain\Model\DeveloperEntity;

class LoupanService
{
    /**
     * @param LoupanSpecification $spec
     * @param int                 $per_page
     * @return array
     */
    public function getLoupanList(LoupanSpecification $spec, $per_page)
    {
        $data = [];
        $loupan_repository = new LoupanRepository();
        $province_repository = new ProvinceRepository();
        $city_repository = new CityRepository();
        $developer_repository = new DeveloperRepository();
        $paginate = $loupan_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var int          $key
         * @var LoupanEntity $loupan_entity
         */
        foreach ($paginate as $key => $loupan_entity) {
            $item = $loupan_entity->toArray();
            /** @var ProvinceEntity $province_entity */
            $province_entity = $province_repository->fetch($loupan_entity->province_id);
            $item['province_name'] = $province_entity->name ?? '';
            /** @var CityEntity $city_entity */
            $city_entity = $city_repository->fetch($loupan_entity->city_id);
            $item['city_name'] = $city_entity->name ?? '';
            $item['developer_names'] = '';
            if ($loupan_entity->loupan_developers) {
                $developer_names = [];
                foreach ($loupan_entity->loupan_developers as $developer) {
                    /** @var DeveloperEntity $developer_entity */
                    $developer_entity = $developer_repository->fetch($developer);
                    if (isset($developer_entity)) {
                        $developer_names[] = $developer_entity->name;
                    }
                }
                $item['developer_names'] = implode(',', $developer_names);
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
     * 分公司详情
     * @param $id
     * @return array
     */
    public function getDeveloperInfo($id)
    {
        $data = [];
        $developer_repository = new DeveloperRepository();
        $developer_entity = $developer_repository->fetch($id);
        if (isset($developer_entity)) {
            $data = $developer_entity->toArray();
        }
        return $data;
    }

    /**
     * @param $id
     * @return array
     */
    public function getLoupanInfo($id)
    {
        $data = [];
        $loupan_repository = new LoupanRepository();
        $developer_repository = new DeveloperRepository();
        $loupan_entity = $loupan_repository->fetch($id);
        if (isset($loupan_entity)) {
            $data = $loupan_entity->toArray();
            $developer_info = [];
            if ($data['loupan_developers']) {
                foreach ($data['loupan_developers'] as $developer) {
                    /** @var DeveloperEntity $developer_entity */
                    $developer_entity = $developer_repository->fetch($developer);
                    if (isset($developer_entity)) {
                        $developer_info['id'] = $developer_entity->id;
                        $developer_info['name'] = $developer_entity->name;
                    }
                    $data['developer_info'][] = $developer_info;
                }
            }
        }
        return $data;
    }
}


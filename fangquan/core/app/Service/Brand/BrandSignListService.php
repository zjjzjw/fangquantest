<?php

namespace App\Service\Brand;


use App\Src\Brand\Domain\Model\BrandSignListEntity;
use App\Src\Brand\Domain\Model\BrandSignListSpecification;
use App\Src\Brand\Infra\Eloquent\BrandSignDeveloperModel;
use App\Src\Brand\Infra\Repository\BrandSignListRepository;
use App\Src\Category\Domain\Model\CategoryEntity;
use App\Src\Category\Infra\Repository\CategoryRepository;
use App\Src\Developer\Domain\Model\DeveloperEntity;
use App\Src\Developer\Infra\Repository\DeveloperRepository;
use App\Src\Loupan\Domain\Model\LoupanEntity;
use App\Src\Loupan\Infra\Repository\LoupanRepository;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Infra\Repository\CityRepository;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class BrandSignListService
{
    /**
     * @param BrandSignListSpecification $spec
     * @param int                        $per_page
     * @return array
     */
    public function getBrandSignListList(BrandSignListSpecification $spec, $per_page)
    {
        $data = [];
        $brand_sign_list_repository = new BrandSignListRepository();
        $city_repository = new CityRepository();
        $province_repository = new ProvinceRepository();
        $loupan_repository = new LoupanRepository();
        $developer_repository = new DeveloperRepository();
        $category_repository = new CategoryRepository();
        $paginate = $brand_sign_list_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var int                  $key
         * @var BrandSignListEntity  $brand_sign_list_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $brand_sign_list_entity) {
            $item = $brand_sign_list_entity->toArray();
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
            /** @var LoupanEntity $loupan_entity */
            $loupan_entity = $loupan_repository->fetch($item['loupan_id']);
            if (isset($loupan_entity)) {
                $item['loupan_name'] = $loupan_entity->name;
            }

            $item['category_names'] = '';
            if ($brand_sign_list_entity->brand_sign_categorys) {
                $category_names = [];
                foreach ($brand_sign_list_entity->brand_sign_categorys as $category) {
                    /** @var CategoryEntity $category_entity */
                    $category_entity = $category_repository->fetch($category);
                    if (isset($category_entity)) {
                        $category_names[] = $category_entity->name;
                    }
                }
                $item['category_names'] = implode(',', $category_names);
            }
            $developers = BrandSignDeveloperModel::where('project_sign_id', $item['id'])->get()->toArray();
            $item['developer_names'] = '';
            if (isset($developers)) {
                $developer_names = [];
                foreach ($developers as $developer) {
                    if (!empty($developer['developer_name'])) {
                        $developer_names[] = $developer['developer_name'];
                    } else {
                        /** @var DeveloperEntity $developer_entity */
                        $developer_entity = $developer_repository->fetch($developer['developer_id']);
                        if (isset($developer_entity)) {
                            $developer_names[] = $developer_entity->name;
                        }
                    }
                }
                $item['developer_names'] = implode(',', $developer_names);
            }
            $item['order_sign_time'] = Carbon::parse($item['order_sign_time'])->format('Y-m');
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
    public function getBrandSignListInfo($id)
    {
        $data = [];
        $brand_sign_list_repository = new BrandSignListRepository();
        $developer_repository = new DeveloperRepository();
        $loupan_repository = new LoupanRepository();
        /** @var BrandSignListEntity $brand_sign_list_entity */
        $brand_sign_list_entity = $brand_sign_list_repository->fetch($id);
        if (isset($brand_sign_list_entity)) {
            $data = $brand_sign_list_entity->toArray();
            $developers = [];
            $developer_info = BrandSignDeveloperModel::where('project_sign_id', $id)->get()->toArray();
            if (isset($developer_info)) {
                foreach ($developer_info as $developer) {
                    if (!empty($developer['developer_name'])) {
                        $developers['id'] = $developer['developer_id'];
                        $developers['name'] = $developer['developer_name'];
                    } else {
                        /** @var DeveloperEntity $developer_entity */
                        $developer_entity = $developer_repository->fetch($developer['developer_id']);
                        if (isset($developer_entity)) {
                            $developers['id'] = $developer_entity->id;
                            $developers['name'] = $developer_entity->name;
                        }
                    }
                    $data['developer_info'][] = $developers;
                }
            }
            /** @var LoupanEntity $loupan_entity */
            $loupan_entity = $loupan_repository->fetch($brand_sign_list_entity->loupan_id);
            if (isset($loupan_entity)) {
                $data['loupan_name'] = $loupan_entity->name;
            }
        }
        return $data;
    }
}


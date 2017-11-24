<?php

namespace App\Service\Brand;


use App\Src\Brand\Domain\Model\BrandCooperationEntity;
use App\Src\Brand\Domain\Model\BrandCooperationSpecification;
use App\Src\Brand\Domain\Model\BrandCooperationType;
use App\Src\Brand\Infra\Repository\BrandCooperationRepository;
use App\Src\Category\Domain\Model\CategoryEntity;
use App\Src\Category\Infra\Repository\CategoryRepository;
use App\Src\Developer\Domain\Model\DeveloperEntity;
use App\Src\Developer\Infra\Repository\DeveloperRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class BrandCooperationService
{
    /**
     * @param BrandCooperationSpecification $spec
     * @param int                           $per_page
     * @return array
     */
    public function getBrandCooperationList(BrandCooperationSpecification $spec, $per_page)
    {
        $data = [];
        $brand_cooperation_repository = new BrandCooperationRepository();
        $developer_repository = new DeveloperRepository();
        $category_repository = new CategoryRepository();
        $brand_cooperation_type = BrandCooperationType::acceptableEnums();
        $paginate = $brand_cooperation_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var int                    $key
         * @var BrandCooperationEntity $brand_cooperation_entity
         * @var LengthAwarePaginator   $paginate
         */
        foreach ($paginate as $key => $brand_cooperation_entity) {
            $item = $brand_cooperation_entity->toArray();
            $item['exclusive_name'] = $brand_cooperation_type[$brand_cooperation_entity->is_exclusive];
            /** @var DeveloperEntity $developer_entity */
            $developer_entity = $developer_repository->fetch($brand_cooperation_entity->developer_id);
            if (isset($developer_entity)) {
                $item['developer_name'] = $developer_entity->name;
            }
            $item['category_names'] = '';
            if ($brand_cooperation_entity->brand_cooperation_categorys) {
                $category_names = [];
                foreach ($brand_cooperation_entity->brand_cooperation_categorys as $category) {
                    /** @var CategoryEntity $category_entity */
                    $category_entity = $category_repository->fetch($category);
                    if (isset($category_entity)) {
                        $category_names[] = $category_entity->name;
                    }
                }
                $item['category_names'] = implode(',', $category_names);
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
    public function getBrandCooperationInfo($id)
    {
        $data = [];
        $brand_cooperation_repository = new BrandCooperationRepository();
        $developer_repository = new DeveloperRepository();
        /** @var BrandCooperationEntity $brand_cooperation_entity */
        $brand_cooperation_entity = $brand_cooperation_repository->fetch($id);
        if (isset($brand_cooperation_entity)) {
            $data = $brand_cooperation_entity->toArray();
            /** @var DeveloperEntity $developer_entity */
            $developer_entity = $developer_repository->fetch($brand_cooperation_entity->developer_id);
            if (isset($developer_entity)) {
                $data['developer_name'] = $developer_entity->name;
            }
        }
        return $data;
    }
}


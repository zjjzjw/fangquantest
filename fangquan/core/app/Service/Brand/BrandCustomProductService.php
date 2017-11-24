<?php

namespace App\Service\Brand;


use App\Src\Brand\Domain\Model\BrandCustomProductEntity;
use App\Src\Brand\Domain\Model\BrandCustomProductSpecification;
use App\Src\Developer\Domain\Model\DeveloperEntity;
use App\Src\Developer\Infra\Repository\DeveloperRepository;
use App\Src\Loupan\Domain\Model\LoupanEntity;
use App\Src\Loupan\Infra\Repository\LoupanRepository;
use App\Src\Brand\Infra\Repository\BrandCustomProductRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class BrandCustomProductService
{
    /**
     * @param BrandCustomProductSpecification $spec
     * @param int                             $per_page
     * @return array
     */
    public function getBrandCustomProductList(BrandCustomProductSpecification $spec, $per_page)
    {
        $data = [];
        $brand_custom_product_repository = new BrandCustomProductRepository();
        $developer_repository = new DeveloperRepository();
        $loupan_repository = new LoupanRepository();
        $paginate = $brand_custom_product_repository->search($spec, $per_page);
        $items = [];

        /**
         * @var int                      $key
         * @var BrandCustomProductEntity $brand_custom_product_entity
         * @var LengthAwarePaginator     $paginate
         */
        foreach ($paginate as $key => $brand_custom_product_entity) {
            $item = $brand_custom_product_entity->toArray();
            $developer_entity = $developer_repository->fetch($brand_custom_product_entity->developer_id);
            $item['developer_name'] = $developer_entity->name ?? '';
            $loupan_entity = $loupan_repository->fetch($brand_custom_product_entity->loupan_id);
            $item['loupan_name'] = $loupan_entity->name ?? '';
            $items[] = $item;
        }
        $data['paginate'] = $paginate;
        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();
        return $data;
    }


    public function getAllDeveloperList()
    {
        $data = [];
        $developer_repository = new DeveloperRepository();
        $developer_models = $developer_repository->all();
        $data = $developer_models;
        return $data;
    }

    /**
     * @param $id
     * @return array
     */
    public function getBrandCustomProductInfo($id)
    {
        $data = [];
        $brand_custom_product_repository = new BrandCustomProductRepository();
        $developer_repository = new DeveloperRepository();
        $loupan_repository = new LoupanRepository();
        /** @var BrandCustomProductEntity $brand_custom_product_entity */
        $brand_custom_product_entity = $brand_custom_product_repository->fetch($id);

        if (isset($brand_custom_product_entity)) {
            $data = $brand_custom_product_entity->toArray();
        }
        $developer_entity = $developer_repository->fetch($brand_custom_product_entity->developer_id);
        $data['developer_name'] = $developer_entity->name ?? '';
        $loupan_entity = $loupan_repository->fetch($brand_custom_product_entity->loupan_id);
        $data['loupan_name'] = $loupan_entity->name ?? '';

        return $data;
    }
}


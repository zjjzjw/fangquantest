<?php

namespace App\Service\Brand;


use App\Src\Brand\Domain\Model\BrandSaleAreaType;
use App\Src\Brand\Domain\Model\BrandSaleEntity;
use App\Src\Brand\Domain\Model\BrandSaleSpecification;
use App\Src\Brand\Domain\Model\BrandSaleType;
use App\Src\Brand\Infra\Repository\BrandSaleRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class BrandSaleService
{
    /**
     * @param BrandSaleSpecification $spec
     * @param int                    $per_page
     * @return array
     */
    public function getBrandSaleList(BrandSaleSpecification $spec, $per_page)
    {
        $data = [];
        $brand_sale_repository = new BrandSaleRepository();
        $paginate = $brand_sale_repository->search($spec, $per_page);
        $brand_sale_area_type = BrandSaleAreaType::acceptableEnums();
        $brand_sale_type = BrandSaleType::acceptableEnums();
        $items = [];
        /**
         * @var int                  $key
         * @var BrandSaleEntity      $brand_sale_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $brand_sale_entity) {
            $item = $brand_sale_entity->toArray();
            $item['type_name'] = '';
            if ($item['type']) {
                $item['type_name'] = $brand_sale_type[$item['type']] ?? '';
            }

            $item['sale_area_names'] = '';
            if ($item['sale_areas']) {
                $sale_area_name = [];
                foreach ($item['sale_areas'] as $area) {
                    $sale_area_name[] = $brand_sale_area_type[$area];
                }
                $item['sale_area_names'] = implode(',', $sale_area_name);
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
     * 得到销售负责人
     * @param int $brand_id
     * @return array
     */
    public function getBrandSalesByBrandId($brand_id)
    {
        $brand_sale_repository = new BrandSaleRepository();
        $brand_sale_entities = $brand_sale_repository->getBrandSalesByBrandId($brand_id);
        $brand_sale_area_types = BrandSaleAreaType::acceptableEnums();
        $brand_sale_types = BrandSaleType::acceptableEnums();
        $items = [];
        foreach ($brand_sale_entities as $brand_sale_entity) {
            $item = $brand_sale_entity->toArray();
            $item['type_name'] = '';
            if ($item['type']) {
                $item['type_name'] = $brand_sale_types[$item['type']] ?? '';
            }
            $item['sale_area_names'] = '';
            if ($item['sale_areas']) {
                $sale_area_names = [];
                foreach ($item['sale_areas'] as $area) {
                    $sale_area_names[] = $brand_sale_area_types[$area] ?? '';
                }
                $item['sale_area_names'] = implode(',', $sale_area_names);
            }
            $items[] = $item;
        }
        return $items;
    }

    /**
     * @param $id
     * @return array
     */
    public function getBrandSaleInfo($id)
    {
        $data = [];
        $brand_sale_repository = new BrandSaleRepository();
        /** @var BrandSaleEntity $brand_sale_entity */
        $brand_sale_entity = $brand_sale_repository->fetch($id);
        if (isset($brand_sale_entity)) {
            $data = $brand_sale_entity->toArray();
        }
        return $data;
    }
}


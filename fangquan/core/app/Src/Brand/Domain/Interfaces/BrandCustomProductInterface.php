<?php namespace App\Src\Brand\Domain\Interfaces;


use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Brand\Domain\Model\BrandCustomProductSpecification;

interface BrandCustomProductInterface extends Repository
{

    /**
     * @param BrandCustomProductSpecification $spec
     * @param int                             $per_page
     * @return mixed
     */
    public function search(BrandCustomProductSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /**
     * @param $brand_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getBrandCustomProductsByBrandId($brand_id);

}
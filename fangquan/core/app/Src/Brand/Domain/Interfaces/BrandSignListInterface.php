<?php namespace App\Src\Brand\Domain\Interfaces;


use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Brand\Domain\Model\BrandSignListSpecification;

interface BrandSignListInterface extends Repository
{

    /**
     * @param BrandSignListSpecification $spec
     * @param int                        $per_page
     * @return mixed
     */
    public function search(BrandSignListSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /**
     * @param $brand_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getBrandSignListByBrandId($brand_id);
}
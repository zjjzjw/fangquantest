<?php namespace App\Src\Brand\Domain\Interfaces;


use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Brand\Domain\Model\BrandServiceEntity;


interface BrandServiceInterface extends Repository
{
    /**
     * @param $brand_id
     * @return BrandServiceEntity|null
     */
    public function getBrandServiceByBrandId($brand_id);
}
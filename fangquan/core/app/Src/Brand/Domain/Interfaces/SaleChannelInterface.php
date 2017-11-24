<?php namespace App\Src\Brand\Domain\Interfaces;


use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Brand\Domain\Model\SaleChannelEntity;
use App\Src\Brand\Domain\Model\SaleChannelSpecification;

interface SaleChannelInterface extends Repository
{

    /**
     * @param SaleChannelSpecification $spec
     * @param int                      $per_page
     * @return mixed
     */
    public function search(SaleChannelSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);


    /**
     * @param int   $brand_id
     * @param array $sales
     */
    public function modify($brand_id, $sales);

    /**
     * @param int $brand_id
     * @param int $year
     * @param int $type
     * @return SaleChannelEntity|null
     */
    public function getSaleChannelByParams($brand_id, $year, $type);
}
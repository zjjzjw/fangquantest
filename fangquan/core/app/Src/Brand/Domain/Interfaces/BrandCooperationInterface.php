<?php namespace App\Src\Brand\Domain\Interfaces;


use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Brand\Domain\Model\BrandCooperationSpecification;

interface BrandCooperationInterface extends Repository
{

    /**
     * @param BrandCooperationSpecification $spec
     * @param int                           $per_page
     * @return mixed
     */
    public function search(BrandCooperationSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);
}
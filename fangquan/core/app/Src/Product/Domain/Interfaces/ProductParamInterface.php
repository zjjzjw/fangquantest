<?php namespace App\Src\Product\Domain\Interfaces;


use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Product\Domain\Model\ProductParamSpecification;

interface ProductParamInterface extends Repository
{

    /**
     * @param ProductParamSpecification $spec
     * @param int                  $per_page
     * @return mixed
     */
    public function search(ProductParamSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);
}
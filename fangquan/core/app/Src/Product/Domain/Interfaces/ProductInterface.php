<?php namespace App\Src\Product\Domain\Interfaces;


use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Product\Domain\Model\ProductSpecification;

interface ProductInterface extends Repository
{

    /**
     * @param ProductSpecification $spec
     * @param int                   $per_page
     * @return mixed
     */
    public function search(ProductSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);
}
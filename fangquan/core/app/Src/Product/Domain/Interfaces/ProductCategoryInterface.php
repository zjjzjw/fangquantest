<?php namespace App\Src\Product\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Product\Domain\Model\ProductCategorySpecification;

interface ProductCategoryInterface extends Repository
{
    /**
     * @param ProductCategorySpecification $spec
     * @param int                          $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ProductCategorySpecification $spec, $per_page = 10);

    /**
     * @param int|array $parent_id
     * @param int|array $status
     * @return array|\Illuminate\Support\Collection
     */
    public function getProductCategoryByParentId($parent_id, $status);


    /**
     * @param int|array      $second_ids
     * @param null|int|array $status
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getThirdProductCategory($second_ids, $status = null);

    /**
     * @param int|array $ids
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getProductCategoryByIds($ids);

}
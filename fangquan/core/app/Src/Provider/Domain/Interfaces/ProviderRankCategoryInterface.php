<?php namespace App\Src\Provider\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Provider\Domain\Model\ProviderRankCategorySpecification;

interface ProviderRankCategoryInterface extends Repository
{
    /**
     * @param ProviderRankCategorySpecification $spec
     * @param int                               $per_page
     * @return mixed
     */
    public function search(ProviderRankCategorySpecification $spec, $per_page = 10);


    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /**
     * @param $category_id
     * @param $rank
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderRankCategoryByCategoryIdAndRank($category_id, $rank);


    /**
     * @param int|array $category_id
     * @param null|int  $limit
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderRankCategoryByCategoryId($category_id, $limit = null);
}
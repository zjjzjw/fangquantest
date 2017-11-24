<?php namespace App\Src\Content\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Content\Domain\Model\ContentCategorySpecification;

interface ContentCategoryInterface extends Repository
{
    /**
     * @param ContentCategorySpecification $spec
     * @param int                          $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ContentCategorySpecification $spec, $per_page = 10);

    /**
     * @param int|array $parent_id
     * @param int|array $status
     * @return array|\Illuminate\Support\Collection
     */
    public function getContentCategoryByParentId($parent_id);


    /**
     * @param int|array      $second_ids
     * @param null|int|array $status
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getThirdContentCategory($second_ids, $status = null);

    /**
     * @param int|array $ids
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getContentCategoryByIds($ids);

}
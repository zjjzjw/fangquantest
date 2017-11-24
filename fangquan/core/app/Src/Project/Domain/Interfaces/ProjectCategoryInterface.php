<?php namespace App\Src\Project\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Project\Domain\Model\ProjectCategorySpecification;

interface ProjectCategoryInterface extends Repository
{
    /**
     * @param ProjectCategorySpecification $spec
     * @param int                          $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ProjectCategorySpecification $spec, $per_page = 10);

    /**
     * @param int|array $parent_id
     * @param int|array $status
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectCategoryByParentId($parent_id, $status);

    /**
     * @param int|array      $second_ids
     * @param null|int|array $status
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getThirdProjectCategory($second_ids, $status = null);

    /**
     * @param int|array $ids
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getProjectCategoryByIds($ids);

    /**
     * @param int|array      $level
     * @param null|int|array $status
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectCategoryByLevelAndStatus($level, $status = null);

    /**
     * @param int|array      $second_ids
     * @param null|int|array $status
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getProjectCategoryByIdsAndLevel($ids, $status = null);

}
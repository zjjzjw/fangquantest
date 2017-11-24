<?php namespace App\Src\Developer\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Developer\Domain\Model\DeveloperProjectSpecification;

interface DeveloperProjectInterface extends Repository
{
    /**
     * @param DeveloperProjectSpecification $spec
     * @param int                           $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(DeveloperProjectSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /**

     * @param $developer_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectListByDeveloperId($developer_id);

    /**
     * 获取广告项目
     * @param int|array $status
     * @param int|array $limit
     * @return array|\Illuminate\Support\Collection
     */
    public function getAdDeveloperProjectList($status, $limit);

    /**
     * @param int       $limit
     * @param int|array $status
     */
    public function getTopDeveloperProjects($limit, $status);

}
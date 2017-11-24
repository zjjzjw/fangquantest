<?php namespace App\Src\Developer\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Developer\Domain\Model\DeveloperProjectContactSpecification;

interface DeveloperProjectContactInterface extends Repository
{
    /**
     * @param DeveloperProjectContactSpecification $spec
     * @param int                                  $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(DeveloperProjectContactSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /**
     * @param $developer_project_id
     */
    public function deleteByDeveloperProjectId($developer_project_id);

    /**
     * @param $developer_project_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getDeveloperProjectContactListByProjectId($developer_project_id);
}
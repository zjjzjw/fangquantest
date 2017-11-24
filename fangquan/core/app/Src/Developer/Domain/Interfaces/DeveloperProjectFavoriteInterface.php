<?php namespace App\Src\Developer\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Developer\Domain\Model\DeveloperProjectFavoriteSpecification;

interface DeveloperProjectFavoriteInterface extends Repository
{

    /**
     * @param int       $user_id
     * @param int|array $developer_project_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getFavoriteByUserIdAndProjectId($user_id, $developer_project_id);

    /**
     * @param $ids
     */
    public function delete($ids);

    /**
     * @param $user_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getFavoriteRecordByUserId($user_id);

    /**
     * @param DeveloperProjectFavoriteSpecification $spec
     * @param int                                   $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(DeveloperProjectFavoriteSpecification $spec, $per_page = 10);
}
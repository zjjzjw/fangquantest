<?php namespace App\Src\Developer\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Developer\Domain\Model\DeveloperProjectStageTimeSpecification;

interface DeveloperProjectStageTimeInterface extends Repository
{
    /**
     * @param DeveloperProjectStageTimeSpecification $spec
     * @param int                                    $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(DeveloperProjectStageTimeSpecification $spec, $per_page = 10);

    /**
     * @param $ids
     * @return mixed
     */
    public function delete($ids);

    /**
     * @param $project_id
     * @param $stage_type
     * @return array|\Illuminate\Support\Collection
     */
    public function getDeveloperProjectStageTimeByProjectIdAndType($project_id, $stage_type);
}
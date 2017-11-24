<?php namespace App\Src\Developer\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Developer\Domain\Model\DeveloperProjectStageSpecification;

interface DeveloperProjectStageInterface extends Repository
{
    /**
     * @param DeveloperProjectStageSpecification $spec
     * @param int                          $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(DeveloperProjectStageSpecification $spec, $per_page = 10);

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all();
}
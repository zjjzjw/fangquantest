<?php namespace App\Src\Developer\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;

interface DeveloperProjectHasProjectCategoryInterface extends Repository
{

    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /**
     * @param $developer_project_id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getDeveloperProjectCategoriesByDeveloperProjectId($developer_project_id);
}
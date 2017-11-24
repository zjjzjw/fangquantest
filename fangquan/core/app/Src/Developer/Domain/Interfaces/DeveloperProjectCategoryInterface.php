<?php namespace App\Src\Developer\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Developer\Domain\Model\DeveloperProjectCategorySpecification;

interface DeveloperProjectCategoryInterface extends Repository
{

    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /**
     * @param $developer_project_id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getDeveloperMainCategoriesByDeveloperProjectId($developer_project_id);
}
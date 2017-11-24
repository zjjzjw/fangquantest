<?php namespace App\Src\Developer\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Developer\Domain\Model\DeveloperProjectBrowseEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectContactSpecification;

interface DeveloperProjectBrowseInterface extends Repository
{

    /**
     * @param $user_id
     * @param $p_id
     * @return DeveloperProjectBrowseEntity|null
     */
    public function getUserBrowse($user_id, $p_id);
}
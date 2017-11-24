<?php namespace App\Src\Role\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;

interface PermissionInterface extends Repository
{

    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function all();
}
<?php namespace App\Src\Role\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;

interface UserDataInterface extends Repository
{
    /**
     * @param int $user_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getUserDataByUserId($user_id);
}
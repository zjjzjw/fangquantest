<?php namespace App\Src\Content\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;

interface UserInfoInterface extends Repository
{

    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /*
    * @param int $user_id
    * @return UserInfoEntity|null
    */
    public function getUserInfoByUserId($user_id);
}
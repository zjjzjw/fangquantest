<?php namespace App\Src\Role\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;


interface WagePasswordInterface extends Repository
{

    /**
     * @param int $user_id
     * return $mixed
     */
    public function getPasswordByUserId($user_id);

}
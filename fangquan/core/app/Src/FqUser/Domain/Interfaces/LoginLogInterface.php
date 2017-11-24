<?php namespace App\Src\FqUser\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\FqUser\Domain\Model\LoginLogSpecification;

interface LoginLogInterface extends Repository
{
    /**
     * @param LoginLogSpecification               $spec
     * @param                                     $per_page
     * @return mixed
     */
    public function search(LoginLogSpecification $spec, $per_page);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $user_id
     * @return mixed
     */
    public function getLoginLogByUserId($user_id);

}
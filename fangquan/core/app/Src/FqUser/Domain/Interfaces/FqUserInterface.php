<?php namespace App\Src\FqUser\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\FqUser\Domain\Model\FqUserSpecification;

interface FqUserInterface extends Repository
{
    /**
     * @param FqUserSpecification                 $spec
     * @param                                     $per_page
     * @return mixed
     */
    public function search(FqUserSpecification $spec, $per_page);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $id
     * @return mixed
     */
    public function getFqUserById($id);

    /**
     * @param $role_id
     * @param $role_type
     * @return mixed
     */
    public function getFqUserByRoleId($role_id, $role_type);

}
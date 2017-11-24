<?php namespace App\Src\Role\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Role\Domain\Model\RoleSpecification;

interface RoleInterface extends Repository
{
    /**
     * @param RoleSpecification $spec
     * @param int               $per_page
     * @return mixed
     */
    public function search(RoleSpecification $spec, $per_page = 10);


    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all();
}
<?php namespace App\Src\Role\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Role\Domain\Model\DepartSpecification;

interface DepartInterface extends Repository
{
    /**
     * @param DepartSpecification $spec
     * @param int                 $per_page
     * @return mixed
     */
    public function search(DepartSpecification $spec, $per_page = 10);


    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function all();
}
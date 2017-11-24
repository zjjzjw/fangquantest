<?php namespace App\Src\Category\Domain\Interfaces;


use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Category\Domain\Model\CategoryParamSpecification;

interface CategoryParamInterface extends Repository
{

    /**
     * @param CategoryParamSpecification $spec
     * @param int                   $per_page
     * @return mixed
     */
    public function search(CategoryParamSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);
}
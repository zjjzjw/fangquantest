<?php namespace App\Src\Category\Domain\Interfaces;


use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Category\Domain\Model\CategorySpecification;

interface CategoryInterface extends Repository
{

    /**
     * @param CategorySpecification $spec
     * @param int                   $per_page
     * @return mixed
     */
    public function search(CategorySpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);
}
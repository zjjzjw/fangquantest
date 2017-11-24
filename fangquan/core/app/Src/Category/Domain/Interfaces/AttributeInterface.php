<?php namespace App\Src\Category\Domain\Interfaces;


use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Category\Domain\Model\AttributeSpecification;

interface AttributeInterface extends Repository
{

    /**
     * @param AttributeSpecification $spec
     * @param int                    $per_page
     * @return mixed
     */
    public function search(AttributeSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function all();

    /**
     * @param int $category_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getAttributeByCategoryId($category_id);

}
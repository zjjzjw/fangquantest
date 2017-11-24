<?php namespace App\Src\Tag\Domain\Interfaces;


use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Tag\Domain\Model\TagSpecification;

interface TagInterface extends Repository
{

    /**
     * @param TagSpecification $spec
     * @param int              $per_page
     * @return mixed
     */
    public function search(TagSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);
}
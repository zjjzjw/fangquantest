<?php namespace App\Src\Brand\Domain\Interfaces;


use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Brand\Domain\Model\CommentSpecification;

interface CommentInterface extends Repository
{

    /**
     * @param CommentSpecification $spec
     * @param int                  $per_page
     * @return mixed
     */
    public function search(CommentSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);
}
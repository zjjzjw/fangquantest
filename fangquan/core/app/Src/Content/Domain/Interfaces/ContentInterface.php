<?php namespace App\Src\Content\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Content\Domain\Model\ContentSpecification;

interface ContentInterface extends Repository
{
    /**
     * @param ContentSpecification $spec
     * @param int                  $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ContentSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);
}
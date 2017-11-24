<?php namespace App\Src\MediaManagement\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\MediaManagement\Domain\Model\MediaManagementSpecification;

interface MediaManagementInterface extends Repository
{
    /**
     * @param MediaManagementSpecification $spec
     * @param int                    $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(MediaManagementSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);



}
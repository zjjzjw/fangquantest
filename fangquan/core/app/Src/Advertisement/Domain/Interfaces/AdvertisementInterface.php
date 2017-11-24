<?php namespace App\Src\Advertisement\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Advertisement\Domain\Model\AdvertisementSpecification;

interface AdvertisementInterface extends Repository
{
    /**
     * @param AdvertisementSpecification $spec
     * @param int                          $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(AdvertisementSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);
}
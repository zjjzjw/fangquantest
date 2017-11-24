<?php namespace App\Src\Surport\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Surport\Domain\Model\ProvinceSpecification;

interface ProvinceInterface extends Repository
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function all();

    /**
     * @param ProvinceSpecification $spec
     * @param int                   $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ProvinceSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);
}
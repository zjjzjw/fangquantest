<?php namespace App\Src\Developer\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Developer\Domain\Model\DeveloperSpecification;

interface DeveloperInterface extends Repository
{
    /**
     * @param DeveloperSpecification $spec
     * @param int                    $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(DeveloperSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /**
     * @param $rank
     * @param $status
     * @return array|\Illuminate\Support\Collection
     */
    public function getDeveloperByRankAndStatus($rank, $status);


    public function geHotDeveloperList();


    /**
     * @param string $keyword
     * @return array|\Illuminate\Support\Collection
     */
    public function getDeveloperByKeyword($keyword);

    /**
     * @param array $ids
     * @return array|\Illuminate\Support\Collection
     */
    public function getDevelopersByIds($ids);
}
<?php namespace App\Src\Provider\Domain\Interfaces;


use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Foundation\Domain\Interfaces\Repository;

interface ProviderInterface extends Repository
{
    /**
     * @param ProviderSpecification $spec
     * @param int                   $per_page
     * @param                       $type
     * @return mixed
     */
    public function search(ProviderSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /**
     * @param int|array $ids
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderByIds($ids, $statuses = null);

    /**
     * @param $rank
     * @param $status
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderByRankAndStatus($rank, $status);

    /**
     * @return int 得到供应商数量
     */
    public function getProviderCount();
}
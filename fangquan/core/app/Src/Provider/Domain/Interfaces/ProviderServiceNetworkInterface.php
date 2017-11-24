<?php namespace App\Src\Provider\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Provider\Domain\Model\ProviderServiceNetworkSpecification;

interface ProviderServiceNetworkInterface extends Repository
{
    /**
     * @param int       $provider_id
     * @param int|array $status
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderServiceNetworkByProviderIdAndStatus($provider_id, $status);

    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /**
     * @param ProviderServiceNetworkSpecification $spec
     * @param int                                 $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ProviderServiceNetworkSpecification $spec, $per_page = 20);

}
<?php namespace App\Src\Provider\Domain\Interfaces;


use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Provider\Domain\Model\ProviderProductSpecification;

interface ProviderProductInterface extends Repository
{
    /**
     * @param ProviderProductSpecification $spec
     * @param int                          $per_page
     * @return mixed
     */
    public function search(ProviderProductSpecification $spec, $per_page = 10);

    /**
     * @param int|array $id
     */
    public function delete($id);

    /**
     * @param int       $provider_id
     * @param int|array $status
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderProductByProviderIdAndStatus($provider_id, $status);

    /**
     * @param ProviderProductSpecification $spec
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderProductBySpec(ProviderProductSpecification $spec);
}
<?php namespace App\Src\Provider\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;

interface ProviderProjectProductInterface extends Repository
{
    /**
     * @param int $provider_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderProjectProductByProviderId($provider_id);

    /**
     * @param int|array $id
     */
    public function delete($id);
}
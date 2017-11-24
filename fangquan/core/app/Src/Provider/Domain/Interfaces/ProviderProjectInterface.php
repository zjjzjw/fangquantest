<?php namespace app\Src\Provider\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;

interface ProviderProjectInterface extends Repository
{
    /**
     * @param int       $provider_id
     * @param int|array $status
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderProjectByProviderIdAndStatus($provider_id, $status);

    /**
     * @param int|array $id
     */
    public function delete($id);
}
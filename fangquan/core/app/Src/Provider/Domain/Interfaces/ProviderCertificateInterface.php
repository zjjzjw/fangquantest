<?php namespace App\Src\Provider\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;

interface ProviderCertificateInterface extends Repository
{
    /**
     * @param int            $provider_id
     * @param array|int      $status
     * @param null|array|int $type
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderCertificateByProviderIdAndStatus($provider_id, $status, $type = null);

    /**
     * @param array|int $id
     */
    public function delete($id);

    /**
     * @param int       $provider_id
     * @param int|array $status
     * @return array|\Illuminate\Support\Collection
     */

}
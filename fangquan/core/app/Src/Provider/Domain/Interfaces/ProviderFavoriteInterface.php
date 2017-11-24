<?php namespace App\Src\Provider\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;

interface ProviderFavoriteInterface extends Repository
{
    /**
     * @param int|array $id
     * @return mixed|void
     */
    public function delete($ids);


    /**
     * @param int       $user_id
     * @param int|array $provider_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderFavoriteByUserIdAndProviderId($user_id, $provider_id);

    /**
     * @param $user_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderFavoriteByUserId($user_id);
}
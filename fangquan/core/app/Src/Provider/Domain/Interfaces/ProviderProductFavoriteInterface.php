<?php namespace App\Src\Provider\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;

interface ProviderProductFavoriteInterface extends Repository
{
    /**
     * @param int|array $id
     * @return mixed|void
     */
    public function delete($ids);


    /**
     * @param int       $user_id
     * @param int|array $provider_product_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderProductFavoriteByUserIdAndProductId($user_id, $provider_product_id);
}
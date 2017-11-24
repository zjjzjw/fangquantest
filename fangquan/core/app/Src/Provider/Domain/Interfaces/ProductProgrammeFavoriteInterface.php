<?php namespace App\Src\Provider\Domain\Interfaces;


use App\Foundation\Domain\Interfaces\Repository;

interface ProductProgrammeFavoriteInterface extends Repository
{

    /**
     * @param int|array $id
     */
    public function delete($id);

    /**
     * @param $user_id
     * @param $product_programme_id
     * @return mixed
     */
    public function getProductProgrammeFavoriteByProgrammeIdAndUserId($user_id, $product_programme_id);
}
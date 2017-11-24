<?php namespace App\Src\Provider\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;

interface ProviderNewsInterface extends Repository
{
    /**
     * @param int|array $id
     * @return mixed
     */
    public function delete($id);

}
<?php namespace App\Src\Role\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Provider\Domain\Model\ProviderPropagandaSpecification;

interface ProviderPropagandaInterface extends Repository
{
    /**
     * @param ProviderPropagandaSpecification $spec
     * @param int                         $per_page
     * @return mixed
     */
    public function search(ProviderFriendSpecification $spec, $per_page = 10);


    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function all();
}
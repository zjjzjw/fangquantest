<?php namespace App\Src\Provider\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
interface ProviderFriendInterface extends Repository
{
    /**
     * @param ProviderFriendSpecification $spec
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
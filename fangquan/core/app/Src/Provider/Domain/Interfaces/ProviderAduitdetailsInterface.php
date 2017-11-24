<?php namespace App\Src\Role\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
interface ProviderAduitdetailsInterface extends Repository
{
    /**
     * @param ProviderAduitdetailsSpecification $spec
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
<?php namespace App\Src\Provider\Domain\Interfaces;


use App\Src\Provider\Domain\Model\ProviderPictureSpecification;
use App\Foundation\Domain\Interfaces\Repository;

interface ProviderPictureInterface extends Repository
{
    /**
     * @param ProviderPictureSpecification $spec
     * @param int                          $per_page
     * @param                              $type
     * @return mixed
     */
    public function search(ProviderPictureSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /**
     * @param null|int $provider_id
     * @param null|int $type
     * @return mixed
     */
    public function getImageByProviderId($provider_id, $type);

}
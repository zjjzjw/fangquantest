<?php namespace App\Src\Provider\Domain\Interfaces;


use App\Src\Provider\Domain\Model\ProviderMainCategorySpecification;
use App\Foundation\Domain\Interfaces\Repository;

interface ProviderMainCategoryInterface extends Repository
{
    /**
     * @param ProviderMainCategorySpecification $spec
     * @param int                               $per_page
     * @param                                   $type
     * @return mixed
     */
    public function search(ProviderMainCategorySpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /**
     * @param int $provider_id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getProviderMainCategoriesByProviderId($provider_id);

    /**
     * @param int $product_category_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderMainCategoryByProductCategoryId($product_category_id);


}
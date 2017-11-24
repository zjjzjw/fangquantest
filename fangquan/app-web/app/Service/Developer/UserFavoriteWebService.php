<?php

namespace App\Web\Service\Developer;


use App\Src\Developer\Domain\Model\DeveloperProjectStatus;
use App\Src\Developer\Infra\Eloquent\DeveloperProjectFavoriteModel;
use App\Src\Provider\Domain\Model\ProviderProductProgrammeStatus;
use App\Src\Provider\Domain\Model\ProviderProductStatus;
use App\Src\Provider\Domain\Model\ProviderStatus;
use App\Src\Provider\Infra\Eloquent\ProductProgrammeFavoriteModel;
use App\Src\Provider\Infra\Eloquent\ProviderFavoriteModel;
use App\Src\Provider\Infra\Eloquent\ProviderProductFavoriteModel;

class UserFavoriteWebService
{
    public function getUserFavoriteCount($user_id)
    {
        $data = [];
        $provider_product_favorite_builder = ProviderProductFavoriteModel::query();
        $provider_product_favorite_builder->where('provider_product_favorite.user_id', $user_id);
        $provider_product_favorite_builder->leftJoin('provider_product', 'provider_product.id', 'provider_product_favorite.provider_product_id');
        $provider_product_favorite_builder->where('provider_product.status', ProviderProductStatus::STATUS_PASS);
        $data['product_favorite_count'] = $provider_product_favorite_builder->count();


        $developer_project_favorite_builder = DeveloperProjectFavoriteModel::query();
        $developer_project_favorite_builder->where('developer_project_favorite.user_id', $user_id);
        $developer_project_favorite_builder->leftJoin('developer_project', 'developer_project.id', 'developer_project_favorite.developer_project_id');
        $developer_project_favorite_builder->where('developer_project.status', DeveloperProjectStatus::YES);
        $data['project_favorite_count'] = $developer_project_favorite_builder->count();


        $product_programme_favorite_builder = ProductProgrammeFavoriteModel::query();
        $product_programme_favorite_builder->where('product_programme_favorite.user_id', $user_id)->count();
        $product_programme_favorite_builder->leftJoin('provider_product_programme', 'provider_product_programme.id', 'product_programme_favorite.product_programme_id');
        $product_programme_favorite_builder->where('provider_product_programme.status', ProviderProductProgrammeStatus::STATUS_PASS);
        $data['programme_favorite_count'] = $product_programme_favorite_builder->count();


        $provider_favorite_builder = ProviderFavoriteModel::query();
        $provider_favorite_builder->where('provider_favorite.user_id', $user_id);
        $provider_favorite_builder->leftJoin('provider', 'provider.id', 'provider_favorite.provider_id');
        $provider_favorite_builder->where('provider.status', ProviderStatus::YES_CERTIFIED);
        $data['provider_favorite_count'] = $provider_favorite_builder->count();
        return $data;
    }
}
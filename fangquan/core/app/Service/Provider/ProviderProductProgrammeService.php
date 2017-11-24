<?php

namespace App\Service\Provider;


use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderProductEntity;
use App\Src\Provider\Domain\Model\ProviderProductProgrammeEntity;
use App\Src\Provider\Domain\Model\ProviderProductProgrammeSpecification;
use App\Src\Provider\Domain\Model\ProviderProductProgrammeStatus;
use App\Src\Provider\Domain\Model\ProviderProductStatus;
use App\Src\Provider\Infra\Repository\ProductProgrammeFavoriteRepository;
use App\Src\Provider\Infra\Repository\ProviderProductProgrammeRepository;
use App\Src\Provider\Infra\Repository\ProviderProductRepository;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProviderProductProgrammeService
{
    /**
     * @param ProviderProductProgrammeSpecification $spec
     * @param int                                   $per_page
     * @return array
     */
    public function getProviderProductProgrammeList(ProviderProductProgrammeSpecification $spec, $per_page)
    {
        $data = [];
        $provider_product_programme_repository = new ProviderProductProgrammeRepository();
        $provider_repository = new ProviderRepository();
        $resource_repository = new ResourceRepository();
        $provider_product_programme_status = ProviderProductProgrammeStatus::acceptableEnums();
        $paginate = $provider_product_programme_repository->search($spec, $per_page);
        $items = [];

        /**
         * @var int                            $key
         * @var ProviderProductProgrammeEntity $provider_product_programme_entity
         * @var LengthAwarePaginator           $paginate
         */
        foreach ($paginate as $key => $provider_product_programme_entity) {
            $high = [];
            $low = [];

            $item = $provider_product_programme_entity->toArray();
            $product_ids = $item['product'] ?? [];
            $item['price_most'] = $this->getMostLowHighForPrice($product_ids);

            $resource_entities = $resource_repository->getResourceUrlByIds(current($item['provider_product_programme_pictures']) ?? []);

            $item['thumb_programme_picture'] = current($resource_entities)->url ?? '/www/images/provider/default_logo.png';
            $item['desc'] = str_limit($provider_product_programme_entity->desc, $limit = 110, $end = '...');

            $item['status_name'] = $provider_product_programme_status[$item['status']] ?? '';

            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($item['provider_id']);
            if (isset($provider_entity)) {
                $item['brand_name'] = $provider_entity->brand_name;
            }

            $items[] = $item;
        }

        $data['paginate'] = $paginate;
        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }

    /**
     * @param $id
     * @return array
     */
    public function getProviderProductProgrammeInfo($id)
    {
        $data = [];
        $provider_product_programme_repository = new ProviderProductProgrammeRepository();
        $provider_product_repository = new ProviderProductRepository();
        $provider_repository = new ProviderRepository();
        $resource_repository = new ResourceRepository();
        /** @var ProviderProductProgrammeEntity $provider_product_programme_entity */
        $provider_product_programme_entity = $provider_product_programme_repository->fetch($id);

        if (isset($provider_product_programme_entity)) {
            $data = $provider_product_programme_entity->toArray();
            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($data['provider_id']);
            if (isset($provider_entity)) {
                $data['brand_name'] = $provider_entity->brand_name;
                $data['company_name'] = $provider_entity->company_name;
            }

            $images = [];
            $image = [];
            $resource_entities = $resource_repository->getResourceUrlByIds(
                $provider_product_programme_entity->provider_product_programme_pictures
            );
            /** @var ResourceEntity $resource_entity */
            foreach ($resource_entities as $resource_entity) {
                $image['image_id'] = $resource_entity->id;
                $image['url'] = $resource_entity->url;
                $images[] = $image;
            }
            $data['programme_images'] = $images;

            $product_ids = $data['product'] ?? [];
            $data['price_most'] = $product_ids ? $this->getMostLowHighForPrice($product_ids) : [];

            $product_ids = $data['product'] ?? [];
            $provider_product_entities = $provider_product_repository->getProviderProductsByIds($product_ids, ProviderProductStatus::STATUS_PASS);
            /** @var ProviderProductEntity $provider_product_entity */
            $provider_product = [];
            foreach ($provider_product_entities as $key => $provider_product_entity) {
                $provider_product[] = $provider_product_entity->toArray();
                $product_resource_entities = $resource_repository->getResourceUrlByIds($provider_product_entity->provider_product_images);
                foreach ($product_resource_entities as $product_resource_entity) {
                    $provider_product[$key]['product_image_url'][] = $product_resource_entity->url;
                }
            }
            $data['provider_product_info'] = $provider_product;

            $data['has_collected'] = false;
            if (request()->user()->id) {
                $user_id = request()->user()->id;
                $product_programme_favorite_repository = new ProductProgrammeFavoriteRepository();
                $product_programme_favorite_entities =
                    $product_programme_favorite_repository->getProductProgrammeFavoriteByProgrammeIdAndUserId(
                        $user_id, $id
                    );
                if (!$product_programme_favorite_entities->isEmpty()) {
                    $data['has_collected'] = true;
                }
            }
        }


        return $data;
    }

    /**
     * 根据产品ids获取最低价和最高价
     * @param $product_ids
     * @return array
     */
    public function getMostLowHighForPrice($product_ids)
    {
        $data = [];
        $high = 0;
        $low = 0;
        if (!empty($product_ids)) {
            $provider_product_repository = new ProviderProductRepository();
            $provider_product_entities = $provider_product_repository->getProviderProductsByIds($product_ids, ProviderProductStatus::STATUS_PASS);
            foreach ($provider_product_entities as $provider_product_entity) {
                $high += $provider_product_entity->price_high;
                $low += $provider_product_entity->price_low;
            }
        }
        $data['most_low'] = $low;
        $data['most_high'] = $high;
        return $data;
    }

}


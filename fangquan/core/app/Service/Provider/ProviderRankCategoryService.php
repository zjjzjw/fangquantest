<?php

namespace App\Service\Provider;


use App\Src\Product\Domain\Model\ProductCategoryEntity;
use App\Src\Product\Infra\Repository\ProductCategoryRepository;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderImageType;
use App\Src\Provider\Domain\Model\ProviderPictureEntity;
use App\Src\Provider\Domain\Model\ProviderRankCategoryEntity;
use App\Src\Provider\Domain\Model\ProviderRankCategorySpecification;
use App\Src\Provider\Infra\Repository\ProviderPictureRepository;
use App\Src\Provider\Infra\Repository\ProviderRankCategoryRepository;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProviderRankCategoryService
{
    /**
     * @param ProviderRankCategorySpecification $spec
     * @param int                               $per_page
     * @return array
     */
    public function getProviderRankCategoryList(ProviderRankCategorySpecification $spec, $per_page)
    {
        $data = [];
        $product_category_repository = new ProductCategoryRepository();
        $provider_rank_category_repository = new ProviderRankCategoryRepository();
        $provider_repository = new ProviderRepository();
        $paginate = $provider_rank_category_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var int                        $key
         * @var ProviderRankCategoryEntity $provider_entity
         * @var LengthAwarePaginator       $paginate
         */
        foreach ($paginate as $key => $provider_rank_category_entity) {
            $item = $provider_rank_category_entity->toArray();

            /** @var ProductCategoryEntity $product_category_entity */
            $product_category_entity = $product_category_repository->fetch($item['category_id']);
            if (isset($product_category_entity)) {
                $item['category_name'] = $product_category_entity->name;
            }

            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($item['provider_id']);
            if (isset($provider_entity)) {
                $item['provider_name'] = $provider_entity->company_name;
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
    public function getProviderRankCategoryInfo($id)
    {
        $data = [];
        $provider_rank_category_repository = new ProviderRankCategoryRepository();
        $provider_repository = new ProviderRepository();
        /** @var ProviderEntity $provider_entity */
        $provider_rank_category_entity = $provider_rank_category_repository->fetch($id);
        if (isset($provider_rank_category_entity)) {
            $data = $provider_rank_category_entity->toArray();
            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($data['provider_id']);
            if (isset($provider_entity)) {
                $data['provider_name'] = $provider_entity->company_name;
            }
        }
        return $data;
    }


    /**
     * 获取品类的品牌排行榜
     * @param int $category_id
     * @param int $limit
     * @return array
     */
    public function getProviderRankByCategoryId($category_id, $limit)
    {
        $items = [];
        $provider_ids = [];
        $provider_rank_category_repository = new ProviderRankCategoryRepository();
        $provider_rank_category_entities =
            $provider_rank_category_repository->getProviderRankCategoryByCategoryId($category_id, $limit);
        /** @var ProviderRankCategoryEntity $provider_rank_category_entity */
        foreach ($provider_rank_category_entities as $provider_rank_category_entity) {
            $provider_ids[] = $provider_rank_category_entity->provider_id;
        }


        $provider_repository = new ProviderRepository();
        $provider_entities = $provider_repository->getProviderByIds($provider_ids);


        /** @var ProviderEntity $provider_entity */
        foreach ($provider_entities as $provider_entity) {
            $item = $provider_entity->toArray();

            //获取图片信息
            $provider_picture_repository = new ProviderPictureRepository();
            $resource_repository = new ResourceRepository();
            $provider_picture_entities = $provider_picture_repository->getImageByProviderId($provider_entity->id);
            $image_ids = [];
            /** @var ProviderPictureEntity $provider_picture_entity */
            foreach ($provider_picture_entities as $provider_picture_entity) {
                $image_ids[] = $provider_picture_entity->image_id;
            }
            $resource_entities = $resource_repository->getResourceUrlByIds($image_ids);
            /** @var ResourceEntity $resource_entity */
            $images = [];
            foreach ($provider_picture_entities as $provider_picture_entity) {
                $image = $provider_picture_entity->toArray();
                foreach ($resource_entities as $resource_entity) {
                    if ($provider_picture_entity->image_id == $resource_entity->id) {
                        $image['url'] = $resource_entity->url;
                    }
                }
                $images[] = $image;
            }
            $logo_images = collect($images)->where('type', ProviderImageType::LOGO)->toArray();
            $item['logo_images'] = $logo_images;
            //获取主营产品信息
            $item['logo_url'] = '/www/images/provider/default_logo.png';
            if (!empty($logo_images)) {
                $item['logo_url'] = current($logo_images)['url'] ?? '/www/images/provider/default_logo.png';
            }

            $items[] = $item;
        }
        return $items;
    }

}


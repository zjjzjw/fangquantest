<?php

namespace App\Service\Information;


use App\Service\QiNiu\QiNiuService;
use App\Src\Brand\Domain\Model\BrandEntity;
use App\Src\Brand\Infra\Repository\BrandRepository;
use App\Src\Information\Domain\Model\InformationEntity;
use App\Src\Information\Domain\Model\InformationSpecification;
use App\Src\Information\Domain\Model\InformationStatus;
use App\Src\Information\Infra\Repository\InformationRepository;
use App\Src\Product\Domain\Model\ProductEntity;
use App\Src\Product\Infra\Repository\ProductRepository;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use App\Wap\Http\Controllers\Provider\ProviderEnterpriseInfoController;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\File\File;

class InformationService
{
    /**
     * @param InformationSpecification $spec
     * @param int                      $per_page
     * @return array
     */
    public function getInformationList(InformationSpecification $spec, $per_page)
    {
        $data = [];
        $information_repository = new InformationRepository();
        $paginate = $information_repository->search($spec, $per_page);
        $information_status = InformationStatus::acceptableEnums();
        $items = [];
        /**
         * @var int                  $key
         * @var InformationEntity    $information_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $information_entity) {
            $item = $information_entity->toArray();
            $item['status_name'] = $information_status[$item['status']];
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
    public function getInformationInfo($id)
    {
        $data = [];
        $information_repository = new InformationRepository();
        $provider_repository = new ProviderRepository();
        /** @var InformationEntity $information_entity */
        $information_entity = $information_repository->fetch($id);
        $resource_repository = new ResourceRepository();
        $product_repository = new ProductRepository();
        if (isset($information_entity)) {
            $data = $information_entity->toArray();
            /** @var ProductEntity $product_entity */
            $product_entity = $product_repository->fetch($data['product_id']);
            if (isset($product_entity)) {
                $data['product_model'] = $product_entity->product_model;
            }

            foreach ($data['information_brands'] as $information_brand) {
                /** @var ProviderEntity $brand_entity */
                $brand_entity = $provider_repository->fetch($information_brand);
                $data['information_brands_name'][$information_brand] = $brand_entity->brand_name;
            }

            //得到缩略图
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($information_entity->thumbnail);
            if (isset($resource_entity)) {
                $data['thumbnail_url'] = $resource_entity->url;
                $thumbnail_images = [];
                $thumbnail_image = [];
                $thumbnail_image['image_id'] = $information_entity->thumbnail;
                $thumbnail_image['url'] = $resource_entity->url;
                $thumbnail_images[] = $thumbnail_image;
                $data['thumbnail_images'] = $thumbnail_images;
                $data['thumbnail_url'] = $resource_entity->url;
            }
        }
        return $data;
    }


    /**
     * webp 格式图片Iphone显示
     * 后台处理图片
     * @param int $id
     */
    public function processContentImage($id)
    {
        $information_repository = new InformationRepository();
        /** @var InformationEntity $information_entity */
        $information_entity = $information_repository->fetch($id);
        $content = $information_entity->content;
        $qi_niu_service = new QiNiuService();
        $images = [];
        preg_match_all("<img.*?src=\"(.*?.*?)\".*?>", $content, $match);
        if (!empty($match[1])) {
            $image_urls = $match[1];
            foreach ($image_urls as $image_url) {
                if (!str_contains($image_url, env('QINIU_URL'))) {
                    $length = strpos($image_url, '?'); //
                    if ($length && str_contains($image_url, 'webp')) {
                        $download_image_url = substr($image_url, 0, $length);
                        $file_path = download($download_image_url, 'information');
                        $result = $qi_niu_service->upload($file_path);
                        if (!empty($result['origin_url'])) {
                            $image = [];
                            $image['source_url'] = $image_url;
                            $image['target_url'] = $result['origin_url'];
                            $images[] = $image;
                        }
                        @unlink($file_path);
                    }
                }
            }
        }
        if (!empty($images)) {
            foreach ($images as $image) {
                $content = str_replace($image['source_url'], $image['target_url'], $content);
            }
        }
        $information_entity->content = $content;
        $information_repository->save($information_entity);
    }

}


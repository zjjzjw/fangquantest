<?php

namespace App\Service\Brand;


use App\Src\Brand\Domain\Model\BrandSupplementaryEntity;
use App\Src\Brand\Domain\Model\BrandSupplementarySpecification;
use App\Src\Brand\Infra\Repository\BrandSupplementaryRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class BrandSupplementaryService
{
    /**
     * @param BrandSupplementarySpecification $spec
     * @param int                             $per_page
     * @return array
     */
    public function getBrandSupplementaryList(BrandSupplementarySpecification $spec, $per_page)
    {
        $data = [];
        $brand_supplementary_repository = new BrandSupplementaryRepository();
        $paginate = $brand_supplementary_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var int                      $key
         * @var BrandSupplementaryEntity $brand_supplementary_entity
         * @var LengthAwarePaginator     $paginate
         */
        foreach ($paginate as $key => $brand_supplementary_entity) {
            $item = $brand_supplementary_entity->toArray();
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
    public function getBrandSupplementaryInfo($id)
    {
        $data = [];
        $brand_supplementary_repository = new BrandSupplementaryRepository();
        $resource_repository = new ResourceRepository();
        /** @var BrandSupplementaryEntity $brand_supplementary_entity */
        $brand_supplementary_entity = $brand_supplementary_repository->fetch($id);
        if (isset($brand_supplementary_entity)) {
            $data = $brand_supplementary_entity->toArray();
            /** @var ResourceEntity $resource_entity */
            $resource_entities = $resource_repository->getResourceUrlByIds($brand_supplementary_entity->supplementary_files);
            foreach ($resource_entities as $resource_entity) {
                if (isset($resource_entity)) {
                    $data['supplementary_url'] = $resource_entity->url;
                    $supplementary_file = [];
                    $supplementary_file['image_id'] = $resource_entity->id;
                    $supplementary_file['url'] = '/www/images/zip.jpeg';
                    $data['supplementary_file_list'][] = $supplementary_file;
                    $data['file_url'] = $resource_entity->url;
                }
            }
        }
        return $data;
    }
}


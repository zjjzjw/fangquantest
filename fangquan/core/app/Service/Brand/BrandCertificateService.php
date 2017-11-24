<?php

namespace App\Service\Brand;


use App\Src\Brand\Domain\Model\BrandCertificateEntity;
use App\Src\Brand\Domain\Model\BrandCertificateSpecification;
use App\Src\Brand\Domain\Model\BrandCertificateType;
use App\Src\Brand\Infra\Repository\BrandCertificateRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class BrandCertificateService
{
    /**
     * @param BrandCertificateSpecification $spec
     * @param int                           $per_page
     * @return array
     */
    public function getBrandCertificateList(BrandCertificateSpecification $spec, $per_page)
    {
        $data = [];
        $brand_certificate_repository = new BrandCertificateRepository();
        $paginate = $brand_certificate_repository->search($spec, $per_page);
        $brand_certificate_type = BrandCertificateType::acceptableEnums();
        $items = [];
        /**
         * @var int                    $key
         * @var BrandCertificateEntity $brand_certificate_entity
         * @var LengthAwarePaginator   $paginate
         */
        foreach ($paginate as $key => $brand_certificate_entity) {
            $item = $brand_certificate_entity->toArray();
            $item['type_name'] = $brand_certificate_type[$item['type']];
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
    public function getBrandCertificateInfo($id)
    {
        $data = [];
        $brand_certificate_repository = new BrandCertificateRepository();
        $resource_repository = new ResourceRepository();
        /** @var BrandCertificateEntity $brand_certificate_entity */
        $brand_certificate_entity = $brand_certificate_repository->fetch($id);
        if (isset($brand_certificate_entity)) {
            $data = $brand_certificate_entity->toArray();
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($brand_certificate_entity->certificate_file);
            if (isset($resource_entity)) {
                $data['certificate_url'] = $resource_entity->url;
                $certificate_files = [];
                $certificate_file = [];
                $certificate_file['image_id'] = $brand_certificate_entity->certificate_file;
                $certificate_file['url'] = '/www/images/zip.jpeg';
                $certificate_files[] = $certificate_file;
                $data['certificate_files'] = $certificate_files;
                $data['file_url'] = $resource_entity->url;
            }
        }
        return $data;
    }

    public function getBrandCertificatesByBrandId($brand_id)
    {
        $items = [];
        $brand_certificate_repository = new BrandCertificateRepository();
        $brand_certificate_entities =
            $brand_certificate_repository->getBrandCertificatesByBrandId($brand_id);
        foreach ($brand_certificate_entities as $brand_certificate_entity) {
            $item = $brand_certificate_entity->toArray();
            $items[] = $item;
        }
        return $items;
    }


    /**
     * @param int $brand_id
     */
    public function getBrandCertificateImagesByBrandId($brand_id)
    {
        $image_ids = [];
        $images = [];
        $brand_certificates = $this->getBrandCertificatesByBrandId($brand_id);
        foreach ($brand_certificates as $brand_certificate) {
            $image_ids[] = $brand_certificate['certificate_file'];
        }
        $resource_repository = new ResourceRepository();
        $resource_entities = $resource_repository->getResourceUrlByIds($image_ids);
        /** @var ResourceEntity $resource_entity */
        foreach ($resource_entities as $resource_entity) {
            if (preg_match("/^image\/(.*)$/", $resource_entity->mime_type)) {
                $images[] = $resource_entity->url;
            }
        }
        return $images;
    }

}
















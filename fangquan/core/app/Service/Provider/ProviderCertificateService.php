<?php

namespace App\Service\Provider;


use App\Src\Provider\Domain\Model\ProviderCertificateEntity;
use App\Src\Provider\Domain\Model\ProviderCertificateSpecification;
use App\Src\Provider\Domain\Model\ProviderCertificateStatus;
use App\Src\Provider\Domain\Model\ProviderCertificateType;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderPropagandaStatus;
use App\Src\Provider\Infra\Eloquent\ProviderCertificateModel;
use App\Src\Provider\Infra\Repository\ProviderCertificateRepository;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProviderCertificateService
{
    /**
     * @param ProviderCertificateSpecification $spec
     * @param int                              $per_page
     * @return array
     */
    public function getProviderCertificateList(ProviderCertificateSpecification $spec, $per_page = 20)
    {
        $data = [];
        $provider_certificate_repository = new ProviderCertificateRepository();
        $resource_repository = new ResourceRepository();
        $provider_repository = new ProviderRepository();
        $paginate = $provider_certificate_repository->search($spec, $per_page);

        $items = [];
        /**
         * @var int                       $key
         * @var ProviderCertificateEntity $provider_certificate_entity
         * @var LengthAwarePaginator      $paginate
         */
        foreach ($paginate as $key => $provider_certificate_entity) {
            $item = $provider_certificate_entity->toArray();
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($provider_certificate_entity->image_id);
            if (isset($resource_entity)) {
                $item['image_url'] = $resource_entity->url;
            }
            $provider_certificate_types = ProviderCertificateType::acceptableEnums();
            $item['type_name'] = $provider_certificate_types[$provider_certificate_entity->type] ?? '';
            $provider_certificate_status = ProviderPropagandaStatus::acceptableEnums();
            $item['status_name'] = $provider_certificate_status[$provider_certificate_entity->status] ?? '';

            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($provider_certificate_entity->provider_id);
            if (isset($provider_entity)) {
                $item['provider'] = $provider_entity->toArray();
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

    public function getProviderCertificateInfo($id)
    {
        $data = [];
        $provider_certificate_repository = new ProviderCertificateRepository();
        $provider_repository = new ProviderRepository();
        $resource_repository = new ResourceRepository();

        /** @var ProviderCertificateEntity $provider_certificate_entity */
        $provider_certificate_entity = $provider_certificate_repository->fetch($id);
        if (isset($provider_certificate_entity)) {
            $data = $provider_certificate_entity->toArray();
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($provider_certificate_entity->image_id);
            if (isset($resource_entity)) {
                $images = [];
                $image = [];
                $image['image_id'] = $provider_certificate_entity->image_id;
                $image['url'] = $resource_entity->url;
                $images[] = $image;
                $data['images'] = $images;
                $data['image_url'] = $resource_entity->url;
            }
            $provider_entity = $provider_repository->fetch($provider_certificate_entity->provider_id);
            if (isset($provider_entity)) {
                $data['provider'] = $provider_entity->toArray();
            }
            $provider_certificate_types = ProviderCertificateType::acceptableEnums();
            $data['type_name'] = $provider_certificate_types[$provider_certificate_entity->type] ?? '';

        }

        return $data;
    }

    public function getProviderCertificateByProviderId($provider_id)
    {
        $certificate_items = [];
        $provider_format_certificates = [];

        $provider_certificate_repository = new ProviderCertificateRepository();
        $resource_repository = new ResourceRepository();
        $provider_certificate_entities = $provider_certificate_repository->getProviderCertificateByProviderIdAndStatus(
            $provider_id, ProviderCertificateStatus::STATUS_PASS
        );

        foreach ($provider_certificate_entities as $provider_certificate_entity) {
            $certificate_item = [];
            $certificate_item = $provider_certificate_entity->toArray();
            $resource_entity = $resource_repository->getResourceUrlByIds($provider_certificate_entity->image_id);
            $certificate_item['image_url'] = current($resource_entity)->url ?? '';
            $certificate_items[] = $certificate_item;
        }

        $provider_certificate_types = ProviderCertificateType::acceptableEnums();

        foreach ($provider_certificate_types as $id => $name) {
            $certificate_item = [];
            $certificate_item['name'] = $name;
            $certificate_item['nodes'] = [];
            foreach ($certificate_items as $provider_certificate) {
                if ($provider_certificate['type'] == $id) {
                    $certificate_item['nodes'][] = $provider_certificate;
                }
            }
            if (!empty($certificate_item['nodes'])) {
                $provider_format_certificates[$id] = $certificate_item;
            }
        }

        return $provider_format_certificates;
    }

}


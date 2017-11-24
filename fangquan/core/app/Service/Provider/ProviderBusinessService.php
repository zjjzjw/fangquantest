<?php

namespace App\Service\Provider;

use App\Src\Provider\Domain\Model\ProviderBusinessEntity;
use App\Src\Provider\Infra\Repository\ProviderBusinessRepository;

class ProviderBusinessService
{
    public function getProviderBusinessInfo($id)
    {
        $data = [];
        $provider_business_repository = new ProviderBusinessRepository();
        /** @var ProviderBusinessEntity $provider_business_entity */
        $provider_business_entity = $provider_business_repository->getProviderBusinessByProviderId($id);
        if (isset($provider_business_entity)) {
            $data = $provider_business_entity->toArray();
            foreach ($data as $datum) {
                $key = array_keys($data, $datum)[0];
                $data['json_light'][$key] = json_decode($datum, true);
            }
        }
        return $data;
    }

}
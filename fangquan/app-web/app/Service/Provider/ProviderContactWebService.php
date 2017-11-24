<?php

namespace App\Web\Service\Provider;


use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use Auth;

class ProviderContactWebService
{

    /**
     * 联系人信息
     * @param $provider_id
     * @return array
     */
    public function getContactInfoByProviderId($provider_id)
    {
        $data = [];
        $user_id = Auth::id();
        if ($user_id) {
            $provider_repository_repository = new ProviderRepository();
            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository_repository->fetch($provider_id);
            if (isset($provider_entity)) {
                $data['contact'] = $provider_entity->contact ?? '';
                $data['website'] = $provider_entity->website ?? '';
                $data['telphone'] = $provider_entity->telphone ?? '';
                $data['fax'] = $provider_entity->fax ?? '';
                $data['service_telphone'] = $provider_entity->service_telphone ?? '';
            }
        }

        return $data;
    }

}


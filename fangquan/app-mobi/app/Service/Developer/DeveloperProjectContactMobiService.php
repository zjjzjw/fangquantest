<?php

namespace App\Mobi\Service\Developer;


use App\Service\FqUser\CheckTokenService;
use App\Src\Developer\Domain\Model\DeveloperProjectContactType;
use App\Src\Developer\Infra\Repository\DeveloperProjectContactRepository;
use App\Src\Developer\Domain\Model\DeveloperProjectContactEntity;
use App\Src\Exception\LoginException;
use App\Src\FqUser\Domain\Model\FqUserAccountType;
use App\Src\FqUser\Infra\Repository\FqUserRepository;

class DeveloperProjectContactMobiService
{

    /**
     * @param $id
     * @return array
     */
    public function getDeveloperProjectContactInfo($id)
    {
        $data = [];
        $developer_project_contact_repository = new DeveloperProjectContactRepository();
        $developer_project_contact_entity = $developer_project_contact_repository->fetch($id);
        if (isset($developer_project_contact_entity)) {
            $data = $developer_project_contact_entity->toArray();
        }
        return $data;
    }

    public function getDeveloperProjectContactByProjectId($developer_project_id)
    {
        $user_id = CheckTokenService::getUserId();
        $fq_user_repository = new FqUserRepository();
        $fq_user_entity = $fq_user_repository->getFqUserById($user_id);
        $account_type = current($fq_user_entity->mode('account_type'));
        if (!$fq_user_entity->isEmpty() && $account_type != FqUserAccountType::TYPE_FORMAL) {
            throw new LoginException('', LoginException::ERROR_NO_FORMAL_ACCOUNT);
        }
        $developer_project_contact_repository = new DeveloperProjectContactRepository();
        $developer_project_contact_entities = $developer_project_contact_repository->getDeveloperProjectContactListByProjectId(
            $developer_project_id
        );
        $items = [];
        $developer_project_contact_types = DeveloperProjectContactType::acceptableEnums();
        foreach ($developer_project_contact_types as $key => $name) {
            $item['id'] = $key;
            $item['type'] = $name;
            $item['contacts'] = [];
            /** @var DeveloperProjectContactEntity $developer_project_contact_entity */
            foreach ($developer_project_contact_entities as $developer_project_contact_entity) {
                if ($developer_project_contact_entity->type == $key) {
                    $contact = [];
                    $contact['id'] = $developer_project_contact_entity->id;
                    $contact['type'] = $name;
                    $contact['company_name'] = $developer_project_contact_entity->company_name;
                    $contact['contact_name'] = $developer_project_contact_entity->contact_name;
                    $contact['job'] = $developer_project_contact_entity->job;
                    $contact['address'] = $developer_project_contact_entity->address;
                    $contact['telphone'] = $developer_project_contact_entity->telphone;
                    $contact['mobile'] = $developer_project_contact_entity->mobile;
                    $contact['remark'] = $developer_project_contact_entity->remark;
                    $item['contacts'][] = $contact;
                }
            }
            $items[] = $item;
        }
        return $items;
    }
}


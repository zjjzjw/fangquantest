<?php

namespace App\Service\Developer;


use App\Src\Developer\Domain\Model\DeveloperProjectContactType;
use App\Src\Developer\Domain\Model\DeveloperProjectContactVisitLogEntity;
use App\Src\Developer\Infra\Repository\DeveloperProjectContactRepository;
use App\Src\Developer\Domain\Model\DeveloperProjectContactEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectContactSpecification;
use App\Src\Developer\Infra\Repository\DeveloperProjectContactVisitLogRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class DeveloperProjectContactService
{
    /**
     * @param DeveloperProjectContactSpecification $spec
     * @param int                                  $per_page
     * @return array
     */
    public function getDeveloperProjectContactList(DeveloperProjectContactSpecification $spec, $per_page)
    {
        $data = [];
        $developer_project_contact_repository = new DeveloperProjectContactRepository();
        $paginate = $developer_project_contact_repository->search($spec, $per_page);
        $developer_project_contact_type = DeveloperProjectContactType::acceptableEnums();
        $items = [];
        /**
         * @var int                           $key
         * @var DeveloperProjectContactEntity $developer_project_contact_entity
         * @var LengthAwarePaginator          $paginate
         */
        foreach ($paginate as $key => $developer_project_contact_entity) {
            $item = $developer_project_contact_entity->toArray();
            $item['type_name'] = $developer_project_contact_type[$item['type']];
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

    /**
     * 得到项目联系人
     * @param int $developer_project_id
     * @return array
     */
    public function getDeveloperProjectContactInfoByProjectId($developer_project_id)
    {
        $items = [];
        $developer_project_contact_repository = new DeveloperProjectContactRepository();
        $developer_project_contact_type = DeveloperProjectContactType::acceptableEnums();
        $developer_project_contact_entities = $developer_project_contact_repository->getDeveloperProjectContactListByProjectId($developer_project_id);
        /** @var DeveloperProjectContactEntity $developer_project_contact_entity */
        foreach ($developer_project_contact_entities as $developer_project_contact_entity) {
            $item = $developer_project_contact_entity->toArray();
            $item['type_name'] = $developer_project_contact_type[$item['type']];
            $items[] = $item;
        }
        return $items;
    }

    /**
     * 格式化项目联系人
     * @param array $contacts
     * @return array
     */
    public function formatProjectContact($contacts)
    {
        $items = [];
        $developer_project_contact_types = DeveloperProjectContactType::acceptableEnums();
        foreach ($developer_project_contact_types as $key => $name) {
            $item = [];
            $item['type'] = $key;
            $item['type_name'] = $name;
            $item['nodes'] = [];
            foreach ($contacts as $contact) {
                if ($contact['type'] == $key) {
                    $item['nodes'][] = $contact;
                }
            }
            if (!empty($item['nodes'])) {
                $items[] = $item;
            }
        }
        return $items;
    }

    /**
     * 保存获取项目联系人log记录
     * @param int $developer_project_id
     */
    public function storeDeveloperProjectContactVisitLog($developer_project_id)
    {
        $fq_user = request()->user();
        $use_id = $fq_user->id;
        $developer_project_contact_visit_log_repository = new DeveloperProjectContactVisitLogRepository();
        $developer_project_contact_visit_log_entity =
            $developer_project_contact_visit_log_repository->getProjectContractVisitLogByProjectIdAndUserId(
                $developer_project_id, $use_id
            );
        if (!isset($developer_project_contact_visit_log_entity)) {
            $developer_project_contact_visit_log_entity = new DeveloperProjectContactVisitLogEntity();
            $developer_project_contact_visit_log_entity->user_id = $fq_user->id;
            $developer_project_contact_visit_log_entity->developer_project_id = $developer_project_id;
            $developer_project_contact_visit_log_entity->role_type = $fq_user->role_type;
            $developer_project_contact_visit_log_entity->role_id = $fq_user->role_id;
            $developer_project_contact_visit_log_repository->save($developer_project_contact_visit_log_entity);
        }
    }

}


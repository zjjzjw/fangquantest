<?php

namespace App\Service\Role;


use App\Admin\Src\Forms\Form;
use App\Service\Card\CardService;
use App\Src\Company\Domain\Model\CompanyEntity;
use App\Src\Company\Infra\Repository\CompanyRepository;
use App\Src\Role\Domain\Model\DataType;
use App\Src\Role\Domain\Model\UserDataEntity;
use App\Src\Role\Domain\Model\UserEntity;
use App\Src\Role\Domain\Model\UserFeedbackEntity;
use App\Src\Role\Domain\Model\UserFeedbackSpecification;
use App\Src\Role\Infra\Eloquent\UserModel;
use App\Src\Role\Infra\Repository\UserDataRepository;
use App\Src\Role\Infra\Repository\UserFeedbackRepository;
use App\Src\Role\Infra\Repository\UserRepository;

class UserFeedbackService
{
    /**
     * @param UserFeedbackSpecification $spec
     * @param int                       $per_page
     * @return array
     */
    public function getUserFeedbackList(UserFeedbackSpecification $spec, $per_page)
    {
        $data = [];
        $user_feedback_repository = new UserFeedbackRepository();
        $paginate = $user_feedback_repository->search($spec, $per_page);
        $items = [];
        $user_repository = new UserRepository();
        $company_repository = new CompanyRepository();
        /**
         * @var mixed              $key
         * @var UserFeedbackEntity $user_feedback_entity
         */
        foreach ($paginate as $key => $user_feedback_entity) {
            $item = $user_feedback_entity->toArray();
            /** @var UserEntity $user_entity */
            $user_entity = $user_repository->fetch($user_feedback_entity->user_id);
            if (isset($user_entity)) {
                $item['user_name'] = $user_entity->name;
                /** @var CompanyEntity $company_entity */
                $company_entity = $company_repository->fetch($user_entity->company_id);
                if ($company_entity) {
                    $item['company_name'] = $company_entity->name;
                }
            }
            $item['created_at'] = $user_feedback_entity->created_at->format('Y-m-d H:i');
            $paginate[$key] = $item;
            $items[] = $item;
        }
        $data['paginate'] = $paginate;
        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();
        return $data;
    }

}


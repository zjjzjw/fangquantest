<?php namespace App\Service\FqUser;

use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Src\FqUser\Domain\Model\FqUserFeedbackEntity;
use App\Src\FqUser\Domain\Model\FqUserFeedbackSpecification;
use App\Src\FqUser\Domain\Model\FqUserFeedbackStatus;
use App\Src\FqUser\Infra\Repository\FqUserFeedbackRepository;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class FqUserFeedbackService
{
    /**
     * @param FqUserFeedbackSpecification $spec
     * @param int                         $per_page
     * @return array
     */
    public function getFqUserFeedbackList(FqUserFeedbackSpecification $spec, $per_page = 20)
    {
        $data = [];
        $fq_user_feedback_repository = new FqUserFeedbackRepository();
        $fq_user_repository = new FqUserRepository();
        $paginate = $fq_user_feedback_repository->search($spec, $per_page);
        $items = [];

        /**
         * @var int                  $key
         * @var FqUserFeedbackEntity $fq_user_feedback_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $fq_user_feedback_entity) {
            $item = $fq_user_feedback_entity->toArray();
            /** @var FqUserEntity $fq_user_entity */
            $fq_user_entity = $fq_user_repository->fetch($item['fq_user_id']);
            if (isset($fq_user_entity)) {
                $item['fq_user_name'] = $fq_user_entity->nickname;
            }
            $status = FqUserFeedbackStatus::acceptableEnums();
            $item['status_name'] = $status[$fq_user_feedback_entity->status] ?? '';

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
    public function getFqUserFeedbackInfoById($id)
    {
        $data = [];
        $fq_user_feedback_repository = new FqUserFeedbackRepository();
        $fq_user_repository = new FqUserRepository();
        /** @var FqUserFeedbackEntity $fq_user_feedback_entity */
        $fq_user_feedback_entity = $fq_user_feedback_repository->fetch($id);
        if (isset($fq_user_feedback_entity)) {
            $data = $fq_user_feedback_entity->toArray();
            /** @var FqUserEntity $fq_user_entity */
            $fq_user_entity = $fq_user_repository->fetch($data['fq_user_id']);
            if (isset($fq_user_entity)) {
                $data['fq_user_name'] = $fq_user_entity->nickname;
            }
            $status = FqUserFeedbackStatus::acceptableEnums();
            $data['status_name'] = $status[$fq_user_feedback_entity->status] ?? '';
        }
        return $data;
    }

}
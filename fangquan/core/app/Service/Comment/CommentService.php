<?php

namespace App\Service\Comment;


use App\Src\Brand\Infra\Repository\CommentRepository;
use App\Src\Brand\Domain\Model\CommentEntity;
use App\Src\Brand\Domain\Model\CommentSpecification;
use App\Src\Role\Infra\Repository\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentService
{
    /**
     * @param CommentSpecification $spec
     * @param int                  $per_page
     * @return array
     */
    public function getCommentList(CommentSpecification $spec, $per_page)
    {
        $data = [];
        $comment_repository = new CommentRepository();
        $paginate = $comment_repository->search($spec, $per_page);
        $user_repository = new UserRepository();
        $items = [];
        /**
         * @var int                  $key
         * @var CommentEntity        $comment_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $comment_entity) {
            $item = $comment_entity->toArray();
            $user_entity = $user_repository->fetch($item['user_id']);
            if(isset($user_entity)){
                $item['user_name'] = $user_entity->name;
            }
            $item['time_ago'] = time_ago($item['created_at']);
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
    public function getCommentInfo($id)
    {
        $data = [];
        $comment_repository = new CommentRepository();
        /** @var CommentEntity $comment_entity */
        $comment_entity = $comment_repository->fetch($id);
        if (isset($comment_entity)) {
            $data = $comment_entity->toArray();
        }
        return $data;
    }
}


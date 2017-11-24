<?php

namespace App\Service\Msg;


use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use App\Src\Msg\Domain\Model\MsgExtEntity;
use App\Src\Msg\Domain\Model\MsgStatus;
use App\Src\Msg\Domain\Model\UserMsgEntity;
use App\Src\Msg\Domain\Model\UserMsgSpecification;
use App\Src\Msg\Infra\Repository\MsgExtRepository;
use App\Src\Msg\Infra\Repository\UserMsgRepository;
use App\Src\Role\Domain\Model\UserEntity;
use App\Src\Role\Infra\Repository\UserRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserMsgService
{
    /**
     * @param UserMsgSpecification $spec
     * @param int                  $per_page
     * @return array
     */
    public function getUserMsgList(UserMsgSpecification $spec, $per_page)
    {
        $data = [];
        $user_msg_repository = new UserMsgRepository();
        $msg_status = MsgStatus::acceptableEnums();
        $msg_ext_repository = new MsgExtRepository();
        $user_repository = new UserRepository();
        $fq_user_repository = new FqUserRepository();
        $resource_repository = new ResourceRepository();
        $paginate = $user_msg_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var int                  $key
         * @var UserMsgEntity        $user_msg_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $user_msg_entity) {
            $item = $user_msg_entity->toArray();

            $item['status_name'] = $msg_status[$item['status']];
            /** @var MsgExtEntity $msg_ext_entity */
            $msg_ext_entity = $msg_ext_repository->fetch($item['msg_id']);
            if (isset($msg_ext_entity)) {
                $msg_ext_content = json_decode($msg_ext_entity->content, true);
                $item['info'] = $msg_ext_content['content'] ?? '';
                $item['title'] = $msg_ext_content['title'] ?? '';
                $item['images'] = [];
                if (!empty($msg_ext_content['images'])) {
                    $resource_entities = $resource_repository->getResourceUrlByIds($msg_ext_content['images']);
                    /** @var ResourceEntity $resource_entity */
                    foreach ($resource_entities as $resource_entity) {
                        $item['images'][] = $resource_entity->url;
                    }
                }
            }
            /** @var UserEntity $user_entity */
            $user_entity = $user_repository->fetch($item['from_uid']);
            if (isset($user_entity)) {
                $item['from_user_name'] = $user_entity->name;
            }

            /** @var FqUserEntity $fq_user_entity */
            $fq_user_entity = $fq_user_repository->fetch($item['to_uid']);
            if (isset($fq_user_entity)) {
                $item['to_user_name'] = $fq_user_entity->account;
            }
            $item['time'] = time_ago($msg_ext_entity->created_at->toDateTimeString());
            $items[] = $item;
        }
        $data['paginate'] = $paginate;
        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }


    public function getUserMsgInfo($id)
    {
        $data = [];
        $user_msg_repository = new UserMsgRepository();
        $msg_ext_repository = new MsgExtRepository();
        $resource_repository = new ResourceRepository();
        $fq_user_repository = new FqUserRepository();
        $user_msg_entity = $user_msg_repository->fetch($id);
        if (isset($user_msg_entity)) {
            $data = $user_msg_entity->toArray();

            /** @var MsgExtEntity $msg_ext_entity */
            $msg_ext_entity = $msg_ext_repository->fetch($data['msg_id']);
            if (isset($msg_ext_entity)) {
                $msg_ext = json_decode($msg_ext_entity->content, true);
                $data['content'] = $msg_ext['content'] ?? '';
                $data['title'] = $msg_ext['title'] ?? '';
                $data['images'] = $msg_ext['images'] ?? [];
                $images = [];
                $image = [];
                $resource_entities = $resource_repository->getResourceUrlByIds($data['images']);
                /** @var ResourceEntity $resource_entity */
                foreach ($resource_entities as $resource_entity) {
                    $image['image_id'] = $resource_entity->id;
                    $image['url'] = $resource_entity->url;
                    $images[] = $image;
                }
                $data['msg_images'] = $images;
            }
            /** @var FqUserEntity $fq_user_entity */
            $fq_user_entity = $fq_user_repository->fetch($data['to_uid']);
            if (isset($fq_user_entity)) {
                $data['to_user_name'] = $fq_user_entity->account;
                $data['to_user_mobile'] = $fq_user_entity->mobile;
            }
        }
        return $data;
    }

    public function getUnreadMsgCount($user_id)
    {
        $user_msg_repository = new UserMsgRepository();
        $count = $user_msg_repository->getMsgCount($user_id, null, MsgStatus::NOT_READ);
        return $count;
    }

}


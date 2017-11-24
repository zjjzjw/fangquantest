<?php

namespace App\Service\Msg;


use App\Src\Msg\Domain\Model\BroadcastMsgEntity;
use App\Src\Msg\Domain\Model\BroadcastMsgSpecification;
use App\Src\Msg\Domain\Model\BroadcastMsgStatus;
use App\Src\Msg\Domain\Model\MsgExtEntity;
use App\Src\Msg\Domain\Model\MsgStatus;
use App\Src\Msg\Domain\Model\MsgType;
use App\Src\Msg\Infra\Repository\BroadcastMsgRepository;
use App\Src\Msg\Infra\Repository\MsgExtRepository;
use App\Src\Role\Domain\Model\UserEntity;
use App\Src\Role\Infra\Repository\UserRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class BroadcastMsgService
{
    /**
     * @param BroadcastMsgSpecification $spec
     * @param int                  $per_page
     * @return array
     */
    public function getBroadcastMsgList(BroadcastMsgSpecification $spec, $per_page)
    {
        $data = [];
        $broadcast_msg_repository = new BroadcastMsgRepository();
        $msg_status = BroadcastMsgStatus::acceptableEnums();
        $msg_type = MsgType::acceptableEnums();
        $msg_ext_repository = new MsgExtRepository();
        $user_repository = new UserRepository();
        $paginate = $broadcast_msg_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var int                  $key
         * @var BroadcastMsgEntity        $user_msg_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $broadcast_msg_entity) {
            $item = $broadcast_msg_entity->toArray();

            $item['status_name'] = $msg_status[$item['status']];
            $item['mag_type_name'] = $msg_type[$item['msg_type']];
            /** @var MsgExtEntity $msg_ext_entity */
            $msg_ext_entity = $msg_ext_repository->fetch($item['msg_id']);
            if (isset($msg_ext_entity)) {
                $msg_ext = json_decode($msg_ext_entity->content, true);
                $item['content'] = $msg_ext['content'] ?? '';
                $item['title'] = $msg_ext['title'] ?? '';
                $item['image'] = $msg_ext['image'] ?? 0;
            }

            /** @var UserEntity $user_entity */
            $user_entity = $user_repository->fetch($item['from_uid']);
            if (isset($user_entity)) {
                $item['from_user_name'] = $user_entity->name;
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


    public function getBroadcastMsgInfo($id)
    {
        $data = [];
        $user_msg_repository = new BroadcastMsgRepository();
        $msg_ext_repository = new MsgExtRepository();
        $resource_repository = new ResourceRepository();
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
        }
        return $data;
    }

}


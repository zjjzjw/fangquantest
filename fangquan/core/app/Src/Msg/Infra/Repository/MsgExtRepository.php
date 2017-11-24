<?php namespace App\Src\Msg\Infra\Repository;

use Carbon\Carbon;
use App\Foundation\Domain\Repository;
use App\Src\Msg\Domain\Interfaces\BroadcastMsgInterface;
use App\Src\Msg\Domain\Interfaces\MsgExtInterface;
use App\Src\Msg\Domain\Model\MsgExtEntity;
use App\Src\Msg\Infra\Eloquent\MsgExtModel;


class MsgExtRepository extends Repository implements MsgExtInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param MsgExtEntity $msg_ext_entity
     */
    protected function store($msg_ext_entity)
    {
        if ($msg_ext_entity->isStored()) {
            $model = MsgExtModel::find($msg_ext_entity->id);
        } else {
            $model = new MsgExtModel();
        }

        $model->fill(
            [
                'content'  => $msg_ext_entity->content,
                'msg_type' => $msg_ext_entity->msg_type,
            ]
        );
        $model->save();
        $msg_ext_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return MsgExtModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = MsgExtModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param MsgExtModel $model
     *
     * @return MsgExtEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new MsgExtEntity();
        $entity->id = $model->id;
        $entity->content = $model->content;
        $entity->msg_type = $model->msg_type;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param int|array $id
     */
    public function delete($id)
    {
        $builder = MsgExtModel::query();
        $builder->whereIn('id', (array)$id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }
}
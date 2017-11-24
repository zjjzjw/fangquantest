<?php namespace App\Src\Provider\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Provider\Domain\Model\ProviderFriendEntity;
use App\Src\Provider\Domain\Model\ProviderFriendSpecification;
use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Src\Provider\Infra\Eloquent\ProviderFriendModel;


class ProviderFriendRepository extends Repository
{
    /**
     * Store an entity into persistence.
     *
     * @param ProviderFriendEntity $provider_friend_entity
     */
    protected function store($provider_friend_entity)
    {
        if ($provider_friend_entity->isStored()) {
            $model = ProviderFriendModel::find($provider_friend_entity->id);
        } else {
            $model = new ProviderFriendModel();
        }
        $model->fill(
            [
                'id'          => $provider_friend_entity->id,
                'provider_id' => $provider_friend_entity->provider_id,
                'name'        => $provider_friend_entity->name,
                'logo'        => $provider_friend_entity->logo,
                'link'        => $provider_friend_entity->link,
                'status'      => $provider_friend_entity->status,
            ]
        );
        $model->save();
        $provider_friend_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return \App\Src\provider\Domain\Model\ProviderFriendEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProviderFriendModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return \App\Src\provider\Domain\Model\ProviderFriendEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new providerFriendEntity();
        $entity->id = $model->id;
        $entity->provider_id = $model->provider_id;
        $entity->name = $model->name;
        $entity->logo = $model->logo;
        $entity->link = $model->link;
        $entity->status = $model->status;
        $entity->created_at = $model->created_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }


    /**
     * @param ProviderFriendSpecification $spec
     * @return mixed
     */
    public function search(ProviderFriendSpecification $spec, $per_page = 20)
    {
        $builder = ProviderFriendModel::query();
        if ($spec->provider_id) {
            $builder->where('provider_id', $spec->provider_id);
        }

        if ($spec->status) {
            $builder->where('status', $spec->status);
        }

        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }
        $builder->orderBy('id', 'desc');

        if ($spec->page) {
            $paginator = $builder->paginate($per_page, ['*'], 'page', $spec->page);
        } else {
            $paginator = $builder->paginate($per_page);
        }

        foreach ($paginator as $key => $model) {
            $paginator[$key] = $this->reconstituteFromModel($model)->stored();
        }
        return $paginator;
    }

    /**
     * @param array|int $id
     */
    public function delete($id)
    {
        $builder = ProviderFriendModel::query();
        $builder->whereIn('id', (array)$id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function all()
    {
        $collect = collect();
        $builder = ProviderFriendModel::query();
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param int       $provider_id
     * @param int|array $status
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderFriendByProviderAndStatus($provider_id, $status)
    {
        $collect = collect();
        $builder = ProviderFriendModel::query();
        $builder->where('provider_id', $provider_id);
        $builder->whereIn('status', (array)$status);

        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


}
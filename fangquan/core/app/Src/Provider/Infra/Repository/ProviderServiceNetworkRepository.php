<?php namespace App\Src\Provider\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Provider\Domain\Interfaces\ProviderServiceNetworkInterface;
use App\Src\Provider\Domain\Model\ProviderServiceNetworkEntity;
use App\Src\Provider\Domain\Model\ProviderServiceNetworkSpecification;
use App\Src\Provider\Infra\Eloquent\ProviderServiceNetworkModel;

class ProviderServiceNetworkRepository extends Repository implements ProviderServiceNetworkInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  ProviderServiceNetworkEntity $provider_service_network_entity
     */
    protected function store($provider_service_network_entity)
    {
        if ($provider_service_network_entity->isStored()) {
            $model = ProviderServiceNetworkModel::find($provider_service_network_entity->id);
        } else {
            $model = new ProviderServiceNetworkModel();
        }
        $model->fill(
            [
                'name'         => $provider_service_network_entity->name,
                'provider_id'  => $provider_service_network_entity->provider_id,
                'province_id'  => $provider_service_network_entity->province_id,
                'city_id'      => $provider_service_network_entity->city_id,
                'address'      => $provider_service_network_entity->address,
                'worker_count' => $provider_service_network_entity->worker_count,
                'contact'      => $provider_service_network_entity->contact,
                'telphone'     => $provider_service_network_entity->telphone,
                'status'       => $provider_service_network_entity->status,
            ]
        );
        $model->save();
        $provider_service_network_entity->setIdentity($model->id);
    }

    /**
     * @param ProviderServiceNetworkSpecification $spec
     * @param int                                 $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ProviderServiceNetworkSpecification $spec, $per_page = 20)
    {
        $builder = ProviderServiceNetworkModel::query();
        if ($spec->provider_id) {
            $builder->where('provider_id', $spec->provider_id);
        }
        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }
        if ($spec->status) {
            $builder->where('status', (array)$spec->status);
        }
        if ($spec->province_id) {
            $builder->whereIn('province_id', (array)$spec->province_id);
        }

        $builder->orderBy('created_at', 'desc');
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
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return ProviderServiceNetworkEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProviderServiceNetworkModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return ProviderServiceNetworkEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProviderServiceNetworkEntity();
        $entity->id = $model->id;
        $entity->name = $model->name;
        $entity->provider_id = $model->provider_id;
        $entity->province_id = $model->province_id;
        $entity->city_id = $model->city_id;
        $entity->address = $model->address;
        $entity->worker_count = $model->worker_count;
        $entity->contact = $model->contact;
        $entity->telphone = $model->telphone;
        $entity->status = $model->status;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param int       $provider_id
     * @param int|array $status
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderServiceNetworkByProviderIdAndStatus($provider_id, $status)
    {
        $collect = collect();
        $builder = ProviderServiceNetworkModel::query();
        $builder->where('provider_id', $provider_id);
        if (!empty($status)) {
            $builder->where('status', (array)$status);
        }
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


    public function getProviderServiceNetworkBySpec(ProviderServiceNetworkSpecification $spec)
    {
        $collect = collect();
        $builder = ProviderServiceNetworkModel::query();
        if ($spec->provider_id) {
            $builder->where('provider_id', $spec->provider_id);
        }
        if ($spec->status) {
            $builder->whereIn('status', (array)$spec->status);
        }
        if ($spec->province_id) {
            $builder->whereIn('province_id', (array)$spec->province_id);
        }
        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }

        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param int|array $ids
     */
    public function delete($ids)
    {
        $builder = ProviderServiceNetworkModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

}

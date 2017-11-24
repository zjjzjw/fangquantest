<?php namespace App\Src\Provider\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Provider\Domain\Interfaces\ProviderCertificateInterface;
use App\Src\Provider\Domain\Model\ProviderCertificateEntity;
use App\Src\Provider\Domain\Model\ProviderCertificateSpecification;
use App\Src\Provider\Infra\Eloquent\ProviderCertificateModel;
use App\Src\Role\Infra\Eloquent\PermissionModel;
use Mockery\Matcher\Type;

class ProviderCertificateRepository extends Repository implements ProviderCertificateInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  ProviderCertificateEntity $provider_certificate_entity
     */
    protected function store($provider_certificate_entity)
    {
        if ($provider_certificate_entity->isStored()) {
            $model = ProviderCertificateModel::find($provider_certificate_entity->id);
        } else {
            $model = new ProviderCertificateModel();
        }
        $model->fill(
            [
                'provider_id' => $provider_certificate_entity->provider_id,
                'name'        => $provider_certificate_entity->name,
                'image_id'    => $provider_certificate_entity->image_id,
                'type'        => $provider_certificate_entity->type,
                'status'      => $provider_certificate_entity->status,
            ]
        );
        $model->save();
        $provider_certificate_entity->setIdentity($model->id);
    }

    public function search(ProviderCertificateSpecification $spec, $per_page = 10)
    {
        $builder = ProviderCertificateModel::query();
        if ($spec->provider_id) {
            $builder->where('provider_id', $spec->provider_id);
        }
        if ($spec->status) {
            $builder->whereIn('status', (array)$spec->status);
        }
        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
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

    public function all()
    {
        $collect = collect();
        $builder = PermissionModel::query();
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param $model
     * @return ProviderCertificateEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProviderCertificateEntity();
        $entity->id = $model->id;
        $entity->provider_id = $model->provider_id;
        $entity->name = $model->name;
        $entity->image_id = $model->image_id;
        $entity->type = $model->type;
        $entity->status = $model->status;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param int            $provider_id
     * @param array|int      $status
     * @param null|array|int $type
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderCertificateByProviderIdAndStatus($provider_id, $status, $type = null)
    {
        $collect = collect();
        $builder = ProviderCertificateModel::query();
        $builder->where('provider_id', $provider_id);
        if ($status) {
            $builder->where('status', (array)$status);
        }
        if ($type) {
            $builder->where('type', (array)$type);
        }
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param array|int $id
     */
    public function delete($id)
    {
        $builder = ProviderCertificateModel::query();
        $builder->whereIn('id', (array)$id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return ProviderCertificateEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProviderCertificateModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

}
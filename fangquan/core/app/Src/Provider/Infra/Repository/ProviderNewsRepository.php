<?php namespace App\Src\Provider\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Provider\Domain\Interfaces\ProviderNewsInterface;
use App\Src\Provider\Domain\Model\ProviderNewsEntity;
use App\Src\Provider\Domain\Model\ProviderNewsSpecification;
use App\Src\Provider\Infra\Eloquent\ProviderNewsModel;

class ProviderNewsRepository extends Repository implements ProviderNewsInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  ProviderNewsEntity $provider_news_entity
     */
    protected function store($provider_news_entity)
    {
        if ($provider_news_entity->isStored()) {
            $model = ProviderNewsModel::find($provider_news_entity->id);
        } else {
            $model = new ProviderNewsModel();
        }
        $model->fill(
            [
                'provider_id' => $provider_news_entity->provider_id,
                'title'       => $provider_news_entity->title,
                'content'     => $provider_news_entity->content,
                'status'      => $provider_news_entity->status,
            ]
        );
        $model->save();
        $provider_news_entity->setIdentity($model->id);
    }

    /**
     * @param ProviderNewsSpecification $spec
     * @param int                       $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator]
     */
    public function search(ProviderNewsSpecification $spec, $per_page = 20)
    {
        $builder = ProviderNewsModel::query();
        if ($spec->provider_id) {
            $builder->where('provider_id', $spec->provider_id);
        }
        if ($spec->status) {
            $builder->where('status', $spec->status);
        }

        if ($spec->keyword) {
            $builder->where('title', 'like', '%' . $spec->keyword . '%');
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
     * @return ProviderNewsEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProviderNewsModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return ProviderNewsEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProviderNewsEntity();
        $entity->id = $model->id;
        $entity->provider_id = $model->provider_id;
        $entity->title = $model->title;
        $entity->content = $model->content;
        $entity->status = $model->status;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param int       $provider_id
     * @param array|int $status
     * @param           $limit
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderNewsByProviderId($provider_id, $status, $limit = null)
    {
        $collect = collect();
        $builder = ProviderNewsModel::query();
        $builder->where('provider_id', $provider_id);
        if (!empty($status)) {
            $builder->whereIn('status', (array)$status);
        }
        if (!empty($limit)) {
            $builder->limit($limit);
        }

        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param array|int $id
     * @return mixed|void
     */
    public function delete($id)
    {
        $builder = ProviderNewsModel::query();
        $builder->where('id', $id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

}
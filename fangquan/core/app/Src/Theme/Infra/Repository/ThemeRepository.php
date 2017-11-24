<?php namespace App\Src\Theme\Infra\Repository;

use App\Src\Theme\Domain\Model\ThemeSpecification;
use App\Foundation\Domain\Repository;
use App\Src\Theme\Domain\Interfaces\ThemeInterface;
use App\Src\Theme\Domain\Model\ThemeEntity;
use App\Src\Theme\Infra\Eloquent\ThemeModel;


class ThemeRepository extends Repository implements ThemeInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ThemeEntity $theme_entity
     */
    protected function store($theme_entity)
    {
        if ($theme_entity->isStored()) {
            $model = ThemeModel::find($theme_entity->id);
        } else {
            $model = new ThemeModel();
        }

        $model->fill(
            [
                'name'            => $theme_entity->name,
                'type'            => $theme_entity->type,
                'order'           => $theme_entity->order,
                'created_user_id' => $theme_entity->created_user_id,
            ]
        );
        $model->save();
        $theme_entity->setIdentity($model->id);
    }

    /**
     * @param ThemeSpecification $spec
     * @param int                $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ThemeSpecification $spec, $per_page = 10)
    {
        $builder = ThemeModel::query();

        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }

        if ($spec->type) {
            $builder->where('type', $spec->type);
        }

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
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ThemeModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ThemeModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ThemeModel $model
     *
     * @return ThemeEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ThemeEntity();
        $entity->id = $model->id;

        $entity->name = $model->name;
        $entity->type = $model->type;
        $entity->order = $model->order;
        $entity->created_user_id = $model->created_user_id;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param int|array $ids
     */
    public function delete($ids)
    {
        $builder = ThemeModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param $type
     * @return array|\Illuminate\Support\Collection
     */
    public function getThemeListsByType($type, $limit = null)
    {
        $collection = collect();
        $builder = ThemeModel::query();
        $builder->where('type', $type);
        if ($limit) {
            $builder->limit($limit);
        }
        $builder->orderBy('order');
        $models = $builder->get();
        /** @var ThemeModel $model */
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }
}
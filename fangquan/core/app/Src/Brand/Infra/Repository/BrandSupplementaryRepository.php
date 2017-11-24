<?php namespace App\Src\Brand\Infra\Repository;

use App\Src\Brand\Domain\Model\BrandSupplementarySpecification;
use App\Foundation\Domain\Repository;
use App\Src\Brand\Domain\Interfaces\BrandSupplementaryInterface;
use App\Src\Brand\Domain\Model\BrandSupplementaryEntity;
use App\Src\Brand\Infra\Eloquent\BrandSupplementaryFileModel;
use App\Src\Brand\Infra\Eloquent\BrandSupplementaryModel;


class BrandSupplementaryRepository extends Repository implements BrandSupplementaryInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param BrandSupplementaryEntity $brand_supplementary_entity
     */
    protected function store($brand_supplementary_entity)
    {
        if ($brand_supplementary_entity->isStored()) {
            $model = BrandSupplementaryModel::find($brand_supplementary_entity->id);
        } else {
            $model = new BrandSupplementaryModel();
        }

        $model->fill(
            [
                'brand_id' => $brand_supplementary_entity->brand_id,
                'desc'     => $brand_supplementary_entity->desc,
            ]
        );
        $model->save();
        if (!empty($brand_supplementary_entity->supplementary_files)) {
            $this->saveSupplementaryFiles($model, $brand_supplementary_entity->supplementary_files);
        }
        $brand_supplementary_entity->setIdentity($model->id);
    }


    /**
     * @param BrandSupplementaryModel $model
     * @param                         $supplementary_files
     */
    protected function saveSupplementaryFiles($model, $supplementary_files)
    {
        $item = [];
        $this->deleteSupplementaryFiles($model->id);
        foreach ($supplementary_files as $supplementary_file) {
            $item[] = new BrandSupplementaryFileModel([
                'file_id' => $supplementary_file,
            ]);
        }
        $model->supplementary_files()->saveMany($item);
    }

    protected function deleteSupplementaryFiles($id)
    {
        $brand_supplementary_file_query = BrandSupplementaryFileModel::query();
        $brand_supplementary_file_query->where('brand_supplementary_id', $id);
        $brand_supplementary_file_models = $brand_supplementary_file_query->get();
        foreach ($brand_supplementary_file_models as $brand_supplementary_file_model) {
            $brand_supplementary_file_model->delete();
        }
    }

    /**
     * @param BrandSupplementarySpecification $spec
     * @param int                             $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(BrandSupplementarySpecification $spec, $per_page = 10)
    {
        $builder = BrandSupplementaryModel::query();

        if ($spec->keyword) {
            $builder->where('desc', 'like', '%' . $spec->keyword . '%');
        }

        if ($spec->brand_id) {
            $builder->where('brand_id', $spec->brand_id);
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
     * @return BrandSupplementaryModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = BrandSupplementaryModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param BrandSupplementaryModel $model
     *
     * @return BrandSupplementaryEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new BrandSupplementaryEntity();
        $entity->id = $model->id;

        $entity->brand_id = $model->brand_id;
        $entity->desc = $model->desc;
        $entity->supplementary_files = $model->supplementary_files->pluck('file_id')->toArray();
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
        $builder = BrandSupplementaryModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $supplementary_files = $model->supplementary_files->pluck('file_id')->toArray();
            if (!empty($supplementary_files)) {
                $this->deleteSupplementaryFiles($model->id);
            }
            $model->delete();
        }
    }

    /**
     * @param $brand_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getBrandSupplementaryByBrandId($brand_id)
    {
        $collect = collect();
        $builder = BrandSupplementaryModel::query();
        $builder->where('brand_id', $brand_id);
        $models = $builder->get();
        /** @var BrandSupplementaryModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }
}
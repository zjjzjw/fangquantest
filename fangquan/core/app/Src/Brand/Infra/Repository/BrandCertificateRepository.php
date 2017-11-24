<?php namespace App\Src\Brand\Infra\Repository;

use App\Src\Brand\Domain\Model\BrandCertificateSpecification;
use App\Foundation\Domain\Repository;
use App\Src\Brand\Domain\Interfaces\BrandCertificateInterface;
use App\Src\Brand\Domain\Model\BrandCertificateEntity;
use App\Src\Brand\Infra\Eloquent\BrandCertificateModel;


class BrandCertificateRepository extends Repository implements BrandCertificateInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param BrandCertificateEntity $brand_certificate_entity
     */
    protected function store($brand_certificate_entity)
    {
        if ($brand_certificate_entity->isStored()) {
            $model = BrandCertificateModel::find($brand_certificate_entity->id);
        } else {
            $model = new BrandCertificateModel();
        }

        $model->fill(
            [
                'name'             => $brand_certificate_entity->name,
                'type'             => $brand_certificate_entity->type,
                'certificate_file' => $brand_certificate_entity->certificate_file,
                'status'           => $brand_certificate_entity->status,
                'brand_id'         => $brand_certificate_entity->brand_id,
            ]
        );
        $model->save();
        $brand_certificate_entity->setIdentity($model->id);
    }

    /**
     * @param BrandCertificateSpecification $spec
     * @param int                           $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(BrandCertificateSpecification $spec, $per_page = 10)
    {
        $builder = BrandCertificateModel::query();

        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
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
     * @return BrandCertificateModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = BrandCertificateModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param BrandCertificateModel $model
     *
     * @return BrandCertificateEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new BrandCertificateEntity();
        $entity->id = $model->id;

        $entity->name = $model->name;
        $entity->type = $model->type;
        $entity->certificate_file = $model->certificate_file;
        $entity->status = $model->status;
        $entity->brand_id = $model->brand_id;
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
        $builder = BrandCertificateModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }


    /**
     *
     * @param $brand_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getBrandCertificatesByBrandId($brand_id)
    {
        $collect = collect();
        $builder = BrandCertificateModel::query();
        $builder->where('brand_id', $brand_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;

    }


}
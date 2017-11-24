<?php namespace App\Src\Brand\Infra\Repository;

use App\Src\Brand\Domain\Model\SaleChannelSpecification;
use App\Foundation\Domain\Repository;
use App\Src\Brand\Domain\Interfaces\SaleChannelInterface;
use App\Src\Brand\Domain\Model\SaleChannelEntity;
use App\Src\Brand\Infra\Eloquent\SaleChannelModel;


class SaleChannelRepository extends Repository implements SaleChannelInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param SaleChannelEntity $sale_channel_entity
     */
    protected function store($sale_channel_entity)
    {
        if ($sale_channel_entity->isStored()) {
            $model = SaleChannelModel::find($sale_channel_entity->id);
        } else {
            $model = new SaleChannelModel();
        }

        $model->fill(
            [
                'channel_type' => $sale_channel_entity->channel_type,
                'brand_id'     => $sale_channel_entity->brand_id,
                'sale_year'    => $sale_channel_entity->sale_year,
                'sale_volume'  => $sale_channel_entity->sale_volume,
            ]
        );

        $model->save();
        $sale_channel_entity->setIdentity($model->id);
    }

    /**
     * @param SaleChannelSpecification $spec
     * @param int                      $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(SaleChannelSpecification $spec, $per_page = 10)
    {
        $builder = SaleChannelModel::query();
        if ($spec->keyword) {
            $builder->where('sale_year', 'like', '%' . $spec->keyword . '%');
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
     * @return SaleChannelModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = SaleChannelModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param SaleChannelModel $model
     *
     * @return SaleChannelEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new SaleChannelEntity();
        $entity->id = $model->id;
        $entity->sale_year = $model->sale_year;
        $entity->channel_type = $model->channel_type;
        $entity->sale_volume = $model->sale_volume;
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
        $builder = SaleChannelModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }

    }

    /**
     * @param int $brand_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getSaleChannelByBrandId($brand_id)
    {
        $collection = collect();
        $builder = SaleChannelModel::query();
        $builder->where('brand_id', $brand_id);
        $models = $builder->get();
        /** @var SaleChannelModel $model */
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }


    /**
     * @param int   $brand_id
     * @param array $sales
     */
    public function modify($brand_id, $sales)
    {
        foreach ($sales as $sale) {
            $builder = SaleChannelModel::query();
            $builder->where('brand_id', $brand_id);
            $builder->where('sale_year', $sale['year']);
            $builder->where('channel_type', $sale['type']);
            $model = $builder->first();
            if (!isset($model)) {
                $model = new SaleChannelModel();
            }
            $model->brand_id = $brand_id;
            $model->sale_year = $sale['year'];
            $model->channel_type = $sale['type'];
            $model->sale_volume = $sale['amount'];
            $model->save();
        }
    }


    /**
     * @param int $brand_id
     * @param int $year
     * @param int $type
     * @return SaleChannelEntity|null
     */
    public function getSaleChannelByParams($brand_id, $year, $type)
    {
        $builder = SaleChannelModel::query();
        $builder->where('brand_id', $brand_id);
        $builder->where('sale_year', $year);
        $builder->where('channel_type', $type);
        $model = $builder->first();
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }


}
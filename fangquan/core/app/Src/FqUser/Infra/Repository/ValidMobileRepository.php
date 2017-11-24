<?php namespace App\Src\FqUser\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Service\Smser\SmserService;
use App\Src\FqUser\Domain\Interfaces\ValidMobileInterface;
use App\Src\FqUser\Domain\Model\ValidMobileEntity;
use App\Src\FqUser\Domain\Model\ValidMobileSpecification;
use App\Src\FqUser\Infra\Eloquent\ValidMobileModel;
use Carbon\Carbon;

class ValidMobileRepository extends Repository implements ValidMobileInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  ValidMobileEntity $valid_mobile_entity
     */
    protected function store($valid_mobile_entity)
    {
        if ($valid_mobile_entity->isStored()) {
            $model = ValidMobileModel::find($valid_mobile_entity->id);
        } else {
            $model = new ValidMobileModel();
        }
        $model->fill(
            [
                'mobile'     => $valid_mobile_entity->mobile,
                'verifycode' => $valid_mobile_entity->verifycode,
                'expire'     => $valid_mobile_entity->expire,
            ]
        );
        $model->save();
        $valid_mobile_entity->setIdentity($model->id);
    }


    public function search(ValidMobileSpecification $spec, $per_page = 20)
    {
        $builder = ValidMobileModel::query();
        $builder->orderByDesc('created_at');

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
     * @param string $phone
     * @return mixed
     */
    public function getValidMobileByPhone($phone)
    {
        $builder = ValidMobileModel::query();
        $builder->where('mobile', $phone);
        $model = $builder->first();
        if (isset($model)) {
            return $this->reconstituteFromModel($model)->stored();
        }
        return null;

    }

    /**
     * @param $id
     * @return mixed|void
     */
    public function delete($id)
    {
        $builder = ValidMobileModel::query();
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
     * @return ValidMobileEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ValidMobileModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ValidMobileModel $model
     * @return ValidMobileEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ValidMobileEntity();
        $entity->id = $model->id;
        $entity->mobile = $model->mobile;
        $entity->verifycode = $model->verifycode;
        $entity->expire = $model->expire;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }
}

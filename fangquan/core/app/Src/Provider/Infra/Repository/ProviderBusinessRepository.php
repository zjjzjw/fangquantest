<?php namespace App\Src\Provider\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Provider\Domain\Interfaces\ProviderBusinessInterface;
use App\Src\Provider\Domain\Model\ProviderBusinessEntity;
use App\Src\Provider\Domain\Model\ProviderBusinessSpecification;
use App\Src\Provider\Infra\Eloquent\ProviderBusinessModel;

class ProviderBusinessRepository extends Repository implements ProviderBusinessInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  ProviderBusinessEntity $provider_business_entity
     */
    protected function store($provider_business_entity)
    {
        if ($provider_business_entity->isStored()) {
            $model = ProviderBusinessModel::find($provider_business_entity->id);
        } else {
            $model = new ProviderBusinessModel();
        }
        $model->fill(
            [
                'provider_id'                => $provider_business_entity->provider_id,
                'base_info'                  => $provider_business_entity->base_info,
                'main_person'                => $provider_business_entity->main_person,
                'shareholder_info          ' => $provider_business_entity->shareholder_info,
                'change_record             ' => $provider_business_entity->change_record,
                'branchs'                    => $provider_business_entity->branchs,
                'financing_history'          => $provider_business_entity->financing_history,
                'core_team'                  => $provider_business_entity->core_team,
                'enterprise_business'        => $provider_business_entity->enterprise_business,
                'legal_proceedings'          => $provider_business_entity->legal_proceedings,
                'court_notice'               => $provider_business_entity->court_notice,
                'dishonest_person'           => $provider_business_entity->dishonest_person,
                'person_subjected_execution' => $provider_business_entity->person_subjected_execution,
                'abnormal_operation'         => $provider_business_entity->abnormal_operation,
                'administrative_sanction'    => $provider_business_entity->administrative_sanction,
                'serious_violation'          => $provider_business_entity->serious_violation,
                'stock_ownership'            => $provider_business_entity->stock_ownership,
                'chattel_mortgage'           => $provider_business_entity->chattel_mortgage,
                'tax_notice'                 => $provider_business_entity->tax_notice,
                'bidding'                    => $provider_business_entity->bidding,
                'purchase_information'       => $provider_business_entity->purchase_information,
                'tax_rating'                 => $provider_business_entity->tax_rating,
                'qualification_certificate'  => $provider_business_entity->qualification_certificate,
                'trademark_information'      => $provider_business_entity->trademark_information,
                'patent'                     => $provider_business_entity->patent,
            ]
        );
        $model->save();
        $provider_business_entity->setIdentity($model->id);
    }

    /**
     * @param ProviderBusinessSpecification $spec
     * @param int                           $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator]
     */
    public function search(ProviderBusinessSpecification $spec, $per_page = 20)
    {
        $builder = ProviderBusinessModel::query();

        if ($spec->provider_id) {
            $builder->where('provider_id', $spec->provider_id);
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
     * @param       $id
     * @param array $params
     *
     * @return ProviderBusinessEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProviderBusinessModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return ProviderBusinessEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProviderBusinessEntity();
        $entity->id = $model->id;
        $entity->provider_id = $model->provider_id;
        $entity->base_info = $model->base_info;
        $entity->main_person = $model->main_person;
        $entity->shareholder_info = $model->shareholder_info;
        $entity->change_record = $model->change_record;
        $entity->branchs = $model->branchs;
        $entity->financing_history = $model->financing_history;
        $entity->core_team = $model->core_team;
        $entity->enterprise_business = $model->enterprise_business;
        $entity->legal_proceedings = $model->legal_proceedings;
        $entity->court_notice = $model->court_notice;
        $entity->dishonest_person = $model->dishonest_person;
        $entity->person_subjected_execution = $model->person_subjected_execution;
        $entity->abnormal_operation = $model->abnormal_operation;
        $entity->administrative_sanction = $model->administrative_sanction;
        $entity->serious_violation = $model->serious_violation;
        $entity->stock_ownership = $model->stock_ownership;
        $entity->chattel_mortgage = $model->chattel_mortgage;
        $entity->tax_notice = $model->tax_notice;
        $entity->bidding = $model->bidding;
        $entity->purchase_information = $model->purchase_information;
        $entity->tax_rating = $model->tax_rating;
        $entity->qualification_certificate = $model->qualification_certificate;
        $entity->trademark_information = $model->trademark_information;
        $entity->patent = $model->patent;
        $entity->setIdentity($model->id);
        $entity->stored();

        return $entity;
    }

    /**
     * @param int $provider_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderBusinessByProviderId($provider_id)
    {
        $builder = ProviderBusinessModel::query();
        $builder->where('provider_id', $provider_id);
        $model = $builder->first();
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }
}
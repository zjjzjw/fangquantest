<?php namespace App\Admin\Src\Forms\Provider\ProviderRankCategory;

use App\Admin\Src\Forms\Form;
use App\Src\Provider\Domain\Model\ProviderRankCategoryEntity;
use App\Src\Provider\Infra\Repository\ProviderRankCategoryRepository;

class ProviderRankCategoryStoreForm extends Form
{
    /**
     * @var ProviderRankCategoryEntity
     */
    public $provider_rank_category_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'          => 'required|integer',
            'category_id' => 'required|integer',
            'provider_id' => 'required|integer',
            'rank'        => 'required|integer',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误。',
        ];
    }

    public function attributes()
    {
        return [
            'id'          => '标识',
            'provider_id' => '供应商ID',
            'category_id' => '品类id',
            'rank'        => '排名',
        ];
    }

    public function validation()
    {
        $provider_rank_category_repository = new ProviderRankCategoryRepository();
        if ($id = array_get($this->data, 'id')) {
            /** @var ProviderRankCategoryEntity $provider_service_network_entity */
            $provider_rank_category_entity = $provider_rank_category_repository->fetch($id);
        } else {
            $provider_rank_category_entity = new ProviderRankCategoryEntity();
        }

        $rank = array_get($this->data, 'rank');
        $category_id = array_get($this->data, 'category_id');

        $provider_rank_category_entity->provider_id = array_get($this->data, 'provider_id');
        $provider_rank_category_entity->category_id = $category_id;
        $provider_rank_category_entity->rank = $rank;
        $provider_rank_category_entity->title = array_get($this->data, 'title', '');

        $this->provider_rank_category_entity = $provider_rank_category_entity;
    }
}
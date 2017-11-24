<?php namespace App\Admin\Src\Forms\Provider\ProviderProductProgramme;

use App\Src\Provider\Domain\Model\ProviderProductProgrammeStatus;
use App\Src\Provider\Infra\Repository\ProviderProductProgrammeRepository;
use App\Src\Provider\Domain\Model\ProviderProductProgrammeEntity;
use App\Admin\Src\Forms\Form;

class ProviderProductProgrammeStoreForm extends Form
{
    /**
     * @var ProviderProductProgrammeEntity
     */
    public $provider_product_programme_entity;


    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                                => 'required|integer',
            'title'                             => 'required|string',
            'desc'                              => 'required|string',
            'product'                           => 'required|array',
            'provider_product_programme_images' => 'nullable|array',
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
            'id'                                => '标识',
            'title'                             => '标题',
            'desc'                              => '描述',
            'product'                           => '产品',
            'provider_product_programme_images' => '图片',
        ];
    }

    public function validation()
    {
        $provider_product_programme_repository = new ProviderProductProgrammeRepository();
        if ($id = array_get($this->data, 'id')) {
            /** @var ProviderProductProgrammeEntity $provider_product_entity */
            $provider_product_programme_entity = $provider_product_programme_repository->fetch($id);
        } else {
            $provider_product_programme_entity = new ProviderProductProgrammeEntity();
            $provider_product_programme_entity->provider_id = array_get($this->data, 'provider_id');
            $provider_product_programme_entity->status = ProviderProductProgrammeStatus::STATUS_PASS;
        }

        $provider_product_programme_entity->title = array_get($this->data, 'title');
        $provider_product_programme_entity->desc = array_get($this->data, 'desc');
        $provider_product_programme_entity->product = array_get($this->data, 'product');
        $provider_product_programme_entity->provider_product_programme_pictures = array_get($this->data, 'provider_product_programme_images');

        $this->provider_product_programme_entity = $provider_product_programme_entity;
    }

}
<?php namespace App\Admin\Src\Forms\Provider\ProviderProduct;

use App\Src\Provider\Infra\Repository\ProviderProductRepository;
use App\Src\Provider\Domain\Model\ProviderProductEntity;
use App\Admin\Src\Forms\Form;

class  ProviderProductStoreForm extends Form
{
    /**
     * @var ProviderProductEntity
     */
    public $provider_product_entity;


    public function validation()
    {
        $provider_product_repository = new ProviderProductRepository();
        if ($id = array_get($this->data, 'id')) {
            /** @var ProviderProductEntity $provider_product_entity */
            $provider_product_entity = $provider_product_repository->fetch($id);
        } else {
            $provider_product_entity = new ProviderProductEntity();
            $provider_product_entity->provider_id = array_get($this->data, 'provider_id');
            $provider_product_entity->views = 0;
        }

        $attrib = array_get($this->data, 'attrib');
        $provider_product_entity->name = array_get($this->data, 'name');
        $provider_product_entity->status = array_get($this->data, 'status');
        $provider_product_entity->price_low = array_get($this->data, 'price_low') ?? 0;
        $provider_product_entity->price_high = array_get($this->data, 'price_high') ?? 0;
        $provider_product_entity->product_category_id = array_get($this->data, 'product_category_id');
        $provider_product_entity->provider_product_images = array_get($this->data, 'provider_product_images');
        $provider_product_entity->attrib_integrity = $attrib == '[]' ? 0 :$provider_product_repository->countAttribIntegrity($attrib);
        $provider_product_entity->attrib = $attrib;

        $this->provider_product_entity = $provider_product_entity;
    }

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                      => 'required|integer',
            'provider_id'             => 'required|integer',
            'product_category_id'     => 'required|integer',
            'name'                    => 'required|string',
            'provider_product_images' => 'required|array',
            'attrib'                  => 'nullable|json',
            'price_low'               => 'nullable|numeric',
            'price_high'              => 'nullable|numeric',
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
            'id'                      => '标识',
            'provider_id'             => '供应商ID',
            'name'                    => '产品名称',
            'product_category_id'     => '分类',
            'attrib'                  => '分类属性',
            'provider_product_images' => '产品图片',
            'price_low'               => '最低价',
            'price_high'              => '最高价',
        ];
    }

}
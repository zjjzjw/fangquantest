<?php namespace App\Admin\Src\Forms\Provider\ProviderNews;

use App\Admin\Src\Forms\Form;
use App\Src\Provider\Domain\Model\ProviderNewsEntity;
use App\Src\Provider\Infra\Repository\ProviderNewsRepository;

class  ProviderNewsStoreForm extends Form
{
    /**
     * @var ProviderNewsEntity
     */
    public $provider_news_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'          => 'required|integer',
            'provider_id' => 'required|integer',
            'content'     => 'required|string',
            'title'       => 'required|string',
            'status'      => 'required|integer',
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
            'title'       => '标题',
            'content'     => '内容',
            'status'      => '状态',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $provider_news_repository = new ProviderNewsRepository();
            /** @var ProviderNewsEntity $provider_news_entity */
            $provider_news_entity = $provider_news_repository->fetch($id);
        } else {
            $provider_news_entity = new ProviderNewsEntity();
        }

        $provider_news_entity->provider_id = array_get($this->data, 'provider_id');
        $provider_news_entity->title = array_get($this->data, 'title');
        $provider_news_entity->content = array_get($this->data, 'content');
        $provider_news_entity->status = array_get($this->data, 'status');

        $this->provider_news_entity = $provider_news_entity;
    }
}
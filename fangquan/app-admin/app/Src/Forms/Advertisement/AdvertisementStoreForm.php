<?php

namespace App\Admin\Src\Forms\Advertisement;


use App\Admin\Src\Forms\Form;
use App\Src\Advertisement\Domain\Model\AdvertisementEntity;
use App\Src\Advertisement\Infra\Repository\AdvertisementRepository;

class AdvertisementStoreForm extends Form
{
    /**
     * @var AdvertisementEntity
     */
    public $advertisement_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'       => 'required|integer',
            'title'    => 'required|string',
            'image'    => 'required|integer',
            'position' => 'required|integer',
            'link'     => 'required|string',
            'status'   => 'required|integer',
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
            'id'       => '标识',
            'title'    => '标题',
            'image'    => '图标',
            'status'   => '状态',
            'position' => '广告位',
            'link'     => '链接',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $advertisement_repository = new AdvertisementRepository();
            /** @var AdvertisementEntity $advertisement_entity */
            $advertisement_entity = $advertisement_repository->fetch(array_get($this->data, 'id'));
        } else {
            $advertisement_entity = new AdvertisementEntity();
        }


        $advertisement_entity->title = array_get($this->data, 'title');
        $advertisement_entity->image_id = array_get($this->data, 'image');
        $advertisement_entity->position = array_get($this->data, 'position');
        $advertisement_entity->type = array_get($this->data, 'type', 0);
        $advertisement_entity->link = array_get($this->data, 'link');
        $advertisement_entity->sort = array_get($this->data, 'sort');
        $advertisement_entity->status = array_get($this->data, 'status');
        $this->advertisement_entity = $advertisement_entity;
    }

}
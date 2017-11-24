<?php namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\Entity;

class ProviderProjectPictureEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

    public $identity_key = 'id';
    /**
     * @var int
     */
    public $provider_project_id;
    /**
     * @var string
     */
    public $image_id;

    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                  => $this->id,
            'provider_project_id' => $this->provider_project_id,
            'image_id'            => $this->image_id,
        ];
    }
}
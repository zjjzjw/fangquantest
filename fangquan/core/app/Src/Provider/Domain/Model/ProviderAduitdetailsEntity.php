<?php

namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\Entity;

class ProviderAduitdetailsEntity  extends Entity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $provider_id;

    /**
     * @var int
     */
    public $type;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $link;

    /**
     * @var string
     */
    public $filename;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'          => $this->id,
            'provider_id' => $this->provider_id,
            'type'        => $this->type,
            'name'        => $this->name,
            'link'        => $this->link,
            'filename'    => $this->filename,
            'created_at'  =>$this->created_at
        ];
    }

}
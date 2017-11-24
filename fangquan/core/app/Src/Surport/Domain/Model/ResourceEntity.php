<?php

namespace App\Src\Surport\Domain\Model;

use App\Foundation\Domain\Entity;

class ResourceEntity extends Entity
{
    /**
     * @var int
     */
    public $id = null;
    /**
     * @var string
     */
    public $bucket = null;
    /**
     * @var string
     */
    public $hash = null;
    /**
     * @var string
     */
    public $processed_hash = '';

    /**
     * @var string
     */
    public $mime_type = null;

    /**
     * @var string
     */
    public $url = null;

    /**
     * @var string
     */
    public $desc = '';


    public function __construct()
    {

    }

}

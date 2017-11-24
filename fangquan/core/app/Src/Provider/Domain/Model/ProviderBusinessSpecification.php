<?php

namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;

class ProviderBusinessSpecification extends ValueObject implements Validatable
{
    /**
     * @var int
     */
    public $page;

    /**
     * @var int
     */
    public $type;

    /**
     * @var int
     */
    public $column;

    /**
     * @var int
     */
    public $provider_id;

    public function __construct()
    {
    }

    public function validate()
    {
    }


}
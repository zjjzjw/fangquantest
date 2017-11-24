<?php

namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;

class ProviderProjectSpecification extends ValueObject implements Validatable
{
    /**
     * @var int
     */
    public $page;
    /**
     * @var int
     */
    public $provider_id;
    /**
     * @var string
     */
    public $keyword;

    /**
     * @var int
     */
    public $status;


    public function __construct()
    {
    }

    public function validate()
    {
    }


}
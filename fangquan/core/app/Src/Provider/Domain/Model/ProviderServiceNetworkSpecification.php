<?php

namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;

class ProviderServiceNetworkSpecification extends ValueObject implements Validatable
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
     * @var int|array
     */
    public $status;

    /**
     * @var int|array
     */
    public $province_id;


    public function __construct()
    {
    }

    public function validate()
    {
    }


}
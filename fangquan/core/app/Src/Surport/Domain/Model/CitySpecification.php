<?php

namespace App\Src\Surport\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;

class CitySpecification extends ValueObject implements Validatable
{
    /**
     * @var int
     */
    public $page;

    /**
     * @var string
     */
    public $keyword;

    /**
     * @var int
     */
    public $province_id;

    public function __construct()
    {

    }

    public function validate()
    {

    }


}
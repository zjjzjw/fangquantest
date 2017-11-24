<?php

namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;

class DeveloperSpecification extends ValueObject implements Validatable
{
    /**
     * @var int
     */
    public $page;
    /**
     * @var int
     */
    public $skip;
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
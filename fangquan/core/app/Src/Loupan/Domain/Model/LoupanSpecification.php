<?php

namespace App\Src\Loupan\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;

class LoupanSpecification extends ValueObject implements Validatable
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






    public function __construct()
    {

    }

    public function validate()
    {

    }


}
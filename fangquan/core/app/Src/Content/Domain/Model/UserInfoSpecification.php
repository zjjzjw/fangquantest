<?php

namespace App\Src\Content\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;

class UserInfoSpecification extends ValueObject implements Validatable
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
    public $type;


    public function __construct()
    {

    }

    public function validate()
    {

    }


}
<?php

namespace App\Src\MediaManagement\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;

class MediaManagementSpecification extends ValueObject implements Validatable
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
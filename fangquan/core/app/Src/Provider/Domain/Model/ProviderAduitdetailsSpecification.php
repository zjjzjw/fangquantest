<?php

namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;
use Carbon\Carbon;

class ProviderAduitdetailsSpecification extends ValueObject implements Validatable
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
    public $sort;

    /**
     * @var string
     */
    public $keyword;


    public function __construct()
    {

    }

    public function validate()
    {

    }


}
<?php

namespace App\Src\Project\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;

class  ProjectCategorySpecification extends ValueObject implements Validatable
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
<?php

namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;

class DeveloperProjectContactSpecification extends ValueObject implements Validatable
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
    public $developer_project_id;

    public function __construct()
    {

    }

    public function validate()
    {

    }


}
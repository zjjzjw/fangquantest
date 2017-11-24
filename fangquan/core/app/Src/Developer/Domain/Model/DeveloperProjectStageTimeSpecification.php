<?php
namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;

class DeveloperProjectStageTimeSpecification extends ValueObject implements Validatable
{
    /**
     * @var int
     */
    public $page;

    /**
     * @var int
     */
    public $project_id;

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
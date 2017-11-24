<?php
namespace App\Src\Category\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;
use Carbon\Carbon;


class CategoryParamSpecification extends ValueObject implements Validatable
{
    /**
     * @var string
     */
    public $keyword;

    /**
     * @var int
     */
    public $page;


    public function validate()
    {

    }


}
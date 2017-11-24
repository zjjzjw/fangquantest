<?php
namespace App\Src\Role\Domain\Model;

use Carbon\Carbon;
use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;

class DepartSpecification extends ValueObject implements Validatable
{

    /**
     * @var int
     */
    public $page;

    /**
     * @var string
     */
    public $keyword;


    public function validate()
    {

    }


}
<?php
namespace App\Src\Theme\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;
use Carbon\Carbon;


class ThemeSpecification extends ValueObject implements Validatable
{
    /**
     * @var string
     */
    public $keyword;

    /**
     * @var int
     */
    public $page;

    /**
     * @var int
     */
    public $type;


    public function validate()
    {
    }


}
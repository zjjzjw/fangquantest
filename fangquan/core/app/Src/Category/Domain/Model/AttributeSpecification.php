<?php
namespace App\Src\Category\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;
use Carbon\Carbon;


class AttributeSpecification extends ValueObject implements Validatable
{
    /**
     * @var string
     */
    public $keyword;
    /**
     * @var string
     */
    public $category_type;

    /**
     * @var int
     */
    public $page;
    /**
     * @var int
     */
    public $category_id;


    public function validate()
    {

    }


}
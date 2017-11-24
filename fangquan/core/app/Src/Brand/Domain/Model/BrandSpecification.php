<?php
namespace App\Src\Brand\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;
use Carbon\Carbon;


class BrandSpecification extends ValueObject implements Validatable
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
    public $company_type;

    /**
     * @var int
     */
    public $product_type;

    /**
     * @var int
     */
    public $category_id;

    /**
     * @var string
     */
    public $attributes;

    /**
     * @var int
     */
    public $id;

    public function validate()
    {

    }


}
<?php
namespace App\Src\Product\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;
use Carbon\Carbon;


class ProductSpecification extends ValueObject implements Validatable
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
    public $brand_id;

    /**
     * @var int
     */
    public $product_category_id;

    /**
     * @var array
     */
    public $company_type;

    /**
     * @var array
     */
    public $product_type;

    /**
     * @var string
     */
    public $theme_name;

    /**
     * @var array
     */
    public $attributes;

    /**
     * @var array
     */
    public $brand_ids;


    public function validate()
    {

    }


}
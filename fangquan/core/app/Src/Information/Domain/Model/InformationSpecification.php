<?php

namespace App\Src\Information\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;
use Carbon\Carbon;


class InformationSpecification extends ValueObject implements Validatable
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
    public $tag_id;

    /**
     * @var int
     */
    public $theme_id;

    /**
     * @var int
     */
    public $status;

    /**
     * @var int
     */
    public $brand_id;

    /**
     * @var int
     */
    public $category_id;

    /**
     * @var int
     */
    public $product_id;


    public function validate()
    {

    }


}
<?php

namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;
use Carbon\Carbon;

class ProviderSpecification extends ValueObject implements Validatable
{
    /**
     * @var int
     */
    public $project_case_count_start;

    /**
     * @var int
     */
    public $project_case_count_end;

    /**
     * @var int
     */
    public $operation_mode;

    /**
     * @var int
     */
    public $registered_capital_start;

    /**
     * @var int
     */
    public $registered_capital_end;

    /**
     * @var int|array
     */
    public $province_id;

    /**
     * @var int|array
     */
    public $city_id;

    /*
     * @var int
     */
    public $product_category_id;


    /**
     * @var string
     */
    public $keyword;

    /**
     * @var int
     */
    public $user_id;

    /**
     * @var int|array
     */
    public $status;

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
     * @var int
     */
    public $provider_id;

    /**
     * @var int
     */
    public $is_ad;

    /**
     * @var int
     */
    public $company_type;

    /**
     * @var int
     */
    public $category_id;
    public $attributes;

    /**
     * @var int
     */
    public $product_type;


    public function __construct()
    {

    }

    public function validate()
    {

    }


}
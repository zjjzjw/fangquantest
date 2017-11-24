<?php

namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;

class DeveloperProjectSpecification extends ValueObject implements Validatable
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
     * @var string
     */
    public $bidding_type;
    /**
     * @var int|array
     */
    public $project_category_id;
    /**
     * @var int
     */
    public $order_column;
    /**
     * @var int
     */
    public $order_type;
    /**
     * @var int|array
     */
    public $product_category_id;

    /**
     * @var int
     */
    public $developer_id;

    /**
     * @var int
     */
    public $project_stage_id;

    /**
     * @var int|array
     */
    public $province_id;

    /**
     * @var int
     */
    public $is_great;

    /**
     * @var int
     */
    public $developer_type;

    /**
     * @var int
     */
    public $project_category;

    /**
     * @var int
     */
    public $status;

    /**
     * @var string
     */
    public $column;

    /**
     * @var string
     */
    public $sort;

    /**
     * @var int
     */
    public $is_ad;

    /**
     * @var int
     */
    public $user_id;

    /**
     * 项目类型
     * @var array
     */
    public $project_categories;

    /**
     * @var array
     */
    public $project_category_ids;


    public function __construct()
    {

    }

    public function validate()
    {

    }


}
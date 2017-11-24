<?php

namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;
use Carbon\Carbon;

class ProviderProductSpecification extends ValueObject implements Validatable
{
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
     * @var string
     */
    public $keyword;

    /**
 * @var int
 */
    public $second_product_category_id;
    /**
     * @var int
     */
    public $product_category_id;

    /**
     * @var int
     */
    public $provider_id;

    /**
     * @var int|array
     */
    public $status;

    /**
     * @var int
     */
    public $user_id;


    public function __construct()
    {

    }

    public function validate()
    {

    }


}
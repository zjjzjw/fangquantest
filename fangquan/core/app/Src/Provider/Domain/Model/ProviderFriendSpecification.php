<?php

namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;
use Carbon\Carbon;

class ProviderFriendSpecification extends ValueObject implements Validatable
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
    public $provider_id;

    /**
     * @var int
     */
    public $status;


    public function __construct()
    {

    }

    public function validate()
    {

    }


}
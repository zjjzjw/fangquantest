<?php

namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;
use Carbon\Carbon;

class ProviderProductProgrammeSpecification extends ValueObject implements Validatable
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
     * @var int
     */
    public $provider_id;

    /**
     * @var int
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
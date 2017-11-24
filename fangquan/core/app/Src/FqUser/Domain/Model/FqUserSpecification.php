<?php
namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;

class FqUserSpecification extends ValueObject implements Validatable
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
    public $account_type;

    /**
     * @var int
     */
    public $provider_id;

    /**
     * @var int
     */
    public $platform_id;

    public function __construct()
    {

    }

    public function validate()
    {

    }

}
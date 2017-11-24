<?php namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;

class ProviderNewsSpecification extends ValueObject implements Validatable
{
    /**
     * @var int
     */
    public $page;

    /**
     * @var int
     */
    public $provider_id;

    /**
     * @var int
     */
    public $status;

    /**
     * @var string
     */
    public $keyword;

    public function validate()
    {
    }
}
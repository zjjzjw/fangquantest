<?php
namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;

class FqUserFeedbackSpecification extends ValueObject implements Validatable
{
    /**
     * @var int
     */
    public $page;

    public function __construct()
    {

    }

    public function validate()
    {

    }

}
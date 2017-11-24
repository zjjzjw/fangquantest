<?php
namespace App\Src\Role\Domain\Model;

use Carbon\Carbon;
use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;

class UserFeedbackSpecification extends ValueObject implements Validatable
{

    /**
     * @var Carbon
     */
    public $start_time;

    /**
     * @var Carbon
     */
    public $end_time;

    /**
     * @var string
     */
    public $keyword;

    /**
     * @var int
     */
    public $page;


    public function validate()
    {

    }


}
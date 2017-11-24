<?php
namespace App\Src\Msg\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;
use Carbon\Carbon;


class UserMsgSpecification extends ValueObject implements Validatable
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
    public $to_uid;

    /**
     * @var string
     */
    public $column;

    /**
     * @var string
     */
    public $sort;


    public function validate()
    {

    }


}
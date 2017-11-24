<?php
namespace App\Src\Brand\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;
use Carbon\Carbon;


class CommentSpecification extends ValueObject implements Validatable
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
     * @var integer
     */
    public $type;

    /**
     * @var integer
     */
    public $p_id;

    public function validate()
    {

    }


}
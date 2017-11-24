<?php
namespace App\Src\Role\Domain\Model;

use Carbon\Carbon;
use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;

class UserSpecification extends ValueObject implements Validatable
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
    public $depart_name;

    /**
     * @var int
     */
    public $depart_id;

    /**
     * @var string
     */
    public $search_type;

    /**
     * @var int
     */
    public $created_user_id;

    /**
     * @var int
     */
    public $type;


    public function __construct()
    {

    }

    public function validate()
    {

    }

}
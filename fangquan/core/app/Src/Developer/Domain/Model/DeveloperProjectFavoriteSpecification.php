<?php
namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\ValueObject;
use App\Foundation\Support\Interfaces\Validatable;

class DeveloperProjectFavoriteSpecification extends ValueObject implements Validatable
{
    /**
     * @var int
     */
    public $page;
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
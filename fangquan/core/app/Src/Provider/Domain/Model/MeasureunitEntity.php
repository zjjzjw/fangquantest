<?php namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\Entity;

class MeasureunitEntity extends Entity
{
	/**
	 * @var int
	 */
	public $id;
	
	public $identity_key = 'id';
	/**
	 * @var int
	 */
	public $name;
	
	public function __construct()
	{
	}
	
	public function toArray($is_filter_null = false)
	{
		return [
			'id'   => $this->id,
			'name' => $this->name,
		];
	}
}
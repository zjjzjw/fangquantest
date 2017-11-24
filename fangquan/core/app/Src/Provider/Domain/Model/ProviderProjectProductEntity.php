<?php namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\Entity;

class ProviderProjectProductEntity extends Entity
{
	/**
	 * @var int
	 */
	public $id;
	
	public $identity_key = 'id';
	/**
	 * @var int
	 */
	public $provider_project_id;
	/**
	 * @var string
	 */
	public $name;
	/**
	 * @var string
	 */
	public $num;
	/**
	 * @var int
	 */
	public $measureunit_id;
	
	public function __construct()
	{
	}
	
	public function toArray($is_filter_null = false)
	{
		return [
			'id'                  => $this->id,
			'provider_project_id' => $this->provider_project_id,
			'name'                => $this->name,
			'num'                 => $this->num,
			'measureunit_id'      => $this->measureunit_id,
		];
	}
}
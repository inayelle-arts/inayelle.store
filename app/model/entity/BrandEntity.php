<?php

namespace app\model\entity;

use vendor\core\base\EntityBase;
use vendor\core\base\GetSet;

/**
 * Class BrandEntity
 * @package app\model\entity
 * @property string $name
 * @property string $description
 */
class BrandEntity extends EntityBase
{
	use GetSet;
	
	/** @var string $name */
	private $name;
	
	/** @var string $description */
	private $description;
	
	protected const TABLE = "brands";
	
	protected const FIELDS =
		[
			"name",
			"description"
		];
	
	public function __construct() { }
}
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
	protected $name;
	
	/** @var string $description */
	protected $description;
	
	public const TABLE = "brands";
	
	public const FIELDS =
		[
			"name",
			"description"
		];
	
	public function __construct() { }
}
<?php

namespace app\model\entity;

use vendor\core\base\EntityBase;
use vendor\core\base\GetSet;

/**
 * Class ImageEntity
 * @package app\model\entity
 * @property int    $product_id
 * @property string $path
 * @property int    $primary_image
 */
class ImageEntity extends EntityBase
{
	use GetSet;
	
	public const TABLE = "images_storage";
	
	public const FIELDS =
		[
			"product_id",
			"path",
			"primary_image"
		];
	
	public function __construct() { }
	
	/** @var int $product_id */
	protected $product_id;
	
	/** @var string $path */
	protected $path;
	
	/** @var int $primary_image */
	protected $primary_image;
}
<?php

namespace app\model\entity;

use vendor\core\base\EntityBase;
use vendor\core\base\GetSet;


/**
 * Class Shipping
 * @package app\model\entity
 * @property string $address
 * @property int    $shipping_type
 */
class Shipping extends EntityBase
{
	use GetSet;
	
	public const TABLE = "shippings";
	
	public const FIELDS =
		[
			"address",
			"shipping_type"
		];
	
	/** @var string $address */
	protected $address;
	
	/** @var int $shipping_type */
	protected $shipping_type;
}
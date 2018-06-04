<?php

namespace app\model\entity;

use vendor\core\base\EntityBase;
use vendor\core\base\GetSet;


/**
 * Class OrderedProductEntity
 * @package app\model\entity
 * @property int $product_id
 * @property int $order_id
 * @property int $count
 * @property int $total_cost
 * @property ProductEntity $product
 * @property OrderEntity $order
 */
class OrderedProductEntity extends EntityBase
{
	use GetSet;
	
	public const TABLE = "ordered_products";
	
	public const FIELDS =
		[
			"product_id",
			"order_id",
			"count",
			"total_cost"
		];
	
	
	/** @var int $product_id */
	protected $product_id;
	
	/** @var int $order_id */
	protected $order_id;
	
	/** @var int $count */
	protected $count;
	
	/** @var int $total_cost */
	protected $total_cost;
	
	/** @var ProductEntity $product */
	private $product;
	
	/** @var OrderEntity $order*/
	private $order;
}
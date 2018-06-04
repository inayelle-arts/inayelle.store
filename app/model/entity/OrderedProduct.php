<?php

namespace app\model\entity;

use vendor\core\base\EntityBase;
use vendor\core\base\GetSet;


/**
 * Class OrderedProduct
 * @package app\model\entity
 * @property int $product_id
 * @property int $order_id
 * @property int $count
 * @property int $total_cost
 * @property ProductEntity $product
 * @property OrderEntity $order
 */
class OrderedProduct extends EntityBase
{
	use GetSet;
	
	protected const TABLE = "ordered_products";
	
	protected const FIELDS =
		[
			"product_id",
			"order_id",
			"count",
			"total_cost"
		];
	
	
	/** @var int $product_id */
	private $product_id;
	
	/** @var int $order_id */
	private $order_id;
	
	/** @var int $count */
	private $count;
	
	/** @var int $total_cost */
	private $total_cost;
	
	/** @var ProductEntity $product */
	private $product;
	
	/** @var OrderEntity $order*/
	private $order;
}
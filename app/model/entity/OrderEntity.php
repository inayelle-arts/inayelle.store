<?php

namespace app\model\entity;

use vendor\core\base\EntityBase;
use vendor\core\base\GetSet;


/**
 * Class Order
 * @package app\model\entity
 * @property int $user_id
 * @property string $order_date
 * @property int $status_id
 * @property int $shipping_id
 * @property Shipping $shipping
 * @property string $user_comment
 */
class OrderEntity extends EntityBase
{
	use GetSet;
	
	protected const TABLE = "orders";
	
	protected const FIELDS =
		[
			"user_id",
			"order_date",
			"status_id",
			"shipping_id",
			"user_comment"
		];
	
	/** @var int $user_id */
	private $user_id;
	
	/** @var string $order_date */
	private $order_date;
	
	/** @var int $status_id */
	private $status_id;
	
	/** @var int $shipping_id */
	private $shipping_id;
	
	/** @var Shipping $shipping */
	private $shipping;
	
	/** @var string $user_comment */
	private $user_comment;
	
	protected static function parseOne( array $data ) : EntityBase
	{
		/** @var OrderEntity $result */
		$result = parent::parseOne( $data );
		$id = $result->id;
		$result->shipping = Shipping::getById($id);
		
		return $result;
	}
}
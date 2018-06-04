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
	
	public const TABLE = "orders";
	
	public const FIELDS =
		[
			"user_id",
			"order_date",
			"status_id",
			"shipping_id",
			"user_comment"
		];
	
	/** @var int $user_id */
	protected $user_id;
	
	/** @var string $order_date */
	protected $order_date;
	
	/** @var int $status_id */
	protected $status_id;
	
	/** @var int $shipping_id */
	protected $shipping_id;
	
	/** @var string $user_comment */
	protected $user_comment;
	
	/** @var Shipping $shipping */
	private $shipping;
	
	public static function parseOne( array $data ) : EntityBase
	{
		/** @var OrderEntity $result */
		$result = parent::parseOne( $data );
		$id = $result->id;
		$result->shipping = Shipping::getById($id);
		
		return $result;
	}
}
<?php

namespace app\model;

use app\model\entity\OrderedProductEntity;
use app\model\entity\OrderEntity;
use app\model\entity\OrderStatus;
use app\model\entity\ProductEntity;
use app\model\entity\UserEntity;
use vendor\auxiliary\Email;
use vendor\core\database\exception\DatabaseCommonException;

class Purchase extends App
{
	/**
	 * @param int[] $ids
	 *
	 * @return ProductEntity[]
	 */
	public function getProductsById( array $ids ) : array
	{
		$result = [];
		
		foreach( $ids as $id )
		{
			try
			{
				$result[] = ProductEntity::getById( $id );
			}
			catch( DatabaseCommonException $exception )
			{
				continue;
			}
		}
		
		return $result;
	}
	
	public function purchase( array $ids, UserEntity $who ) : void
	{
		$order               = new OrderEntity();
		$order->user_id      = $who->id;
		$order->order_date   = date( "Y-m-d H:i:s" );
		$order->shipping_id  = -1;
		$order->status_id    = OrderStatus::PENDING;
		$order->user_comment = null;
		
		$order->create();
		
		$orderedProducts = [];
		
		foreach( $ids as $productId )
		{
			$orderedProduct             = new OrderedProductEntity();
			$orderedProduct->product_id = $productId;
			$orderedProduct->order_id   = $order->id;
			$orderedProduct->count      = 1;
			$orderedProduct->product    = ProductEntity::getById( $productId );
			$orderedProduct->total_cost = ($orderedProduct->product->total_cost * $orderedProduct->count);
			$orderedProduct->create();
			
			$orderedProducts[] = $orderedProduct;
		}
		
		self::purchaseNotify( $who, $orderedProducts );
	}
	
	
	/**
	 * @param UserEntity             $user
	 * @param OrderedProductEntity[] $orderedProducts
	 */
	private static function purchaseNotify( UserEntity $user, array $orderedProducts ) : void
	{
		$subject = "inayelle.store | purchase";
		
		$count = count( $orderedProducts );
		
		$message =
			"Dear User,\r\n" .
			"You just left an order for ${count} products:\r\n";
		
		foreach( $orderedProducts as $product )
		{
			$name    = $product->product->name;
			$cost    = $product->total_cost / 100;
			$message .= "${name}        |       ${cost}$\r\n";
		}
		
		$message .= "Our managers will contact you as soon as possible, stay in touch!\r\n";
		$message .= "Have a nice day! Regards,\r\ninayelle.store";
		
		$mail = new Email( $user->email, $subject, $message );
		$mail->send();
	}
}
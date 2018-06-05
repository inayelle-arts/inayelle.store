<?php

namespace app\model;

use app\model\entity\ProductEntity;
use vendor\core\database\exception\DatabaseCommonException;

class Index extends App
{
	/**
	 * @return ProductEntity[]
	 */
	public function getProductsWithDiscount() : array
	{
		try
		{
			return ProductEntity::getLastRatedByField( "discount", 4 );
		}
		catch( DatabaseCommonException $exception )
		{
			return [];
		}
	}
}
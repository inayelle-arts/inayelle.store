<?php

namespace app\model;

use app\model\entity\ProductEntity;
use vendor\auxiliary\Logger;
use vendor\core\database\exception\DatabaseCommonException;

class Arrivals extends App
{
	/**
	 * @return ProductEntity[] latest added products
	 */
	public function getLatestArrivals() : array
	{
		try
		{
			return ProductEntity::getFirstRatedByField( "id", 15 );
		}
		catch(DatabaseCommonException $exception)
		{
			Logger::log($exception);
			return [];
		}
	}
}
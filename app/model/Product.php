<?php

namespace app\model;

use app\model\entity\ProductEntity;

class Product extends App
{
	public function getProduct(?int $id) : ?ProductEntity
	{
		if ($id === null)
			return null;
		
		return ProductEntity::getById($id);
	}
}
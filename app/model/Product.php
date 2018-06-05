<?php

namespace app\model;

use app\model\entity\ProductEntity;
use vendor\core\database\SQLBuilder;

class Product extends App
{
	public function getProduct( ?int $id ) : ?ProductEntity
	{
		if( $id === null )
			return null;
		
		return ProductEntity::getById( $id );
	}
	
	/**
	 * @param int        $count
	 * @param int        $offset
	 * @param int[]|null $allowedCategories
	 * @param int        $lowerCost
	 * @param int        $upperCost
	 *
	 * @return ProductEntity[]
	 * @throws \vendor\core\database\exception\ConnectionFailureException
	 * @throws \vendor\core\database\exception\DatabaseCommonException
	 */
	public function getProductsByFilter( int $count = 8, int $offset = 0, array $allowedCategories = [], int $lowerCost = null, int $upperCost = null ) : array
	{
		if( $allowedCategories === null || count( $allowedCategories ) === 0 )
			return [];
		
		$openBrace = ( count( $allowedCategories ) > 1 );
		
		$query = SQLBuilder::select()->from( ProductEntity::TABLE )->where( "type_id", "=", $allowedCategories[0], $openBrace );
		
		array_shift( $allowedCategories );
		
		$catCount = count( $allowedCategories );
		
		foreach( $allowedCategories as $key => $category )
			$query->or( "type_id", "=", $category, ( $key == ( $catCount - 1 ) ) );
		
		if( $lowerCost !== null )
			$query->and( "cost", ">=", $lowerCost );
		if( $upperCost !== null )
			$query->and( "cost", "<=", $upperCost );
		
		$query->orderby( "id" )->descending();
		$data = $query->limit( $count, $offset )->get();
		
		$entities = [];
		
		foreach($data as $datum)
			$entities[] = ProductEntity::parseOne($datum);
		
		return $entities;
	}
	
	
}
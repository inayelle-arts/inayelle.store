<?php

namespace app\model;

use vendor\core\base\EntityBase;
use vendor\core\database\exception\DatabaseCommonException;

class Admin extends App
{
	/**
	 * @param string $entityName
	 *
	 * @return EntityBase[]
	 */
	public function getEntities( string $entityName ) : array
	{
		/** @var EntityBase $entity */
		$entity = new $entityName();
		$result = [];
		
		try
		{
			return $entity::getAll();
		}
		catch( DatabaseCommonException $exception )
		{
			return [];
		}
	}
	
	public function getEntityFields( string $entityName ) : array
	{
		/** @var EntityBase $entity */
		$entity = new $entityName();
		
		$fieldList[] = "id";
		
		return array_merge( $fieldList, $entity::FIELDS );
	}
	
	public function updateEntity( string $entityName, array $data )
	{
		/** @var EntityBase $entity */
		
		$entityName = "app\\model\\entity\\" . $entityName;
		
		$entity = new $entityName();
		
		$entity = $entity::parseOne( $data );
		
		$entity->update();
	}
	
	public function createEntity( string $entityName, array $data )
	{
		/** @var EntityBase $entity */
		
		$entityName = "app\\model\\entity\\" . $entityName;
		
		$entity = new $entityName();
		
		$entity = $entity::parseOne( $data );
		
		$entity->create();
	}
	
	public function deleteEntity( string $entityName, array $data )
	{
		/** @var EntityBase $entity */
		
		$entityName = "app\\model\\entity\\" . $entityName;
		
		$entity = new $entityName();
		
		$entity = $entity::parseOne( $data );
		
		$entity->delete();
	}
}
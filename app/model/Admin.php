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
}
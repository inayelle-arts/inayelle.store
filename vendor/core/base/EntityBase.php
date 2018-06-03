<?php

namespace vendor\core\base;

use vendor\core\database\SQLBuilder;

/**
 * Class EntityBase
 * @package vendor\core\base
 * @property int $id
 */
abstract class EntityBase
{
	protected const FIELDS = self::FIELDS;
	protected const TABLE  = self::TABLE;
	
	/** @var int $id */
	protected $id = null;
	
	public abstract function __get( string $fieldName );
	
	public abstract function __set( string $fieldName, $value );
	
	public function create()
	{
		$valuesMap = [];
		
		foreach( static::FIELDS as $field )
			$valuesMap[$field] = $this->$field;
		
		$query = SQLBuilder::insert( static::TABLE )->values( $valuesMap );
		$query->post();
		
		$this->id = $query->lastInsertId();
	}
	
	public static function getById( int $id ) : ?EntityBase
	{
		$results = self::getByField("id", $id);
		if (count($results) === 0)
			return null;
		
		return $results[0];
	}
	
	public function update()
	{
		$valuesMap = [];
		
		foreach( static::FIELDS as $field )
			$valuesMap[$field] = $this->$field;
		
		SQLBuilder::update( static::TABLE )
		          ->set( $valuesMap )
		          ->where( "id", "=", $this->id )
		          ->post();
	}
	
	public function delete()
	{
		SQLBuilder::delete()
		          ->from( static::TABLE )
		          ->where( "id", "=", $this->id )
		          ->post();
	}
	
	public static function getAll() : array
	{
		$result = [];
		
		$query = SQLBuilder::select()
		                   ->from( static::TABLE );
		
		$dataArray = $query->get();
		
		foreach( $dataArray as $data )
			$result[] = self::parseOne( $data );
		
		return $result;
	}
	
	public static function getByField( string $field, $value ) : array
	{
		$data = SQLBuilder::select()
		                  ->from( static::TABLE )
		                  ->where( $field, "=", $value )
		                  ->get();
		
		$result = [];
		
		foreach( $data as $datum )
			$result[] = self::parseOne( $datum );
		
		return $result;
	}
	
	private static function parseOne( array $data ) : EntityBase
	{
		$obj = new static();
		
		foreach( static::FIELDS as $field )
			$obj->$field = $data[$field];
		
		$obj->id = $data["id"];
		
		return $obj;
	}
}
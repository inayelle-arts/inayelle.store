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
	protected $id;
	
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
		$results = static::getByField( "id", $id );
		if( count( $results ) === 0 )
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
	
	/**
	 * @return array
	 * @throws \vendor\core\database\exception\ConnectionFailureException
	 * @throws \vendor\core\database\exception\DatabaseCommonException
	 */
	public static function getAll() : array
	{
		$result = [];
		
		$query = SQLBuilder::select()
		                   ->from( static::TABLE );
		
		$dataArray = $query->get();
		
		foreach( $dataArray as $data )
			$result[] = static::parseOne( $data );
		
		return $result;
	}
	
	/**
	 * @param string $field
	 * @param        $value
	 *
	 * @return array
	 * @throws \vendor\core\database\exception\ConnectionFailureException
	 * @throws \vendor\core\database\exception\DatabaseCommonException
	 */
	public static function getByField( string $field, $value ) : array
	{
		$data = SQLBuilder::select()
		                  ->from( static::TABLE )
		                  ->where( $field, "=", $value )
		                  ->get();
		
		$result = [];
		
		foreach( $data as $datum )
			$result[] = static::parseOne( $datum );
		
		return $result;
	}
	
	/**
	 * @param string $field
	 * @param        $value
	 *
	 * @return null|EntityBase
	 * @throws \vendor\core\database\exception\ConnectionFailureException
	 * @throws \vendor\core\database\exception\DatabaseCommonException
	 */
	public static function getByUniqueField( string $field, $value ) : ?EntityBase
	{
		$result = static::getByField( $field, $value );
		if( count( $result ) === 0 )
			return null;
		
		return $result[0];
	}
	
	/**
	 * @param string $field
	 * @param int    $topCount
	 *
	 * @return array
	 * @throws \vendor\core\database\exception\ConnectionFailureException
	 * @throws \vendor\core\database\exception\DatabaseCommonException
	 */
	public static function getFirstRatedByField( string $field, int $topCount ) : array
	{
		$data = SQLBuilder::select()
		                  ->from( static::TABLE )
		                  ->orderby( $field )
		                  ->ascending()
		                  ->limit( $topCount )
		                  ->get();
		
		$result = [];
		
		foreach( $data as $datum )
			$result[] = static::parseOne( $datum );
		
		return $result;
	}
	
	/**
	 * @param string $field
	 * @param int    $downCount
	 *
	 * @return array
	 * @throws \vendor\core\database\exception\ConnectionFailureException
	 * @throws \vendor\core\database\exception\DatabaseCommonException
	 */
	public static function getLastRatedByField( string $field, int $downCount ) : array
	{
		$data = SQLBuilder::select()
		                  ->from( static::TABLE )
		                  ->orderby( $field )
		                  ->descending()
		                  ->limit( $downCount )
		                  ->get();
		
		$result = [];
		
		foreach( $data as $datum )
			$result[] = static::parseOne( $datum );
		
		return $result;
	}
	
	protected static function parseOne( array $data ) : EntityBase
	{
		$obj = new static();
		
		foreach( static::FIELDS as $field )
			$obj->$field = $data[$field];
		
		$obj->id = $data["id"];
		
		return $obj;
	}
	
	public function __toString() : string
	{
		$result = "<pre>" . static::class . ": <br>{<br>";
		$result .= "    id: {$this->id}, <br>";
		foreach( static::FIELDS as $field )
			$result .= "    {$field}: {$this->$field}, <br>";
		
		$result[strlen( $result ) - 6] = " ";
		$result                        .= "}</pre>";
		
		return $result;
	}
}
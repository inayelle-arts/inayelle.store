<?php

namespace vendor\core\database\query;

use PDO;

class UpdateQuery extends QueryBase
{
	public function __construct( PDO $pdo )
	{
		$this->pdo = $pdo;
		parent::__construct( $this );
	}
	
	public function __invoke( string $table ) : self
	{
		$this->statement .= "UPDATE {$table} ";
		return $this;
	}
	
	public function set( array $valuesMap ) : self
	{
		$this->statement .= "SET ";
		
		foreach( $valuesMap as $field => $value )
		{
			$paramKey              = "set{$field}";
			$this->statement       .= "{$field} = :{$paramKey}, ";
			$this->args[$paramKey] = $valuesMap[$field];
		}
		
		$this->statement[strlen( $this->statement ) - 2] = " ";
		
		return $this;
	}
	
	public function where( string $field, string $operator, $value ) : WhereQuery
	{
		return ( new WhereQuery( $this ) )( $field, $operator, $value );
	}
}
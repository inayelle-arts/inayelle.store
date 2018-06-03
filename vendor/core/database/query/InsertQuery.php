<?php

namespace vendor\core\database\query;

use PDO;
use vendor\core\base\EntityBase;

class InsertQuery extends QueryBase
{
	/** @var EntityBase $lastEntity */
	private $lastEntity;
	
	public function __construct( PDO $pdo )
	{
		$this->pdo = $pdo;
		parent::__construct( $this );
	}
	
	public function __invoke( string $table ) : self
	{
		$this->statement .= "INSERT INTO {$table} ";
		
		return $this;
	}
	
	public function values( array $valuesMap ) : self
	{
		$this->statement .= "(";
		
		foreach( $valuesMap as $field => $value )
			$this->statement .= "{$field}, ";
		
		$this->statement[strlen( $this->statement ) - 2] = ") ";
		$this->statement                                 .= " VALUES (";
		
		foreach( $valuesMap as $field => $value )
		{
			$paramKey              = ":value{$field}";
			$this->statement       .= $paramKey . ", ";
			$this->args[$paramKey] = $valuesMap[$field];
		}
		
		$this->statement[strlen( $this->statement ) - 2] = ")";
		
		return $this;
	}
}
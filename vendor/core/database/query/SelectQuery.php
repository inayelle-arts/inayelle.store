<?php

namespace vendor\core\database\query;

use PDO;

class SelectQuery extends QueryBase
{
	public function __construct( PDO $pdo )
	{
		$this->pdo = $pdo;
		parent::__construct( $this );
	}
	
	public function __invoke( string ... $fields ) : self
	{
		$this->statement = "SELECT ";
		if( count( $fields ) === 0 )
			$this->statement .= "*";
		else
		{
			$this->statement .= $fields[0];
			unset( $fields[0] );
			foreach( $fields as $field )
				$this->statement .= ", {$field}";
		}
		
		$this->statement .= " ";
		
		return $this;
	}
	
	public function from( string $table ) : FromQuery
	{
		return ( new FromQuery( $this ) )( $table );
	}
}
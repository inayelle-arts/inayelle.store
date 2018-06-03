<?php

namespace vendor\core\database\query;

class OrderByQuery extends QueryBase
{
	public function __construct( QueryBase $query )
	{
		parent::__construct( $query );
	}
	
	public function __invoke( string $field1, string ... $fields ) : self
	{
		$this->statement .= "ORDER BY ";
		
		$this->statement .= $field1;
		
		foreach( $fields as $field )
			$this->statement .= ", {$field}";
		
		$this->statement .= " ";
		
		return $this;
	}
	
}
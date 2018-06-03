<?php

namespace vendor\core\database\query;


class WhereQuery extends QueryBase
{
	private static $paramCount = 0;
	
	public function __construct( QueryBase $query )
	{
		parent::__construct( $query );
	}
	
	public function __invoke( string $field, string $operator, $value ) : self
	{
		$paramKey        = ":where" . self::$paramCount;
		$this->args[$paramKey] = $value;
		self::$paramCount++;
		
		$this->statement .= "WHERE {$field} {$operator} {$paramKey} ";
		
		return $this;
	}
	
	public function orderby(string $field, string ... $fields) : OrderByQuery
	{
		return (new OrderByQuery($this))($field, ... $fields);
	}
	
	public function and(string $field, string $operator, $value) : self
	{
		$paramKey        = ":andplaceholder" . self::$paramCount;
		$this->args[$paramKey] = $value;
		self::$paramCount++;
		
		$this->statement .= "AND {$field} {$operator} {$paramKey} ";
		
		return $this;
	}
	
	public function or(string $field, string $operator, $value) : self
	{
		$paramKey        = ":orplaceholder" . self::$paramCount;
		$this->args[$paramKey] = $value;
		self::$paramCount++;
		
		$this->statement .= "OR {$field} {$operator} {$paramKey} ";
		
		return $this;
	}
}
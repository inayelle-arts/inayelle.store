<?php

namespace vendor\core\database\query;

class FromQuery extends QueryBase
{
	public function __construct( QueryBase $query )
	{
		parent::__construct($query);
	}
	
	public function __invoke(string $table) : self
	{
		$this->statement .= "FROM {$table} ";
		return $this;
	}
	
	public function where(string $field, string $operator, $value, bool $openBrace = false) : WhereQuery
	{
		return (new WhereQuery($this))($field, $operator, $value, $openBrace);
	}
	
	public function orderby(string $field, string ... $fields) : OrderByQuery
	{
		return (new OrderByQuery($this))($field, ... $fields);
	}
}
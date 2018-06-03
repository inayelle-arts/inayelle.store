<?php

namespace vendor\core\database\query;

use PDO;

class DeleteQuery extends QueryBase
{
	public function __construct( PDO $pdo )
	{
		$this->pdo = $pdo;
		parent::__construct( $this );
	}
	
	public function __invoke() : self
	{
		$this->statement = "DELETE ";
		return $this;
	}
	
	public function from(string $table) : FromQuery
	{
		return (new FromQuery($this))($table);
	}
}
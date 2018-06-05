<?php

namespace vendor\core\database\query;

use PDO;
use PDOException;
use vendor\core\database\exception\DatabaseCommonException;
use vendor\core\database\exception\DuplicateEntryException;

abstract class QueryBase
{
	/** @var PDO $pdo */
	protected $pdo;
	protected $statement;
	protected $args;
	
	protected function __construct( QueryBase $query )
	{
		$this->pdo       = $query->pdo;
		$this->args      = $query->args;
		$this->statement = $query->statement;
	}
	
	public final function get() : array
	{
		try
		{
			$pdoStatement = $this->pdo->prepare( $this->statement );
			$pdoStatement->execute( $this->args );
			return $pdoStatement->fetchAll();
		}
		catch( PDOException $exception )
		{
			switch( $exception->getCode() )
			{
				default:
					throw new DatabaseCommonException( $exception );
					break;
			}
		}
	}
	
	public final function post() : void
	{
		try
		{
			$pdoStatement = $this->pdo->prepare( $this->statement );
			$pdoStatement->execute( $this->args );
		}
		catch( PDOException $exception )
		{
			switch( $exception->getCode() )
			{
				case 23000:
					throw new DuplicateEntryException( $exception );
					break;
				default:
					throw new DatabaseCommonException( $exception );
					break;
			}
		}
	}
	
	public final function lastInsertId( string $idColumnName = "id" ) : int
	{
		return (int)$this->pdo->lastInsertId( $idColumnName );
	}
	
	public function limit( int $count, int $offset = 0 ) : self
	{
		$this->statement .= "LIMIT :limitcount ";
		
		if( $offset !== 0 )
		{
			$this->statement      .= "OFFSET :offset";
			$this->args["offset"] = $offset;
		}
		
		$this->args["limitcount"] = $count;
		
		return $this;
	}
	
	public final function __toString() : string
	{
		return $this->statement;
	}
}
<?php

namespace vendor\core\database;

use PDO;
use PDOException;

use vendor\core\database\exception\ConnectionFailureException;
use vendor\core\database\query\
{
	DeleteQuery, InsertQuery, SelectQuery, UpdateQuery
};

final class SQLBuilder
{
	private function __construct() { }
	
	private static $params = null;
	
	private static function getConnection() : PDO
	{
		$params = $params ?? require CONFIG__ . "/database.php";
		$pdo    = null;
		
		try
		{
			$pdo = new PDO( $params["dsn"], $params["user"], $params["password"], $params["options"] );
		}
		catch( PDOException $exception )
		{
			throw new ConnectionFailureException( $exception );
		}
		
		return $pdo;
	}
	
	public static function forceGet( string $query ) : array
	{
		$connection = self::getConnection();
		$statement  = $connection->prepare( $query );
		$statement->execute();
		return $statement->fetchAll();
	}
	
	public static function forcePost( string $query ) : void
	{
		$connection = self::getConnection();
		$statement  = $connection->prepare( $query );
		$statement->execute();
	}
	
	public static function select( string ... $fields ) : SelectQuery
	{
		$connection = self::getConnection();
		$query      = new SelectQuery( $connection );
		return $query( ...$fields );
	}
	
	public static function insert( string $targetTable ) : InsertQuery
	{
		$connection = self::getConnection();
		return ( new InsertQuery( $connection ) )( $targetTable );
	}
	
	public static function delete() : DeleteQuery
	{
		$connection = self::getConnection();
		return ( new DeleteQuery( $connection ) )();
	}
	
	public static function update( string $targetTable ) : UpdateQuery
	{
		$connection = self::getConnection();
		return ( new UpdateQuery( $connection ) )( $targetTable );
	}
}
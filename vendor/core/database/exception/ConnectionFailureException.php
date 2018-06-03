<?php

namespace vendor\core\database\exception;

use Exception;
use PDOException;
use Throwable;

class ConnectionFailureException extends DatabaseCommonException
{
	public function __construct( PDOException $previous = null )
	{
		$message = "Connection to database failed";
		parent::__construct( $message, $previous->getCode(), $previous );
	}
}
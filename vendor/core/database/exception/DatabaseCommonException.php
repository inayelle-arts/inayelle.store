<?php

namespace vendor\core\database\exception;

use Throwable;

class DatabaseCommonException extends \Exception
{
	public function __construct( string $message = "", $code = 0, Throwable $previous = null )
	{
		parent::__construct( $message, $code, $previous );
	}
}
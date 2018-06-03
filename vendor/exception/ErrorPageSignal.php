<?php

namespace vendor\exception;

use Exception;
use Throwable;

class ErrorPageSignal extends Exception
{
	public function __construct( int $errorcode, string $message = "", Throwable $innerException = null )
	{
		parent::__construct( $message, $errorcode, $innerException );
	}
}
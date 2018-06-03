<?php

namespace vendor\core\database\exception;

use Exception;
use Throwable;

class DuplicateEntryException extends DatabaseCommonException
{
	public function __construct( Throwable $previous )
	{
		parent::__construct( "Duplicate entry exception", 23000, $previous );
	}
}
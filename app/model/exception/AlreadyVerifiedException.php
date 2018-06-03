<?php

namespace app\model\exception;

use Throwable;

class AlreadyVerifiedException extends \Exception
{
	public function __construct( string $message = "", int $code = 0, Throwable $previous = null )
	{
		parent::__construct( $message, $code, $previous );
	}
}
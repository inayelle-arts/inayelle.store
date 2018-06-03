<?php

namespace app\model\exception;

use Throwable;

class BadVerificationCodeException extends \Exception
{
	public function __construct( string $message = "", int $code = 0, Throwable $previous = null ) { parent::__construct( $message, $code, $previous ); }
	
}
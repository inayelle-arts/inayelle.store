<?php

namespace vendor\auxiliary;

final class ErrorPagesSender
{
	public const PAGE_NOT_FOUND = 404;
	public const FORBIDDEN      = 403;
	public const MAINTENANCE    = 503;
	public const INTERNAL_ERROR = 503;
	
	private function __construct() { }
	
	public static function sendErrorPage( int $errorCode, string $message = "" ) : void
	{
		require_once ERROR_PAGES__ . "/{$errorCode}.php";
		exit( $errorCode );
	}
}
<?php


namespace vendor\exception;

use Exception;

class TypeMismatchException extends Exception
{
	private $gotType;
	private $expectedType;
	
	public function __construct( string $expectedType, string $gotType )
	{
		$this->expectedType = $expectedType;
		$this->gotType      = $gotType;
		
		$message = "Type mismatch. Expected type: [{$expectedType}], got [" . $this->gotType . "]";
		parent::__construct( $message );
	}
	
	public function getExpectedType()
	{
		return $this->expectedType;
	}
	
	public function getGotType()
	{
		return $this->gotType;
	}
}
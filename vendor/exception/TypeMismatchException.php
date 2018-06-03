<?php


namespace vendor\exception;

use Exception;

class TypeMismatchException extends Exception
{
	private $item;
	private $gotType;
	private $expectedType;
	
	public function __construct( $item, string $expectedType )
	{
		$this->expectedType = $expectedType;
		$this->gotType      = get_class( $item );
		$this->item         = $item;
		
		$message = "Type mismatch. Expected type: [{$expectedType}], got [" . $this->gotType . "]";
		parent::__construct( $message );
	}
	
	public function getItem()
	{
		return $this->item;
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
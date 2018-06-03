<?php

namespace vendor\exception;

use Exception;

class ClassNotFoundException extends Exception
{
	private $className;
	
	public function __construct(string $className)
	{
		$this->className = $className;
	}
	
	public function getClassName() : string
	{
		return $this->className;
	}
}